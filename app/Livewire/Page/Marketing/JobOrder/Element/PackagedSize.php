<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class PackagedSize extends Component
{
    public $action = '';
    public $documentID = '';
    
    protected array $rules = [
        'value.*'=> 'unique:App\Models\Marketing\JobOrderPacked',
        'value.*.items'=> 'number',
        'value.*.comCode'=> 'string',
        'value.*.documentID'=> 'required|string',
        'value.*.packaed_width'=> 'string',
        'value.*.packaed_length'=> 'string',
        'value.*.packaed_height'=> 'string',
        'value.*.packaed_qty'=> 'string',
        'value.*.packaed_weight'=> 'string',
        'value.*.packaed_unit'=> 'string',
        'value.*.packaed_totalCBM'=> 'string',
        'value.*.packaed_totalWeight'=> 'string',
    ];

    #[Modelable]
    public Collection $value;

    // public function addRowPacked() {
    //     $this->dispatch('Add-Packaged');
    //     // $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
    // }

    public function mount($action){
        $this->action = $action;
    }

    public function updatedValue($value, $key){
        $index = explode('.', $key)[0];
        $name = explode('.', $key)[1];
        if($name == 'packaed_totalCBM') return;
        $packed = $this->value[$index];
        $width = $packed['packaed_width'] ?? 0;
        $length = $packed['packaed_length'] ?? 0;
        $height = $packed['packaed_height'] ?? 0;
        $qty = $packed['packaed_qty'] ?? 1;
        $packed['packaed_totalCBM'] = ($width * $length * $height) / (1000000 * $qty);
    }
    
    public function render()
    {
        return view('livewire.page.marketing.job-order.element.packaged-size');
    }
}
