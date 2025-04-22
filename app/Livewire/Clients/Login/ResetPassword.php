<?php

namespace App\Livewire\Clients\Login;

use Livewire\Component;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\View;

class ResetPassword extends Component
{
    public function render():object
    {
        return view('live wire.clients.login.reset-password');
    }
}
