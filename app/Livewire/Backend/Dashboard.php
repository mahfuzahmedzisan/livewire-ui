<?php

namespace App\Livewire\Backend;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.authenticated' ,['page_slug' => 'Dashboard', 'breadcrumb' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.backend.dashboard');
    }
}
