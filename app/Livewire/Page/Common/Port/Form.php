<?php

namespace App\Livewire\Page\Common\Port;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Port;
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

    public Port $data;

    public $countryList = [];

    public function mount()
    {
        $this->countryList = Country::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }

        if($this->id!=''){
            $this->data = Port::find($this->id);
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->action = 'create';
            $this->data = new Port();
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }

        // $this->portCode;
        
    }

    public function submit()
    {
        $success = $this->save();
        
        if($success) {
            $this->dispatch('modal.common.modal-alert', showModal: true, title: 'Success', message: 'บันทึกสำเร็จ', type: 'success');
            return redirect()->route('port.form', ['action' => 'edit', 'id' => $this->data->portCode]);
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
        $this->data = new Port($this->data->toArray());
        \DB::beginTransaction();
        try {
            // dd($this->data);
            $this->data = Port::updateOrCreate([
                'portCode'=>$this->data->portCode
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
    public function render()
    {
        return view('livewire.page.common.port.form')->extends('layouts.main')->section('main-content');
    }
}
