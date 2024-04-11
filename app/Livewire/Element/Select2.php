<?php

namespace App\Livewire\Element;

use Livewire\Attributes\Modelable;
use Livewire\Component;

class Select2 extends Component
{

    #[Modelable]
    public $value;

    public string $name = '';
    public $options;

    public $itemKey;

    public $itemValue;

    public bool $disabled = false;
    public bool $required = false;
    public bool $readonly = false;
    public string $placeholder = 'Select';

    public $class = ['form-control', 'select2'];

    public function mount($options, $itemKey, $itemValue, string|null $name = null, bool|null $multiple = null, bool|null $disabled = null, bool|null $required = null, bool|null $readonly = null, bool|null $searchable = null, bool|null $placeholder = null)
    {
        $this->name = $name ?? $this->name;
        $this->options = $options;
        $this->itemKey = $itemKey;
        $this->itemValue = $itemValue;
        $this->disabled = $disabled ?? $this->disabled;
        $this->required = $required ?? $this->required;
        $this->readonly = $readonly ?? $this->readonly;
        $this->placeholder = $placeholder ?? $this->placeholder;
        // if($multiple) {
        //     $this->class[] = 'select2-multiple';
        // }else {
        //     $this->class[] = 'select2-single';
        // }
        // if($searchable) {
        //     $this->class[] = 'select2-search';
        // }
    }

    public function render()
    {
        return view('livewire.element.select2');
    }
}
