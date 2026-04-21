<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class Copyright extends Component
{
    public function render()
    {
        $organization = Organization::first();
        return view('livewire.organization.copyright', compact('organization'));
    }
}
