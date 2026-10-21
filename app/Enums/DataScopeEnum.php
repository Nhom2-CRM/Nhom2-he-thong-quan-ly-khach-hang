<?php

namespace App\Enums;

enum DataScopeEnum: string
{
    case ALL = 'all';
    case DEPARTMENT = 'department';
    case PERSONAL = 'personal';
}