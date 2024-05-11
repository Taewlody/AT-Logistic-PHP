<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Functions\CalculatorPrice;
use App\Livewire\Page\Marketing\JobOrder\Element\Models\JobCharge;
use App\Livewire\Page\Marketing\JobOrder\Element\Models\JobChargeType;
use App\Models\Marketing\JobOrderCharge;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Livewire;

// #[Lazy(isolate: true)]
class Charges extends Component
{

    public Collection $customer_piad;

    #[Modelable]
    public Collection $value;

    // #[Reactive]
    public $commissionSale;

    // #[Reactive]
    public $commissionCustomers;

    #[Locked]
    public String|null $documentID = '';

    #[Locked]
    public string $action = '';

    #[Reactive]
    public $groupTypeContainer;

    protected array $rules = [
        'value.*' => 'unique:App\Models\Marketing\JobOrderCharge',
        'value.*.items'=> 'number',
        'value.*.comCode'=> 'string',
        'value.*.documentID'=> 'required|string',
        'value.*.ref_paymentCode'=> 'string',
        'value.*.chargeCode'=> 'required|string',
        'value.*.detail'=> 'string',
        'value.*.price'=> 'integer',
        'value.*.volume'=> 'integer',
        'value.*.exchange'=> 'integer',
        'value.*.chargesCost'=> 'numeric',
        'value.*.chargesReceive'=> 'numeric',
        'value.*.chargesbillReceive'=> 'numeric',
        'value.*.charges.chargeType' => 'unique:App\Models\Common\ChargesType',
    ];

    #[Computed]
    public function callPrice(){
        return CalculatorPrice::cal_charge($this->value);
    }

    public function checkBill($index) {
        if($this->value[$index]['chargesbillReceive'] < $this->value[$index]['chargesCost']) {
            $this->dispatch('modal.job-order.charges-alert', showModal: true);
        }
    }

    public function boot(){
        // Livewire::propertySynthesizer(JobCharge::class);
        // Livewire::propertySynthesizer(JobChargeType::class);
    }

    // public function updatedValue($value, $key){
    //     $index = explode('.', $key)[0];
    //     $name = explode('.', $key)[1];
    //     // dd($value, $key, $index);
    //     if($name == "chargesbillReceive" && $this->value[$index]['chargesbillReceive'] < $this->value[$index]['chargesCost']) {
    //         $this->dispatch('modal.job-order.charges-alert', showModal: true);
    //     }
    // }

    public function mount($action, String|null $documentID = null, String|null $groupTypeContainer = null, String|null $commissionSale = null, String|null $commissionCustomers = null)
    {
        // $this->value;
        $this->action = $action;
        $this->documentID = $documentID ?? '';
        $this->groupTypeContainer = $groupTypeContainer ?? '';
        $this->commissionSale = $commissionSale ?? '';
        $this->commissionCustomers = $commissionCustomers ?? '';
        // dd($this->commissionSale, $this->commissionCustomers);
        if($action != 'create'){
            $this->customer_piad = CalculatorPrice::cal_customer_piad($this->documentID) ?? new Collection;
        }
    }

    public function updatedCommissionSale(){
        // dd($this->commissionSale);
        $this->dispatch('commission-sale', $this->commissionSale);
    }

    public function updatedCommissionCustomers(){
        // dd($this->commisionCustomers);
        $this->dispatch('commission-customers', $this->commissionCustomers);
    }

    // public function changeCommissionSale(){
    //     dd($this->commissionSale);
    // }

    // public function calReceive($index){
       
    // }

    // public function updatingValue($value, $key){
    //     $index = explode('.', $key)[0];
    //     $name = explode('.', $key)[1];
    //     if($name == "price") {
    //         // dd($value, $key, $index);
    //         $this->value->get($index)->price = $value;
    //         // dd($this->value->get($index));
    //     }
    //     if($name == "volume") {
    //         $this->value->get($index)->volume = $value;
    //     }
    //     if($name == "exchange") {
    //         $this->value->get($index)->exchange = $value;
    //     }
    // }


    public function render()
    {
        return view('livewire.page.marketing.job-order.element.charges');
    }
}
