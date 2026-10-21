<?php

namespace App\Enums;

enum DataScopeEnum: string
{
    case ALL = 'all';           // Toàn bộ công ty
    case TEAM = 'team';         // Theo phòng ban / nhóm
    case PERSONAL = 'personal'; // Bàn làm việc cá nhân
}
