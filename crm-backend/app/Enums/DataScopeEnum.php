<?php

namespace App\Enums;

enum DataScopeEnum: string
{
    case OWN = 'own';
    case TEAM = 'team';
    case ALL = 'all';
}