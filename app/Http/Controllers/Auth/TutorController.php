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
            
        return redirect()->route('experience.tutor');
    }

    public function store_exp(Request $request){

        $request->validate([
            'rate_session' => ['required', 'numeric', 'max:50000'],
            'exp' => ['required', 'string', 'max:255'],
            'gcash' => ['required', 'string', 'max:255'],
            'grabpay' => ['nullable', 'string', 'max:255'],
            'maya' => ['nullable', 'string', 'max:255'],

        ]);

        $userID = Auth::id();

        $tutor = Tutor::create([
           'user_id' => $userID,
           'fname' => Session::get('first_name'),
           'lname' => Session::get('last_name'),
           'gender' => Session::get('gend'),
           'address' => Session::get('add'),
           'rate_session' => $request->input('rate_session', 0),
           'exp' => $request->input('exp', 0),
           'gcash' => $request->input('gcash'),
           'grabpay' => $request->input('grabpay'),
           'maya' => $request->input('maya'),
           'bio' => Session::get('bio_tutor'),
            
        ]);

    
        Session::forget(['first_name', 'last_name', 'gend', 'add', 'bio_tutor']);

        return redirect()->route('tutor.create');
    }

    public function showCard(){
        $users = User::all();

        Log::info('All users:', $users->toArray());

        return view('components.card', ['users' => $users]);
    }

    public function showWebAndSearch(Request $request){
        $tutors = Tutor::all();
        $tutorsSubjects = Tutor::with('subject_tutor')->get();
        $subjects = tutorSubject::all();
        try {
            $validator = Validator::make($request->all(), [
                'days' => 'nullable|array',
                'experience' => 'nullable|array',
                'price_range' => 'nullable|string|in:any,custom',
                'min_price' => 'nullable|numeric|required_if:price_range,custom',
                'max_price' => 'nullable|numeric|required_if:price_range,custom',
                'rating' => 'nullable|numeric|min:0|max:5',
                'query' => 'nullable|string',
            ]);

            if($validator->fails()){
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $days = $request->input('days', []);
            $experience = $request->input('experience', []);
            $priceRange = $request->input('price_range', 'any');
            $minPrice = $request->input('min_price', null);
            $maxPrice = $request->input('max_price', null);
            $rating = $request->input('rating', 0);
            $query = $request->input('query', '');

            Log::info('Selected days: ', $days);
            Log::info('Selected experience: ', $experience);
            Log::info('Selected price range: ', ['price_range' => $priceRange,'min' => $minPrice, 'max' => $maxPrice]);
            Log::info('Selected Query: ', ['query' => $query]);
            Log::info('Selected Rating: ', ['rating' => $rating]);
            

            if (!is_array($days)){
                $days = json_decode($days, true);
            }

            if($priceRange === 'custom'){
                if($minPrice === null || $maxPrice === null){
                    return redirect()->back()->withErrors(['min_price' => 'Minimum price is required', 'max_price' => 'Maximum price is required']);
                }
            }

            try{
                $users = User::with('tutor', 'schedule')->where('role', 'tutor')->get();
                Log::info('All tutors with their schedules:', $users->toArray());

            }catch(\Exception $e){
                Log::error('Error fetching tutors: ' . $e->getMessage());
                return redirect()->back()->withErrors(['message' => 'Error fetching tutors']);
            }
                $search = User::where('role', 'tutor')
                ->whereHas('schedule', function ($query) use ($days) {
                $query->where(function($query) use ($days) {
                foreach($days as $day){
                    $query->orWhereJsonContains('days_week', $day);
                }
                session(['initiator' => 'filter-page']);
                 });
            });

            if(!empty($experience)){
                $search->whereHas('tutor', function ($query) use ($experience) {
                    $query->whereIn('exp', $experience);
                });
            }

            if($priceRange ==='custom' && $minPrice !== null && $maxPrice !== null){
                $search->whereHas('tutor', function ($query) use ($minPrice, $maxPrice) {
                    $query->whereBetween('rate_session', [$minPrice, $maxPrice]);
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


            $search = $search->get();

            Log::info('Filtered tutors based on days:', $search->toArray());

            Log::info('Users variable:', ['users' => $users]);
            Log::info('Search variable:', ['search' => $search]);
        
            return view('explore-manual', compact('users', 'search'));

        } catch (\Exception $e) {
            Log::error('Error in showWebAndSearch function: ', ['error' => $e->getMessage()] );
            return redirect()->back()->withErrors(['message' => 'Error in showWebAndSearch function']);
        }
    }
}
