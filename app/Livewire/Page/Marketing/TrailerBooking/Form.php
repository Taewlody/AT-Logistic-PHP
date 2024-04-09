<?php

namespace App\Livewire\Page\Marketing\TrailerBooking;

use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\TrailerBooking;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?TrailerBooking $data = null;

    public function mount()
    {
        $this->data = new TrailerBooking;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = TrailerBooking::find($this->id);
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function getJobDetail() {
        if($this->action != 'create' || $this->data->ref_jobID == null) {
            return;
        }
        $job = JobOrder::where('documentID', $this->data->ref_jobID)->first();
        $this->data->documentDate = $job->documentDate;
        $this->data->cusCode = $job->cusCode;
        $this->data->feeder = $job->feeder;
        $this->data->agent = $job->agent;

    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        // dd($this->data);
        $this->data->save();
        $this->redirectRoute(name: 'trailer-booking', navigate: true);
    }

    public function approve() {
        $this->data->documentstatus = 'A';
        $this->data->save();
        $this->redirectRoute(name:'trailer-booking', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.marketing.trailer-booking.form')->extends('layouts.main')->section('main-content');
    }
}
