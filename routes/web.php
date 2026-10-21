<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
<<<<<<< HEAD
    return view('welcome');
});
=======
    return response()->json(['message' => 'CRM Backend API đang chạy']);
});
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
