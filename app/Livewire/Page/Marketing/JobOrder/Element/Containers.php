<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Marketing\JobOrderContainer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Renderless]
class Containers extends Component
{

    public $action = '';

    public $documentID = '';
    
    #[Modelable]
    public Collection $value;
    
    public $typeContainer = '';
    public $sizeContainer = '';

    #[Validate('required|numeric|min:1')]
    public $quantityContainer = 1;

    protected array $rules = [
        'value.*'=> 'unique:App\Models\Marketing\JobOrderContainer',
        'value.*.items'=> 'integer',
        'value.*.comCode'=> 'string',
        'value.*.documentID'=> 'required|string',
        'value.*.containerType'=> 'string',
        'value.*.containerSize'=> 'string',
        'value.*.containerNo'=> 'string',
        'value.*.containerSealNo'=> 'string',
        'value.*.containerGW'=> 'string',
        'value.*.containerGW_unit'=> 'string',
        'value.*.containerNW'=> 'string',
        'value.*.containerNW_Unit'=> 'string',
        'value.*.containerTareweight'=> 'string',
    ];

    public function addContainer() {
        $this->dispatch('Add-Container', $this->typeContainer, $this->sizeContainer, $this->quantityContainer);
        $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
    }

    public function mount($action){
        $this->action = $action;
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.containers');
    }
}
