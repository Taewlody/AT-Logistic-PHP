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

    public $changeEvent;

    public $index;

    public $disabled = false;
    public $readonly = false;

    public function mount( string $name, String|null $class = null, bool|null $disabled = null, bool|null $readonly = null, String|null $changeEvent = null, string|null $index = null)
    {
        $this->name = $name;
        $this->class = $class ?? $this->class;
        $this->disabled = $disabled ?? $this->disabled;
        $this->readonly = $readonly ?? $this->readonly;
        if($changeEvent){
            $this->changeEvent = $changeEvent;
        }
        if($index){
            $this->index = $index;
        }
    }

    public function updatedValue()
    {
        if($this->changeEvent){
            $this->dispatch($this->changeEvent, $this->index);
        }
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
