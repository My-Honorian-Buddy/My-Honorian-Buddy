<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookedSessionResource\Pages;
use App\Filament\Resources\BookedSessionResource\RelationManagers;
use App\Models\BookedSession;
use App\Models\Tutor;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Illuminate\Http\HtmlString;
use App\Models\Review;
use App\Models\BannedSessionArchive;

class BookedSessionResource extends Resource
{
    protected static ?string $model = BookedSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationLabel = 'Tutoring History';
    
    protected static ?string $modelLabel = 'Tutoring Session';
    
    protected static ?string $pluralModelLabel = 'Tutoring History';
    
    protected static ?string $navigationGroup = 'Session Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Session Information')
                    ->schema([
                        Forms\Components\Select::make('student_id')
                            ->label('Student')
                            ->relationship('studentUser', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('tutor_id')
                            ->label('Tutor')
                            ->relationship('tutorUser', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('tutoring_subject')
                            ->label('Subject / Topic')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DateTimePicker::make('schedule_time')
                            ->label('Session Date & Time')
                            ->required()
                            ->seconds(false),
                        Forms\Components\TextInput::make('duration')
                            ->label('Duration (minutes)')
                            ->required()
                            ->numeric()
                            ->suffix('mins'),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('room')
                            ->label('Room/Location')
                            ->maxLength(255),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Session Details')
                    ->schema([
                        Forms\Components\TextInput::make('num_session')
                            ->label('Session Number')
                            ->numeric()
                            ->default(1),
                        Forms\Components\TextInput::make('total_session')
                            ->label('Total Sessions')
                            ->numeric()
                            ->default(1),
                        Forms\Components\Toggle::make('is_completed')
                            ->label('Completed'),
                        Forms\Components\Toggle::make('admin_approved')
                            ->label('Admin Approved for Completion')
                            ->helperText('Enable this to allow tutor to complete the session'),
                        Forms\Components\Toggle::make('reviewed')
                            ->label('Reviewed'),
                        Forms\Components\DatePicker::make('sesUpdate')
                            ->label('Last Update Date'),
                    ])->columns(3),
                    
                Forms\Components\Section::make('Feedback')
                    ->schema([
                        Forms\Components\Textarea::make('feedback')
                            ->label('Session Feedback')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tutorUser.name')
                    ->label('Tutor Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->icon('heroicon-m-user-circle')
                    ->iconColor('success'),
                    
                Tables\Columns\TextColumn::make('studentUser.name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->iconColor('primary'),
                    
                Tables\Columns\TextColumn::make('tutoring_subject')
                    ->label('Subject/Topic')
                    ->searchable()
                    ->wrap()
                    ->limit(30)
                    ->formatStateUsing(fn ($state) => is_string($state) ? implode(', ', json_decode($state, true) ?? [$state]) : $state),
                    
                Tables\Columns\TextColumn::make('schedule_time')
                    ->label('Session Date & Time')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->icon('heroicon-m-calendar')
                    ->iconColor('warning'),
                    
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->formatStateUsing(function ($state, $record) {
                        // Divide by 2 since both participants send duration (gets doubled)
                        $totalMinutes = (int) (($record->duration ?? 0) / 2);
                        
                        if ($totalMinutes <= 0) {
                            return '0m 0s';
                        }
                        
                        $hours = floor($totalMinutes / 60);
                        $minutes = $totalMinutes % 60;
                        $seconds = 0;
                        
                        if ($hours > 0) {
                            return $minutes > 0 
                                ? "{$hours}h {$minutes}m {$seconds}s" 
                                : "{$hours}h {$seconds}s";
                        }
                        
                        return "{$minutes}m {$seconds}s";
                    })
                    ->description(function ($state, $record) {
                        // Divide by 2 to show actual duration
                        $duration = (int) (($record->duration ?? 0) / 2);
                        return $duration > 0 ? "Total: {$duration} minutes" : 'No duration';
                    })
                    ->alignCenter()
                    ->sortable()
                    ->tooltip(function ($state, $record) {
                        // Divide by 2 to show actual duration
                        $duration = (int) (($record->duration ?? 0) / 2);
                        return $duration > 0 ? "Total duration: {$duration} minutes" : 'No duration recorded';
                    }),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'ongoing' => 'info',
                        'approved' => 'primary',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'completed' => 'heroicon-m-check-circle',
                        'ongoing' => 'heroicon-m-arrow-path',
                        'approved' => 'heroicon-m-hand-thumb-up',
                        'pending' => 'heroicon-m-clock',
                        'cancelled' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->state(function (bookedSession $record): ?int {
                        $review = Review::where('tutor_id', $record->tutor_id)
                            ->where('student_id', $record->student_id)
                            ->first();
                        return $review?->rating;
                    })
                    ->formatStateUsing(fn ($state) => $state ? str_repeat('⭐', (int) $state) . " ({$state}/5)" : '(N/A/5)')
                    ->sortable(false),
                    
                Tables\Columns\TextColumn::make('session_progress')
                    ->label('Session Progress')
                    ->state(function (bookedSession $record): string {
                        return ($record->num_session ?? 0) . ' / ' . ($record->total_session ?? 0);
                    })
                    ->badge()
                    ->color(fn (bookedSession $record) => $record->num_session == $record->total_session ? 'success' : 'warning')
                    ->alignCenter(),
                    
                Tables\Columns\IconColumn::make('is_completed')
                    ->label('Completed')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),
                    
                Tables\Columns\IconColumn::make('admin_approved')
                    ->label('Admin Approved')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->alignCenter()
                    ->tooltip(fn (bookedSession $record): string => 
                        $record->admin_approved 
                            ? 'Approved - Tutor can complete session' 
                            : 'Not approved - Tutor cannot complete session yet'
                    ),
                    
                Tables\Columns\TextColumn::make('ban_status')
                    ->label('Ban Status')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'pending' => 'warning',
                        'report_submitted' => 'info',
                        'approved' => 'danger',
                        'rejected' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Pending Report',
                        'report_submitted' => 'Report Submitted',
                        'approved' => 'Ban Approved',
                        'rejected' => 'Ban Rejected',
                        default => 'No Ban Request',
                    })
                    ->alignCenter()
                    ->tooltip(fn (bookedSession $record): ?string => 
                        $record->ban_requested 
                            ? 'Reason: ' . ($record->ban_reason ?? 'No reason') 
                            : null
                    )
                    ->toggleable(isToggledHiddenByDefault: false),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Booked On')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('schedule_time', 'desc')
            ->filters([
                
                SelectFilter::make('tutor')
                    ->relationship('tutorUser', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Tutor'),
                    
                
                SelectFilter::make('student')
                    ->relationship('studentUser', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Student'),
                    
                
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Filter by Status'),
                    
                        
                Filter::make('schedule_time')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('schedule_time', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('schedule_time', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators['from'] = 'From ' . \Carbon\Carbon::parse($data['from'])->toFormattedDateString();
                        }
                        if ($data['until'] ?? null) {
                            $indicators['until'] = 'Until ' . \Carbon\Carbon::parse($data['until'])->toFormattedDateString();
                        }
                        return $indicators;
                    }),
                    
                
                Filter::make('is_completed')
                    ->label('Completed Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_completed', true)),
                    
                
                Filter::make('reviewed')
                    ->label('Reviewed Only')
                    ->query(fn (Builder $query): Builder => $query->where('reviewed', true)),
                    
                
                SelectFilter::make('ban_status')
                    ->options([
                        'pending' => 'Ban Pending',
                        'report_submitted' => 'Report Submitted',
                        'approved' => 'Ban Approved',
                        'rejected' => 'Ban Rejected',
                    ])
                    ->label('Filter by Ban Status'),
                    
                
                Filter::make('ban_requested')
                    ->label('Ban Requested')
                    ->query(fn (Builder $query): Builder => $query->where('ban_requested', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Session Details')
                    ->modalWidth('5xl'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggleApproval')
                    ->label(fn (bookedSession $record) => $record->admin_approved ? 'Revoke Approval' : 'Approve Completion')
                    ->icon(fn (bookedSession $record) => $record->admin_approved ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn (bookedSession $record) => $record->admin_approved ? 'danger' : 'success')
                    ->requiresConfirmation()
                    ->modalHeading(fn (bookedSession $record) => $record->admin_approved ? 'Revoke Completion Approval' : 'Approve Session Completion')
                    ->modalDescription(fn (bookedSession $record) => $record->admin_approved 
                        ? 'Are you sure you want to revoke completion approval? The tutor will not be able to complete this session.'
                        : 'Are you sure you want to approve this session for completion? The tutor will be able to mark it as complete.'
                    )
                    ->modalSubmitActionLabel(fn (bookedSession $record) => $record->admin_approved ? 'Revoke' : 'Approve')
                    ->action(function (bookedSession $record) {
                        $record->admin_approved = !$record->admin_approved;
                        $record->save();
                        
                        \Filament\Notifications\Notification::make()
                            ->title($record->admin_approved ? 'Session Approved' : 'Approval Revoked')
                            ->body($record->admin_approved 
                                ? 'The tutor can now complete this session.' 
                                : 'The tutor can no longer complete this session.'
                            )
                            ->success()
                            ->send();
                    })
                    ->visible(fn (bookedSession $record) => $record->num_session >= $record->total_session && !$record->is_completed),
                Tables\Actions\Action::make('ban')
                    ->label('Request Ban')
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('warning')
                    ->form([
                        Forms\Components\Textarea::make('ban_reason')
                            ->label('Reason for Ban Request')
                            ->placeholder('Explain why this session should be banned...')
                            ->required()
                            ->rows(4)
                            ->maxLength(500),
                    ])
                    ->requiresConfirmation()
                    ->modalHeading('Request Session Ban')
                    ->modalDescription(fn (bookedSession $record) => new \Illuminate\Support\HtmlString(
                        '<div class="text-sm">' .
                        '<p class="mb-4">Send a ban request notification to the tutor. The tutor can submit a report to dispute this.</p>' .
                        '<p class="mb-1"><strong>Tutor:</strong> ' . e($record->tutorUser->name) . '</p>' .
                        '<p class="mb-1"><strong>Student:</strong> ' . e($record->studentUser->name) . '</p>' .
                        '</div>'
                    ))
                    ->modalSubmitActionLabel('Send Ban Request')
                    ->action(function (bookedSession $record, array $data) {
                        // Update session with ban request
                        $record->update([
                            'ban_requested' => true,
                            'ban_reason' => $data['ban_reason'],
                            'ban_requested_at' => now(),
                        ]);
                        
                        // Send notification to tutor
                        $banNotif = \App\Models\notifSession::create([
                            'notif_info' => json_encode([
                                'NotifType' => 'BanRequest',
                                'message' => 'Admin has requested to ban your session. Please submit a report.',
                                'ban_reason' => $data['ban_reason'],
                                'bookedSession' => $record->id,
                                'session_id' => $record->id,
                            ]),
                            'to' => $record->tutor_id,
                            'user_id' => 1, // Admin user
                            'read_at' => null,
                        ]);
                        
                        // Broadcast to tutor
                        broadcast(new \App\Events\NewNotification($record->tutor_id, $banNotif));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Ban Request Sent')
                            ->success()
                            ->body('The tutor has been notified and can submit a report.')
                            ->send();
                    })
                    ->visible(fn (bookedSession $record) => !$record->ban_requested),
                Tables\Actions\Action::make('viewReport')
                    ->label('View Report')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->modalHeading('Tutor Ban Report')
                    ->modalContent(fn (bookedSession $record) => view('filament.modals.view-ban-report', [
                        'record' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->visible(fn (bookedSession $record) => $record->ban_status === 'report_submitted'),
                Tables\Actions\Action::make('approveBan')
                    ->label('Approve Ban')
                    ->icon('heroicon-o-check-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Ban and Delete Users')
                    ->modalDescription(fn (bookedSession $record) => new \Illuminate\Support\HtmlString(
                        '<div class="text-sm">' .
                        '<p class="mb-4">This will permanently ban and delete both users and all their sessions.</p>' .
                        '<p class="mb-1"><strong>Tutor:</strong> ' . e($record->tutorUser->name) . '</p>' .
                        '<p class="mb-1"><strong>Student:</strong> ' . e($record->studentUser->name) . '</p>' .
                        '<p class="text-red-600 dark:text-red-400 font-semibold mt-4">This action cannot be undone!</p>' .
                        '</div>'
                    ))
                    ->modalSubmitActionLabel('Yes, Ban Both Users')
                    ->action(function (bookedSession $record) {
                        $tutorUser = $record->tutorUser;
                        $studentUser = $record->studentUser;
                        
                        // Archive all sessions before deletion
                        $allSessions = bookedSession::where('tutor_id', $tutorUser->id)
                            ->orWhere('student_id', $studentUser->id)
                            ->get();
                        
                        foreach ($allSessions as $session) {
                            BannedSessionArchive::create([
                                'original_session_id' => $session->id,
                                'student_id' => $session->student_id,
                                'tutor_id' => $session->tutor_id,
                                'student_name' => $session->studentUser->name ?? 'Unknown',
                                'tutor_name' => $session->tutorUser->name ?? 'Unknown',
                                'tutoring_subject' => $session->tutoring_subject,
                                'schedule_time' => $session->schedule_time,
                                'duration' => $session->duration,
                                'status' => $session->status,
                                'num_session' => $session->num_session,
                                'total_session' => $session->total_session,
                                'feedback' => $session->feedback,
                                'room' => $session->room,
                                'is_completed' => $session->is_completed,
                                'reviewed' => $session->reviewed,
                                'ban_reason' => $session->ban_reason ?? 'No reason provided',
                                'ban_requested_at' => $session->ban_requested_at,
                                'tutor_report' => $session->tutor_report,
                                'tutor_report_images' => $session->tutor_report_images,
                                'tutor_report_submitted_at' => $session->tutor_report_submitted_at,
                                'ban_status' => $session->ban_status ?? 'approved',
                                'banned_at' => now(),
                                'banned_by' => Auth::id(),
                            ]);
                        }
                        
                        // Delete all sessions for both users
                        if ($tutorUser) {
                            bookedSession::where('tutor_id', $tutorUser->id)->delete();
                        }
                        if ($studentUser) {
                            bookedSession::where('student_id', $studentUser->id)->delete();
                        }
                        
                        // Delete tutor data
                        if ($tutorUser) {
                            Tutor::where('user_id', $tutorUser->id)->delete();
                        }
                        
                        // Delete student data
                        if ($studentUser) {
                            Student::where('user_id', $studentUser->id)->delete();
                        }
                        
                        // Delete user accounts
                        if ($tutorUser) {
                            $tutorUser->delete();
                        }
                        if ($studentUser) {
                            $studentUser->delete();
                        }
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Ban Approved')
                            ->success()
                            ->body('Both users have been banned. All sessions archived and deleted.')
                            ->send();
                    })
                    ->visible(fn (bookedSession $record) => $record->ban_status === 'report_submitted'),
                Tables\Actions\Action::make('rejectBan')
                    ->label('Reject Ban')
                    ->icon('heroicon-o-x-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Ban Request')
                    ->modalDescription('This will cancel the ban request and keep both users active.')
                    ->modalSubmitActionLabel('Reject Ban')
                    ->action(function (bookedSession $record) {
                        $record->update([
                            'ban_status' => 'rejected',
                        ]);
                        
                        // Notify tutor that ban was rejected
                        $notif = \App\Models\notifSession::create([
                            'notif_info' => json_encode([
                                'NotifType' => 'BanRejected',
                                'message' => 'Admin has reviewed your report and rejected the ban request.',
                                'session_id' => $record->id,
                            ]),
                            'to' => $record->tutor_id,
                            'user_id' => 1,
                            'read_at' => null,
                        ]);
                        broadcast(new \App\Events\NewNotification($record->tutor_id, $notif));
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Ban Rejected')
                            ->success()
                            ->body('The ban request has been rejected and users remain active.')
                            ->send();
                    })
                    ->visible(fn (bookedSession $record) => $record->ban_status === 'report_submitted'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Delete selected')
                        ->modalHeading('Delete selected Tutoring History')
                        ->modalDescription('Are you sure you would like to do this?')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                
                                if ($record->trashed()) {
                                    $record->forceDelete();
                                } else {
                                    $record->delete();
                                }
                            }
                            
                            \Filament\Notifications\Notification::make()
                                ->title('Deleted')
                                ->success()
                                ->send();
                        }),
                    ExportBulkAction::make()
                        ->label('Export Selected')
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->withFilename('tutoring-sessions-' . date('Y-m-d'))
                                ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
                        ]),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export All')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename('all-tutoring-sessions-' . date('Y-m-d'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
                    ]),
            ])
            ->poll('5s') // Auto-refresh table every 5 seconds
            ->deferLoading(); // Improve initial load performance
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Participants')
                    ->schema([
                        TextEntry::make('tutorUser.name')
                            ->label('Tutor')
                            ->icon('heroicon-m-user-circle')
                            ->iconColor('success')
                            ->weight(FontWeight::Bold),
                        TextEntry::make('studentUser.name')
                            ->label('Student')
                            ->icon('heroicon-m-user')
                            ->iconColor('primary')
                            ->weight(FontWeight::Bold),
                    ])->columns(2),
                    
                Section::make('Session Information')
                    ->schema([
                        TextEntry::make('tutoring_subject')
                            ->label('Subject/Topic'),
                        TextEntry::make('schedule_time')
                            ->label('Scheduled Date & Time')
                            ->dateTime('F d, Y h:i A'),
                        TextEntry::make('duration')
                            ->label('Duration')
                            ->suffix(' minutes'),
                        TextEntry::make('room')
                            ->label('Room/Location')
                            ->default('Not specified'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'completed' => 'success',
                                'ongoing' => 'info',
                                'approved' => 'primary',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('is_completed')
                            ->label('Completion Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Completed' : 'Incomplete')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'gray'),
                    ])->columns(3),
                    
                Section::make('Session Progress')
                    ->schema([
                        TextEntry::make('num_session')
                            ->label('Current Session Number'),
                        TextEntry::make('total_session')
                            ->label('Total Sessions Planned'),
                        TextEntry::make('sesUpdate')
                            ->label('Last Updated')
                            ->date('F d, Y')
                            ->default('N/A'),
                    ])->columns(3),
                    
                Section::make('Feedback & Review')
                    ->schema([
                        TextEntry::make('feedback')
                            ->label('Session Feedback')
                            ->default('No feedback provided')
                            ->columnSpanFull(),
                        TextEntry::make('rating')
                            ->label('Student Rating')
                            ->state(function (bookedSession $record): ?int {
                                $review = Review::where('tutor_id', $record->tutor_id)
                                    ->where('student_id', $record->student_id)
                                    ->first();
                                return $review?->rating;
                            })
                            ->formatStateUsing(fn ($state) => $state ? str_repeat('⭐', (int) $state) . " ({$state}/5)" : 'Not rated yet'),
                        TextEntry::make('review_comment')
                            ->label('Review Comment')
                            ->state(function (bookedSession $record): ?string {
                                $review = Review::where('tutor_id', $record->tutor_id)
                                    ->where('student_id', $record->student_id)
                                    ->first();
                                return $review?->comment;
                            })
                            ->default('No review comment')
                            ->columnSpanFull(),
                        TextEntry::make('reviewed')
                            ->label('Review Status')
                            ->formatStateUsing(fn ($state) => $state ? 'Reviewed' : 'Not Reviewed')
                            ->badge()
                            ->color(fn ($state) => $state ? 'success' : 'warning'),
                    ])->columns(2),
                    
                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Booked At')
                            ->dateTime('F d, Y h:i A'),
                        TextEntry::make('updated_at')
                            ->label('Last Modified')
                            ->dateTime('F d, Y h:i A'),
                    ])->columns(2)
                    ->collapsed(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->withTrashed();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookedSessions::route('/'),
            'create' => Pages\CreateBookedSession::route('/create'),
            'edit' => Pages\EditBookedSession::route('/{record}/edit'),
        ];
    }
}

