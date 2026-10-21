<?php

namespace App\Enums;

enum ActivityPriorityEnum: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}