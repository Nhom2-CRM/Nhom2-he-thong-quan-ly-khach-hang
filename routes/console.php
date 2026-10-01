<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// ── Artisan Commands ──────────────────────────────────────────────────────────

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ── Scheduled Tasks ───────────────────────────────────────────────────────────
// Thêm scheduled tasks tại đây (Laravel 13 style – không cần Kernel.php)
//
// Ví dụ:
// Schedule::command('customers:cleanup-inactive')->weekly();
