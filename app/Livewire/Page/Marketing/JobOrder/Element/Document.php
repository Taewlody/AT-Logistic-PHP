<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderWithoutRef;
use Illuminate\Queue\Attributes\WithoutRelations;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Livewire\Component;

// #[Renderless]
// #[Lazy(isolate: false)]
class Document extends Component
{

    public $action = '';
    
    #[Modelable]
    public JobOrderWithoutRef $value;

    public function mount($action){
        $this->action = $action;
    }

    #[On('vaildated')]
    public function vaildJob(){
        if($this->value->invNo == null || $this->value->invNo == '') {
            $this->addError('invNo', 'Please enter invoice no');
            // return false;
        }
        if($this->value->bookingNo == null || $this->value->bookingNo == '') {
            $this->addError('bookingNo', 'Please enter booking no');
            // return false;
        }
        if($this->value->bound == null || $this->value->bound == '') {
            $this->addError('bound', 'Please enter bound');
        }
        if($this->value->freight == null || $this->value->freight == '') {
            $this->addError('freight', 'Please enter freight');
        }
        if($this->value->deliveryType == null || $this->value->deliveryType == '') {
            $this->addError('deliveryType', 'Please enter delivery type');
        }

        if($this->value->invNo) {
            $checkInv = JobOrder::where('invNo', $this->value->invNo)->where('invNo', '!=', 'N/A')->where('documentID', '!=', $this->value->documentID)->first();
            
            if($checkInv !== null) {
                $this->addError('invNo', 'INV No. is Duplicate');
            }
        }

        if ($this->value->bookingNo !== null) {
            $checkBooking = JobOrder::where('bookingNo', $this->value->bookingNo)->where('bookingNo', '!=', 'N/A')->where('documentID', '!=', $this->value->documentID)->first();
            
            if($checkBooking) {
                $this->addError('bookingNo', 'Booking No. is Duplicate');
                return false;
            }
        }

        if($this->value->bound == 1){
            if ($this->value->bill_of_landing !== null) {
                $checkBillOfLanding = JobOrder::where('bill_of_landing', $this->value->bill_of_landing)->where('bill_of_landing', '!=', 'N/A')->where('documentID', '!=', $this->value->documentID)->first();
                
                if($checkBillOfLanding) {
                    $this->addError('bill_of_landing', 'Bill Of Lading is Duplicate');
                    return false;
                }
            } else {
                $this->addError('bill_of_landing', 'Please enter Bill Of Lading');
            }
        }
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.document');
    }
}
