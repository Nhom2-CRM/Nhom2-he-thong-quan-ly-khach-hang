<?php

namespace App\Enums;

enum ActivityStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case POSTPONED = 'postponed';
}