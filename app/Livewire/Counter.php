<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class Counter extends Component
{
    public $count = 1;
 
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }
    
    public function render()
    {
        $tag = Tag::find(1);
        return view('livewire.counter', ['tag' => $tag]);
    }
}
