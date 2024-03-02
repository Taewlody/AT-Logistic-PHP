<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Marketing\JobOrderContainer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
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
    public $quantityContainer = 1;

    protected array $rules = [
        'value.*'=> 'unique:App\Models\Marketing\JobOrderContainer',
        'value.*.items'=> 'number',
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

    // #[On('Update-Container-List')]
    // public function editContainer($update) {
    //     // $this->value = $update;
    //     $this->render();
    // }
        

    public function mount($action){
        $this->action = $action;
        // $this->documentID = $documentID;
        // if($this->value->isEmpty()){
        //     $this->value->push(new JobOrderContainer);
        // }
    }

    // public function addContainer()
    // {
    //     // $newContainer = new Collection();
    //     $dataContainer = new JobOrderContainer;
    //     $dataContainer->documentID = $this->documentID;
    //     $dataContainer->comCode = 'C01';
    //     $dataContainer->containerType = $this->typeContainer;
    //     $dataContainer->containerSize = $this->sizeContainer;
    //     for ($i = 1; $i <= $this->quantityContainer; $i++) {
    //         $this->value->push($dataContainer);
    //     }
    //     $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
    //     // $this->skipRender();
    // }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.containers');
    }
}
