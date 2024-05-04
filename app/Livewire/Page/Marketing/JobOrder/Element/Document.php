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
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.document');
    }
}
