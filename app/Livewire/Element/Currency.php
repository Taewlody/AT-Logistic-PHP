<?php

namespace App\Livewire\Element;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Currency extends Component
{

    #[Modelable]
    public $value;
    
    public function render()
    {
        return view('livewire.element.currency');
    }
}
