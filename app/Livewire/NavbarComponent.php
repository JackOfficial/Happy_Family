<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Organization;

class NavbarComponent extends Component
{
    public function render()
    {
        $organization = Organization::first();
        return view('livewire.navbar-component', compact('organization'));
    }
}
