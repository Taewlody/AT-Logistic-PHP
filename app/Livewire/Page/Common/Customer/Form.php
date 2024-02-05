<?php

namespace App\Livewire\Page\Common\Customer;

use App\Models\Common\CreditTerm;
use App\Models\Common\Saleman;
use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Common\Country;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Customer $data;

    public $countryList = [];

    public $salesmanList = [];

    public $creditTermList = [];

    public function mount()
    {
        $this->countryList = Country::all();
        $this->salesmanList = Saleman::all();
        $this->creditTermList = CreditTerm::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Customer::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Customer();
        }
        // $this->id;
        
    }

    public function save()
    {
        // $this->validate();
        // Country::updateOrCreate(['countryCode'=>$this->data->countryCode], $this->data->toArray());
        if($this->action=='create'){
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        Customer::updateOrCreate(['cusCode'=>$this->data->cusCode], $this->data->toArray());
        return redirect()->route('customer');
    }
    public function render()
    {
        return view('livewire.page.common.customer.form')->extends('layouts.main')->section('main-content');
    }
}
