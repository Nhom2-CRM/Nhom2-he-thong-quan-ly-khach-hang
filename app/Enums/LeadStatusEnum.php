<?php

namespace App\Enums;

enum LeadStatusEnum: string
{
    case UNASSIGNED = 'unassigned';
    case ASSIGNED   = 'assigned';
    case PROCESSING = 'processing';
    case CONVERTED  = 'converted';
}