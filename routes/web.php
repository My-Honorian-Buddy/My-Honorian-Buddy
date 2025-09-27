<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Auth\StudentController;
use App\Http\Controllers\Auth\ScheduleController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\MatchController;
use App\Http\Controllers\Auth\TutorController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\StudentSubjectController;
use App\Http\Controllers\Auth\TutorSubjectController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\GoogleCalendarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\Auth\AiController;
use App\Http\Controllers\Chatify\MessagesController;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\studentSubject;
use App\Models\Task;
use App\Http\Controllers\Auth\RewardRedemptionController;
use App\Models\Tutor;
use App\Models\ToDoLists;
use App\Models\tutorSubject;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RoleSwitchController;
use App\Http\Controllers\Auth\CorController;
use App\Models\RewardRedemption;
use App\Http\Controllers\EventController;
use App\Events\NewNotification;

Route::get('/broadcast', function(){
    $message = "Hello World";
    $id = Auth::user()->id;
    broadcast(new NewNotification($message, $id));
    return 'Message broadcasted.';
});

// paayos route pag okay na sainyo function nya :>
// TEMPO COR VERIFY PAGE

Route::get('/trynotif', function () {
    return view('notifsomething');
});

Route::get('/jca', function () {
    return view('auth.verify-cor');
});

// UPLOAD COR
Route::get('/cor-verification', [CorController::class, 'view'])
    ->middleware('auth')
    ->name('cor.view');

Route::post('/upload-cor', [CorController::class, 'upload'])->name('cor.upload');

Route::get('/son', function () {
    return view('redeemed-rewards');
});

Route::get('/', function () {
    return view('landing-page');
})->name('landing-page');

Route::get('/rewards', [RewardRedemptionController::class, 'index'])->name('rewards.view');
Route::post('/rewards/redeem/{rewardID}', [RewardRedemptionController::class, 'redeem'])->name('rewards.redeem');
Route::get('/view/rewards', [RewardRedemptionController::class, 'myRedemptions'])->name('rewards.myRedemptions');
Route::post('/claim/rewards/{claimID}', [RewardRedemptionController::class, 'claimReward'])->name('rewards.claim');

Route::get('/contactus', function () {
    return view('contact-us');
})->name('contact-us');


Route::get('/api/notifications/status', function () {
    return response()->json(['hasNotification' => Auth::user()->hasNotification]);
})->middleware('auth');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile/edit-profile', function () {
        return view('profile.tutor.edit-profile');
    })->name('profile.edit-profile');
    Route::get('/profile/account-settings', function () {
        return view('profile.tutor.account-settings');
    })->name('profile.account-settings');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/account-settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/updateProfile', [ProfileController::class, 'uploadProfilePicture'])->name('picture.upload');
});

