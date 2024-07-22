<?php

namespace App\Livewire\Page\Common\Supplier;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Supplier;
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

    public Supplier $data;

    public $countryList = [];

    public function mount()
    {
        
        $this->countryList = Country::all();
        $this->data = new Supplier();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Supplier::find($this->id);
            
        }else{
            $this->action = 'create';
            $this->data->createID = Auth::user()->usercode;
        }
    }

    public function submit()
    {
        $success = $this->save();
        if($success) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกสำเร็จ', type: 'success');
            return redirect()->route('supplier.form', ['action' => 'edit', 'id' => $this->data->supCode]);
        }else {
            $this->dispatch('vaildated');
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Error', message: 'บันทึกไม่สำเร็จ', type: 'error');
        }
    }

    public function vaild()
    {
        $vaidate = true;
        $this->resetValidation();
        if($this->data->countryCode == null || $this->data->countryCode == '') {
            $this->addError('data.countryCode', 'Please select Country');
            $vaidate = false;
        }
        
        if(($this->data->supNameTH == null || $this->data->supNameTH == '') && 
        ($this->data->supNameEN == null || $this->data->supNameEN == '')) {
            // dd('5555', $this->data->custNameTH, $this->data->custNameEN);
            $this->addError('data.supNameTH', 'Please enter Name(TH) or Name(EN)');
            $vaidate = false;
        }

        return $vaidate;
    }

    public function save()
    {
        if (!$this->vaild()) {
            return false;
        }
        $this->data = new Supplier($this->data->toArray());
        \DB::beginTransaction();
        try {
            if($this->action=='create'){
                $this->data->createID = Auth::user()->usercode;
            }else{
                $this->data->editID = Auth::user()->usercode;
            }
            
            Supplier::updateOrCreate(
                ['supCode' => $this->data->supCode],
                $this->data->toArray()
            );
            
            \DB::commit();
            return true;
        }catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception->getMessage());
            echo "Exception caught: " . $exception->getMessage();
            return false;
        }
    }
    
    public function render()
    {
        return view('livewire.page.common.supplier.form')->extends('layouts.main')->section('main-content');
    }
}
