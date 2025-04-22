<?php

namespace App\Livewire\Admin\Layouts;

use Livewire\Component;

class Master extends Component
{
    public function render()
    {
        // Đảm bảo file Blade của bạn nằm tại: resources/views/livewire/admin/layouts/master.blade.php
        return view('livewire.admin.layouts.app');
    }
}
