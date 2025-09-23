<?php

namespace App;

use Filament\Support\Contracts\HasColor;

enum Status: string implements HasColor
{
    case Pending = 'pending';
    case Claimed = 'claimed';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    public function getColor(): string {
        return match ($this) {
            self::Pending => 'warning',
            self::Claimed => 'info',
            self::Accepted => 'success',
            self::Rejected => 'danger',
        };
    }
}