Route::get('/email/verify', function() {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/choose-role');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', [ProfileController::class, 'sendEmailVerificationNotification'
// ])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/auth/google',[GoogleAuthController::class,'redirect'])->name('google.auth');
Route::get('/auth/google/call-back',[GoogleAuthController::class,'callbackGoogle']); 

Route::get('/show', function () {

    $users = User::all();
    return view('show.index', compact('users'));
});

Route::get('/show/subjects', function () {
    $students = Student::all();
    $schedules = Schedule::all();
    return view('show.index_subject', compact('students'));
});

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/choose-role', [RoleController::class, 'roleSelect'])->name('role.select');
    Route::post('/select-role', [RoleController::class, 'storeRole'])->name('role.store');

    Route::prefix('profiling')->group(function () {
        Route::get('/student', function () {
            return view('settingup-profile.studentUser');
        })->name('profile.student');

        Route::post('/student', [StudentController::class, 'store'])->name('profile.student.store');

        Route::get('/student/department', function () {
            return view('settingup-profile.yearlevel-program');
        })->name('department.student');

        Route::post('/student/department', [StudentController::class, 'store_dept'])->name('department.student.store');

        Route::get('/tutor', function () {
            return view('settingup-profile.tutorUser');
        })->name('profile.tutor');

        Route::post('/tutor', [TutorController::class, 'store'])->name('profile.tutor.store');

        Route::get('/tutor/department', function () {
            return view('settingup-profile.tutor-yearlevel-program');
        })->name('department.tutor');
        Route::post('/tutor/department', [TutorController::class, 'store_dept'])->name('department.tutor.store');

        });

        // Route::get('/tutor/experience', function () {
        //     return view('settingup-profile.tutor-rate-and-exp');
        // })->name('experience.tutor');

        Route::post('/tutor/experience', [TutorController::class, 'store_exp'])->name('experience.tutor.store');
        Route::get('/schedule', [ScheduleController::class, 'create'])->name('user.schedule');
        Route::post('/schedule', [ScheduleController::class, 'store'])->name('user.schedule.store');
        
    });

    Route::middleware(['auth', 'verified'])->group(function () {

        Route::get('/subjects/tutor', [TutorSubjectController::class, 'create'])->name('tutor.create');
        Route::post('/subjects/tutor/store', [TutorSubjectController::class, 'store'])->name('tutor.store');

        Route::get('/subjects/student', [StudentSubjectController::class, 'create'])->name('subjects.create');
        Route::post('/subjects/student/store', [StudentSubjectController::class, 'store'])->name('subjects.store');
        
    });

    Route::middleware('auth')->group(function () {

        Route::get('/workspace', [TaskController::class, 'index'])->name('workspace.start');
        
        Route::prefix('workspace')->group(function () {
            Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
            Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
            Route::delete('/tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete');

            Route::get('/profile', function () {return view('profile.tutor.profile');}) ->name('tutor.profile');

        });

        Route::post('/session',[SessionController::class,'SessionComplete'])->name('complete.session');
        Route::post('/end/session', [SessionController::class, 'dropSession'])->name('drop.session');
        //Video Call Controller Routes
        Route::get('/video-call/join', [VideoCallController::class, 'handleJoinMeet'])->name('video.join.meet');
        Route::get('/video-call/create/', [VideoCallController::class, 'createRoom'])->name('video.call.create');
        
        Route::get('/video-call/ended',[VideoCallController::class, 'participantLeft'])->name('participant.left');
        Route::get('/video-call/{roomName}', function ($roomName) { return view('components.vc.videocall', compact('roomName')); })->name('video.call.room');
    });
    
    //Notification Controller Routes
    Route::middleware('auth')->group(function () {
        Route::get('/user-notifications', [NotificationController::class, 'getUserNotifications'])->name('user.notifications');
        
        Route::post('/notifications/{id}/read', [NotificationController::class,'markAsRead'])->name('notification.read');
        Route::delete('/notifications/{id}/delete', [NotificationController::class, 'deleteNotification'])->name('notification.delete');
        Route::post('/notifications/mark-all-as-read', [NotificationController::class,'markAllAsRead'])->name('notification.markAllAsRead');
        Route::delete('/notifications/delete-all', [NotificationController::class, 'deleteAllNotifications'])->name('notification.deleteAll');
            
        Route::post('/notifications/session-confirm/{notification}', [NotificationController::class, 'sessionConfirm']);
        Route::post('/notifications/tutor-request/{id}', [NotificationController::class, 'handleTutorRequest'])->name('notifications.tutor-request');
            
  
        Route::get('/check-notifications', [NotificationController::class, 'hasUnreadNotifications'])->name('check.notifications');
    });

    // Route::get('/check-payment-status', function () {
    //     Artisan::call('payment:check-status'); // Call the Artisan command
    //     return response()->noContent(); // Return a 204 No Content response
    // });

    

    //not working yet, for future if ever
    Route::middleware(['auth'])->group(function () {
        Route::get('/chaty', function () { return view('components.settingUp_profile.chat'); })->name('chaty');
        Route::post('/chatty', [AiController::class, 'chatty'])->name('chatty.send');
        Route::get('/about', function () { return view('aboutus'); })->name('about');
        Route::get('/contact-us', function () { return view('contact-us'); })->name('contact-us');
    });
    
    Route::middleware(['auth', 'verified'])->group(function () {

        Route::get('/find-buddy', [MatchController::class, 'view'])->name('match.explore');
        
        Route::post('/ai-matching-result', [MatchController::class, 'showMatches'])->name('ai-matching-result');

        Route::get('/explore/manual', [TutorController::class, 'showWebAndSearch'])->name('tutor.search'); //explore-manual
        Route::get('/explore/card', [TutorController::class, 'showCard'])->name('show.card');
    });

    
    Route::get('/tutor/profile', [TaskController::class, 'connectTutor'])->name('connect.tutor');
    Route::get('/student/profile', [TaskController::class, 'connectStudent'])->name('connect.student');

    
    // Route::get('/sampleslot', function () {
    //     $todolists = ToDoLists::all();
    //     return view('sampleslot', compact('todolists'));
    // });

    Route::post('notif/session/store', [SessionController::class, 'notifStore'])->name('notif.store');
    
    // Route::get('/google-calendar', [GoogleCalendarController::class, 'showCalendar'])->name('workspace'); 
    // Route::get('/google-calendar/redirect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.auth.calendar');
    // Route::get('/google-calendar/callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');

    // Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/view/reviews', [ReviewController::class, 'index'])->name('reviews.show');

     Route::post('/switch-role', [RoleSwitchController::class, 'switchRole'])->name('role.switch');

    Route::get('/calendar/event', [EventController::class, 'index']);
    Route::post('/calendar/action', [EventController::class, 'action']);