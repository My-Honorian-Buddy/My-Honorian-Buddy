<div class="favorite-list-item">
    @if($user)
        <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
            style="background-image: url('{{ Chatify::getUserWithAvatar($user)->profile_pic }}');">
        </div>
        <p>
        @if($user->role === 'Tutor')
                    {{ strlen($user->tutor->fname) > 12 ? trim(substr($user->tutor->fname,0,12), substr($user->tutor->lname,0,12)).'..' : $user->tutor->fname }} 
        @elseif ($user->role === 'Student')
                    {{ strlen($user->student->fname) > 12 ? trim(substr($user->student->fname,0,12), substr($user->student->lname,0,12)).'..' : $user->student->fname }} 
        @endif
        </p>
    @endif
</div>
