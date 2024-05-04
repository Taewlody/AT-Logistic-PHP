<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Marketing\JobOrderContainer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Validate;
use Livewire\Component;

// #[Renderless]
// #[Lazy]
class Containers extends Component
{

    public $action = '';

    public $documentID = '';
    
    #[Modelable]
    public Collection $value;
    
    // #[Validate('required|string')]
    // public string $typeContainer = '';
    // #[Validate('required|string')]
    // public string $sizeContainer = '';

    // #[Validate('required|numeric|min:1')]
    // public int $quantityContainer = 1;

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
        'value.*.size' => 'unique:App\Models\Common\ContainerSize',
        'value.*.type' => 'unique:App\Models\Common\ContainerType',
    ];

    // public function addContainer() {
    //     $this->validate();
    //     $this->dispatch('Add-Container', $this->typeContainer, $this->sizeContainer, $this->quantityContainer);
    //     $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
    // }

    public function mount($action){
        $this->action = $action;
    }

    // public function updated($value){
    //     // dd($value);
    //     $index = explode('.', $value)[1];
    //     $key = explode('.', $value)[2];
    //    $this->dispatch('Update-Value-Container', $this->value[$index], $key);
    // }

    public function exception($e, $stopProgation){
        dd($e, $stopProgation);
        // Log::error($e);
    }

    #[On('Update-Container')]
    public function render()
    {
        return view('livewire.page.marketing.job-order.element.containers');
    }
}
