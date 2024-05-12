<?php

namespace App\Livewire\Element;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class Select2 extends Component
{

    #[Modelable]
    public $value;

    public string $name = '';
    public $options;

    public $itemKey;

    public $itemValue;

    public string $changefn = '';

    public bool $searchable = false;
    public bool $multiple = false;
    public bool $disabled = false;
    public bool $required = false;
    public bool $readonly = false;

    public bool $hasNan = false;

    public string $valueNan = 'N/A';
    public string $textNan = 'N/A';
    public string $placeholder = 'Select';

    public $class = ['form-control', 'select2'];

    public function mount($options, $itemKey, $itemValue, string|null $changefn = null, string|null $name = null, bool|null $hasNan = null, string|null $valueNan = null, string|null $textNan = null, bool|null $multiple = null, bool|null $disabled = null, bool|null $required = null, bool|null $readonly = null, bool|null $searchable = null, bool|null $placeholder = null)
    {
        $this->changefn = $changefn ?? '';
        $this->name = $name ?? $this->name;
        $this->options = $options;
        $this->itemKey = $itemKey;
        $this->itemValue = $itemValue;
        $this->hasNan = $hasNan ?? $this->hasNan;
        $this->valueNan = $valueNan ?? $this->valueNan;
        $this->textNan = $textNan ?? $this->textNan;
        $this->searchable = $searchable ?? $this->searchable;
        $this->multiple = $multiple ?? $this->multiple;
        $this->disabled = $disabled ?? $this->disabled;
        $this->required = $required ?? $this->required;
        $this->readonly = $readonly ?? $this->readonly;
        $this->placeholder = $placeholder ?? $this->placeholder;
    }

    // public function updatedValue()
    // {
    //     Log::info('send updatedValue', ['value' => $this->value]);
    //     // $this->dispatch('updated-'.$this->name, $this->value);
    //     $this->dispatch('updated', $this->value)->self();
    // }

    // #[On('change-select2-{name}')]
    // public function change($value)
    // {
    //     $this->value = $value;
    // }

    // #[On('reset-select2-{name}')]
    // public function resetValue()
    // {
    //     $this->reset('value');
    //     $this->render();
    // }

    public function render()
    {
        return view('livewire.element.select2');
    }
}
