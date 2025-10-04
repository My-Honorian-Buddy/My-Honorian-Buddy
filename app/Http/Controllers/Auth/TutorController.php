<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tutor;
use App\Models\tutorSubject;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

use function PHPUnit\Framework\isEmpty;

class TutorController extends Controller
{
    // public function create(){
    //     return view('components.settingUp_profile.tutor');
    // }

    public function store(Request $request){

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gend' => ['required', 'string', 'max:255'],
            'add' => ['required', 'string', 'max:255'],
            'bio_tutor' => ['nullable', 'string', 'max:255'],
        ]);

            Session::put('first_name', $request->first_name);
            Session::put('last_name', $request->last_name);
            Session::put('gend', $request->gend);
            Session::put('add', $request->add);
            Session::put('bio_tutor', $request->bio_tutor);
            
        return redirect()->route('department.tutor');
    }

    public function store_dept(Request $request){

        $request->validate([
            'year_level' => ['required', 'string', 'max:255'],
            'college' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],

        ]);

        $userID = Auth::id();

        $tutor = Tutor::create([
        'user_id' => $userID,
        'fname' => Session::get('first_name'),
        'lname' => Session::get('last_name'),
        'gender' => Session::get('gend'),
        'address' => Session::get('add'),
        'year_level' => $request->year_level,
        'department' => $request->department,
        'college' => $request->college,
        'bio' => Session::get('bio_tutor'),
        ]);

            Session::forget(['first_name', 'last_name', 'gend', 'add', 'bio_tutor']);
            
            return redirect()->route('tutor.create');
        
    }
    
    public function showCard(){
        $users = User::with('tutor', 'schedule')
        ->whereHas('tutor')
        ->verified()
        ->paginate(2);

        Session::forget('initiator');

        return view('components.card', ['users' => $users]);
    }

    public function showWebAndSearch(Request $request){
        $tutors = Tutor::all();
        $tutorsSubjects = Tutor::with('subject_tutor')->get();
        $subjects = tutorSubject::all();
        
        try {
            $validator = Validator::make($request->all(), [
                'days' => 'nullable|array',
                // 'experience' => 'nullable|array',
                'exp_range' => 'nullable|string|in:any,custom',
                'min_exp' => 'nullable|numeric|required_if:exp_range,custom',
                'max_exp' => 'nullable|numeric|required_if:exp_range,custom',
                'rating' => 'nullable|numeric|min:0|max:5',
                'query' => 'nullable|string',
                'sort' => 'nullable|string|in:asc,desc',
            ]);

            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $days = $request->input('days', []);
            // $experience = $request->input('experience', []);
            $expRange = $request->input('exp_range', 'any');
            $minExp = $request->input('min_exp', null);
            $maxExp = $request->input('max_exp', null);
            $rating = $request->input('rating', 0);
            $query = $request->input('query', '');
            $sort = $request->input('sort', 'asc');

            Log::info('Selected days: ', $days);
            // Log::info('Selected experience: ', $experience);
            Log::info('Selected experience range: ', ['exp_range' => $expRange,'min' => $minExp, 'max' => $maxExp]);
            Log::info('Selected Query: ', ['query' => $query]);
            Log::info('Selected Rating: ', ['rating' => $rating]);
            Log::info('Selected Sort: ', ['sort' => $sort]);
            

            if (!is_array($days)){
                $days = json_decode($days, true);
            }

            if($expRange === 'custom'){
                if($minExp === null || $maxExp === null){
                    return redirect()->back()->withErrors(['min_exp' => 'Minimum experience is required', 'max_exp' => 'Maximum experience is required']);
                }
            }

            try{

                $users = User::with('tutor', 'schedule')
                ->whereHas('tutor')
                ->where('cor_status', 'verified')
                ->paginate(2);
                
                Log::info('All tutors with their schedules:', $users->toArray());

            }catch(\Exception $e){
                Log::error('Error fetching tutors: ' . $e->getMessage());
                return redirect()->back()->withErrors(['message' => 'Error fetching tutors']);
            }
                $search = User::whereHas('tutor')
                ->with('tutor', 'schedule')
                ->where('cor_status', 'verified')
                ->orderBy(User::select('fname')->from('tutors')->whereColumn('users.id', 'tutors.user_id'), $sort);

                if (!empty($days)) {
                    $search->whereHas('schedule', function ($query) use ($days) {
                        $query->where(function($query) use ($days) {
                            foreach($days as $day){
                                $query->orWhereJsonContains('days_week', $day);
                            }
                        });
                    });
                }

            // if(!empty($experience)){
            //     $search->whereHas('tutor', function ($query) use ($experience) {
            //         $query->whereIn('exp', $experience);
            //     });
            // }

            if($expRange ==='custom' && $minExp !== null && $maxExp !== null){
                $search->whereHas('tutor', function ($query) use ($minExp, $maxExp) {
                    $query->whereBetween('exp', [$minExp, $maxExp]);
                });
            }

            if(!empty($query)){
                $search->where(function ($q) use ($query){
                    $q->whereHas('tutor', function ($que) use ($query){
                        $que->where('fname', 'like', '%' . $query . '%')
                        ->orWhere('lname', 'like', '%' . $query . '%')
                        ->orWhereHas('subject_tutor', function ($q) use ($query){
                            $q->where('subj_code', 'like', '%' . $query . '%')
                                ->orWhere('subj_name', 'like', '%' . $query . '%');
                        });

                    });
                });
            }

            if($rating > 0){
                $search->whereHas('tutor', function ($query) use ($rating) {
                    $query->where('rating', '>=', $rating);
                });
            }


            $search = $search->paginate(2);

            Log::info('Filtered tutors based on days:', $search->toArray());

            Log::info('Users variable:', ['users' => $users]);
            Log::info('Search variable:', ['search' => $search]);
            Log::info('Request Data', $request->all());
            
            Session::put('initiator', 'filter-page');
            return view('explore-manual-copy', compact('users', 'search'));

        } catch (\Exception $e) {
            Log::error('Error in showWebAndSearch function: ', ['error' => $e->getMessage()] );
            return redirect()->back()->withErrors(['message' => 'Error in showWebAndSearch function']);
        }
    }
}
