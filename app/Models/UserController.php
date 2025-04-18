<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()?->role !== 'super_admin') {
                abort(403, 'Bạn không có quyền truy cập logs.');
            }
            return $next($request);
        });
    }

    public function showLogs()
    {
        $logs = Logs::latest()->paginate(20);
        return view('logs.index', compact('logs'));
    }
}
