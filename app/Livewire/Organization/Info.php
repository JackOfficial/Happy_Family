<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class Info extends Component
{
    public function render()
    {
         $organization = Organization::first();
        return view('livewire.organization.info', compact('organization'));
    }
}
