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
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;

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

        $this->data = new Customer();

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
            $this->data->isActive = 1;
        }

    }

    public function vaild()
    {
        $vaidate = true;
        $this->resetValidation();
        
        if($this->data->custNameTH == null || $this->data->custNameTH == '') {
            $this->addError('data.custNameTH', 'Please enter Name(TH)');
            $vaidate = false;
        }

        if($this->data->custNameEN == null || $this->data->custNameEN == '') {
            $this->addError('data.custNameEN', 'Please enter Name(EN)');
            $vaidate = false;
        }

        if($this->data->countryCode == null || $this->data->countryCode == '') {
            $this->addError('data.countryCode', 'Please select country');
            $vaidate = false;
        }

        return $vaidate;
    }

    public function save()
    {
        if (!$this->vaild()) {
            return false;
        }
        $this->data = new Customer($this->data->toArray());
        \DB::beginTransaction();
        try {
            if($this->action=='create'){
                $this->data->createID = Auth::user()->usercode;
                $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
                $this->data->editID = Auth::user()->usercode;
                $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
            }else{
                $this->data->editID = Auth::user()->usercode;
                $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
            }

            $this->data = Customer::updateOrCreate([
                'cusCode'=>$this->data->cusCode
            ], $this->data->toArray());
            
            
            \DB::commit();
            return true;
        }catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            echo "Exception caught: " . $exception->getMessage();
            return false;
        }
    }

    public function submit()
    {
        $success = $this->save();
        
        if($success) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกสำเร็จ', type: 'success');
            return redirect()->route('customer.form', ['action' => 'edit', 'id' => $this->data->cusCode]);
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกไม่สำเร็จ', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.page.common.customer.form')->extends('layouts.main')->section('main-content');
    }
}
