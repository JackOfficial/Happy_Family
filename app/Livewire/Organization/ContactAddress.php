<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class ContactAddress extends Component
{
    public function render()
    {
        $organization = Organization::first();
        return view('livewire.organization.contact-address', compact('organization'));
    }
}
