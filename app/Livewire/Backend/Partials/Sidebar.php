<?php

namespace App\Livewire\Backend\Partials;

use Livewire\Component;

class Sidebar extends Component
{

    public string $active = '';

    public function mount(string $active)
    {
        $this->active = $active;
    }

    public function render()
    {
        return view('livewire.backend.partials.sidebar');
    }
}
