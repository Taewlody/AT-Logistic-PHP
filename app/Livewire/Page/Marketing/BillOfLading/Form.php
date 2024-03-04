<?php

namespace App\Livewire\Page\Marketing\BillOfLading;

use App\Models\Common\Customer;
use App\Models\Common\Supplier;
use App\Models\Marketing\BillOfLading;
use App\Models\Marketing\JobOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public ?BillOfLading $data = null;

    public function mount()
    {
        $this->data = new BillOfLading();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = BillOfLading::find($this->id);
        } else {
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
        // dd($this->data);
        $this->data->save();
        $this->redirectRoute(name: 'bill-of-lading', navigate: true);
    }

    public function approve() {
        $this->data->documentstatus = 'A';
        $this->data->save();
        $this->redirectRoute(name:'bill-of-lading', navigate: true);
    }

    public function render()
    {
        return view('livewire.page.marketing.bill-of-lading.form')->extends('layouts.main')->section('main-content');
    }
}
