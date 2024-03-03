<?php

namespace App\Livewire\Element;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Input extends Component
{
    #[Modelable]
    public $value = '';

    public $keyName = '';

    public $type = 'text';

    public function mount($keyName, String|null $type = null)
    {
        // dd($keyName);
        $this->keyName = $keyName;
        $this->type = $type ?? $this->type;
    }

    // public function calPrice()
    // {
    //     $this->dispatch('cal-price');
    // }

    public function render()
    {
        return view('livewire.element.input');
    }
}
