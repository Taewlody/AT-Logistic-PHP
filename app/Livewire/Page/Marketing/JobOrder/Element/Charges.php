<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Functions\CalculatorPrice;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Reactive;
use Livewire\Component;

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
        'value.*.chargesCost'=> 'string',
        'value.*.chargesReceive'=> 'string',
        'value.*.chargesbillReceive'=> 'string'
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
    }

    public function mount($action, String|null $documentID = null, String|null $groupTypeContainer = null, String|null $commissionSale = null, String|null $commissionCustomers = null)

    {
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

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.charges');
    }
}
