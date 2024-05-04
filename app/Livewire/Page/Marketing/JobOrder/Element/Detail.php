<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderWithoutRef;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

#[Renderless]
class Detail extends Component
{

    public $action = '';
    
    #[Modelable]
    public JobOrderWithoutRef $value;

    public function mount($action){
        $this->action = $action;
    }

    #[On('vaildated')]
    public function vaildJob(){
        if($this->value->cusCode == null || $this->value->cusCode == '') {
            $this->addError('cusCode', 'Please select customer');
            // return false;
        }
        if($this->value->agentCode == null || $this->value->agentCode == '') {
            $this->addError('agentCode', 'Please select agent');
            // return false;
        }
        if($this->value->feeder == null || $this->value->feeder == '') {
            $this->addError('feeder', 'Please enter feeder');
            // return false;
        }
    }

    #[On('updated-cusCode')]
    public function changeContact($value){
        Log::info('changeContact', ['value' => $value]);
        $customer = Customer::find($value);
        if($customer) {
            $this->value->cusContact = $customer->contactName;
            // $this->value->saleman = $customer->salemanID;
            $this->dispatch('change-select2-saleman', $customer->salemanID);
        }
    }

    public function updatedContact(){
        Log::info('updatedContact', ['value' => $this->value]);
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.detail');
    }
}
