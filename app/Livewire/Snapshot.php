<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Photo;

class Snapshot extends Component
{
    public function render()
    {
        // Fetch 6 most recent photos using your existing logic
        $photos = Photo::with('imageable')
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.snapshot', [
            'photos' => $photos
        ]);
    }
}