<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserController extends Model
{
    public function showLogs()
    {
        if(auth()->user()->role != 'super_admin')
        {
            abort(403, 'Bạn không có quyền truy cập logs.');
        }

        return view('logs.index', ['logs' => Log::latest()->paginate(20)]);
    }
}
