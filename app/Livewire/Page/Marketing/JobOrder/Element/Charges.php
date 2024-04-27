<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Functions\CalculatorPrice;
use App\Models\Marketing\JobOrderCharge;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;

class Charges extends Component
{

    // public $chargesList = [];

    public $customer_piad = [];

    #[Modelable]
    public Collection $value;

    // public Collection $container;
    // #[Validate('required|string')]
    // public String $chargeCode = '';

    #[Locked]
    public String|null $documentID = '';

    #[Locked]
    public string $action = '';

    public string $qty = '';

    protected array $rules = [
        'value.*' => 'unique:App\Models\Marketing\JobOrderCharge',
        'value.*.items'=> 'number',
        'value.*.comCode'=> 'string',
        'value.*.documentID'=> 'required|string',
        'value.*.ref_paymentCode'=> 'string',
        // 'value.*.chargeCode'=> 'required|string',
        'value.*.detail'=> 'string',
        'value.*.chargesCost'=> 'string',
        'value.*.chargesReceive'=> 'string',
        'value.*.chargesbillReceive'=> 'string'
    ];

    #[Computed]
    public function callPrice(){
        return CalculatorPrice::cal_charge($this->value);
    }

    // public function addCharge()
    // {
    //     // $this->validate();
    //     $this->dispatch('Add-Charge', $this->chargeCode);
    //     $this->reset('chargeCode');
    // }

    #[On('Update-Container')]
    public function updateQty($newQty)
    {
        $this->qty = $newQty;
    }

    public function checkBill($index) {
        if($this->value[$index]['chargesbillReceive'] < $this->value[$index]['chargesCost']) {
            $this->dispatch('modal.job-order.charges-alert', showModal: true);
        }
    }

    public function boot(){
        // Log::info('boot');
    }

    public function mount($action, String|null $documentID = null)
    {
        $this->action = $action;
        $this->documentID = $documentID ?? '';
        if($action != 'create'){
            $this->customer_piad = CalculatorPrice::cal_customer_piad($this->documentID);
        }
        // Log::debug("mount: ".print_r($this->value, true));
    }

    public function render()
    {
        // Log::info("render: ".print_r($this->value, true));
        return view('livewire.page.marketing.job-order.element.charges');
    }
}
