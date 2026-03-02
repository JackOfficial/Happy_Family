<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Organization;
use App\Models\Subscription;

class FooterComponent extends Component
{
    public $email = '';
    
     public function subscribe(){
        $this->validate([
         'email' => 'required|email|unique:subscriptions,email'
        ]);

        $subscribe = Subscription::create([
            'email' => $this->email
        ]);

        if($subscribe){
            $this->reset('email');
            session()->flash('subscribeSuccess', 'You have subscribed successfully');
        }
        else{
            $this->flush('subscribeFail', 'You could not be subscribed');
        }
    }
    
    public function render()
    {
        $organization = Organization::first();
        return view('livewire.footer-component', compact('organization'));
    }
}
