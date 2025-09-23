<?php

namespace App\Filament\Pages;


use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Student;
use App\Models\Tutor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Actions\Action;
use App\Notifications\CorVerificationNotification;
use Illuminate\Support\Facades\Log;
use App\Models\NotifSession;
use App\Models\User;
use App\Events\NewNotification;


class SendCorNotification extends Page implements Forms\Contracts\HasForms
{

    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'Admin Tools';
    protected static ?string $navigationLabel = 'Send COR Verification';

    protected static string $view = 'filament.pages.send-cor-notification';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }


    public function form(Form $form): Form
    {
        return $form -> schema([
            Select::make('recipientType')
                ->label ('Send to')
                ->options([
                    'students' => 'Students',
                    'tutors' => 'Tutors',
                    'both' => 'Both Students & Tutors',
                ]) ->required(),

                TextInput::make('schoolYear')
                ->label('School Year')
                ->placeholder('eg. 2022-2023')
                ->required(),
        ]) ->statePath('data');
    }

    public function send (){
        $data = $this->form->getState();
        

        $schoolYear = $data['schoolYear'];
        $recipientType = $data['recipientType'];
        broadcast(new NewNotification($schoolYear));
        Log::info("Recipient type selected: " . $recipientType);

        $payLoad = [
            'NotifType' => 'CorVerification',
            'message' => 'Please Verify your COR for '.$schoolYear.'!',
            'schoolYear' => $schoolYear
        ];

        // if ($recipientType === 'students' || $recipientType === 'both') {
        //     $students = Student::all();
        //     foreach ($students as $student) {
        //         NotifSession::create([
        //             'notif_info' => json_encode($payLoad),
        //             'to' => $student->id,
        //             'user_id' => $student->user_id
        //         ]);

        //         $user = User::find($student->user_id);
        //         if($user){
        //             $user->update(['hasNotification' => true]);
        //         }
        //          Log::info("Notification sent to student {$student->id}");
        //     }
        // }

        if($recipientType === 'students'){
            $recipients = User::where('role', 'student')->get();
        } elseif ($recipientType === 'tutors') {
            $recipients = User::where('role', 'tutor')->get();
        } elseif ($recipientType === 'both') {
            $recipients = User::whereIn('role', ['student', 'tutor'])->get();
        }

        // if ($recipientType === 'tutors' || $recipientType === 'both') {
        //     $tutors = Tutor::all();
        //     foreach ($tutors as $tutor) {
        //         NotifSession::create([
        //             'notif_info' => json_encode($payLoad),
        //             'to' => $tutor->id,
        //             'user_id' => $tutor->user_id
                
        //         ]);

        //         $user = User::find($tutor->user_id);
        //         if($user){
        //             $user->update(['hasNotification' => true]);
        //         }

        //         Log::info("Notification sent to tutor {$tutor->id}");
        //     }
        // }

        foreach ($recipients as $user) {
            NotifSession::create([
                'notif_info' => json_encode($payLoad),
                'to' => $user->id,
                'user_id' => $user->id
            ]);
            $user->update(['hasNotification' => true]);
            Log::info("Notification sent to user {$user->id}");
        }
        
        Notification::make()
            ->title('COR Notification Sent')
            ->body('Successfully sent COR notification to all recipients.')
            ->success()
            ->send();
    }
}
