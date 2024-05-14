<?php

namespace App\Livewire\Element;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Currency extends Component
{

    #[Modelable]
    public float $value;

    public $name = '';

    public $class = "";

    public $disabled = false;
    public $readonly = false;

    public function mount( string $name, String|null $class = null, bool|null $disabled = null, bool|null $readonly = null)
    {
        $this->name = $name;
        $this->class = $class ?? $this->class;
        $this->disabled = $disabled ?? $this->disabled;
        $this->readonly = $readonly ?? $this->readonly;
    }
    
    public function getValue(String $value)
    {
        // dd($value);
        $this->value = floatval($value);
    }

    public function render()
    {
        return view(
            'livewire.element.currency',
            [
                'value' => $this->value
            ]
        );
    }
}
