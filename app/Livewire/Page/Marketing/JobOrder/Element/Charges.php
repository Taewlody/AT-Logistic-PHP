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
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Livewire;

// #[Lazy(isolate: true)]
class Charges extends Component
{

    public Collection $customer_piad;

    #[Modelable]
    public Collection $value;

    public $chargeGroup;

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

    #[Reactive]
    public $groupTypePackage;

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
        'chargeGroup.*.*' => 'unique:App\Models\Marketing\JobOrderCharge',
        'chargeGroup.*.*.items'=> 'number',
        'chargeGroup.*.*.comCode'=> 'string',
        'chargeGroup.*.*.documentID'=> 'required|string',
        'chargeGroup.*.*.ref_paymentCode'=> 'string',
        'chargeGroup.*.*.chargeCode'=> 'required|string',
        'chargeGroup.*.*.detail'=> 'string',
        'chargeGroup.*.*.price'=> 'integer',
        'chargeGroup.*.*.volume'=> 'integer',
        'chargeGroup.*.*.exchange'=> 'integer',
        'chargeGroup.*.*.chargesCost'=> 'numeric',
        'chargeGroup.*.*.chargesReceive'=> 'numeric',
        'chargeGroup.*.*.chargesbillReceive'=> 'numeric',
        'chargeGroup.*.*.charges.chargeType' => 'unique:App\Models\Common\ChargesType',
    ];

    #[Computed]
    public function callPrice(){
        return CalculatorPrice::cal_charge($this->value, $this->commissionSale, $this->commissionCustomers);
    }

    #[Computed]
    public function groupCharge(){
        $key = $this->value->groupBy('detail')->keys()->values();
        $value = $this->value;
        $indexGroup = $key->map(function($item) use ($value){
            $index = $value->filter(function($value) use ($item){
                return $value->detail == $item;
            })->map(function ($item) use ($value) {
                return $value->search($item);
            })->values()->toArray();
            return (object) ['key' => $item, 'index' => $index];
        });
        // dd($indexGroup);
        return $indexGroup;
    }

    #[On("checkBill")]
    public function checkBill(int $index) {
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

    // public function updatedValue($value, $key){
    //     $this->chargeGroup = $this->groupCharge();
    // }

    #[On("update-charges")]
    public function updateChargeGroup()
    {
        $this->dispatch('valueUpdated');
    }

    public function mount($action, String|null $documentID = null, String|null $groupTypeContainer = null, $groupTypePackage = null, String|null $commissionSale = null, String|null $commissionCustomers = null)
    {
        // $this->value;
        $this->action = $action;
        $this->documentID = $documentID ?? '';
        $this->groupTypeContainer = $groupTypeContainer ?? '';
        $this->groupTypePackage = $groupTypePackage ?? '';
        $this->commissionSale = $commissionSale ?? '';
        $this->commissionCustomers = $commissionCustomers ?? '';
        // dd($this->commissionSale, $this->commissionCustomers);
        if($action != 'create'){
            $this->customer_piad = CalculatorPrice::cal_customer_piad($this->documentID) ?? new Collection;
        }
        // $this->chargeGroup = $this->groupCharge();
    }

    // public function updatedCommissionSale(){
    //     // dd($this->commissionSale);
    //     if($this->commissionSale != null) {
    //         $this->dispatch('commission-sale', $this->commissionSale);
    //     }
       
    // }

    // public function updatedCommissionCustomers(){
    //     // dd($this->commisionCustomers);
    //     if($this->commissionCustomers != null) {
    //         $this->dispatch('commission-customers', $this->commissionCustomers);
    //     }
    //     // $this->dispatch('commission-customers', $this->commissionCustomers);
    // }

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
        // $this->chargeGroup = $this->groupCharge();
        return view('livewire.page.marketing.job-order.element.charges');
    }
}
