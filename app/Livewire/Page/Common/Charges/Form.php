<?php

namespace App\Livewire\Page\Common\Charges;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Charges;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Common\ChargesType;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public Charges $data;

    public $ChargesTypeList = [];

    public function mount()
    {
        $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Charges::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Charges();
        }
        
    }

    public function save()
    {
        if($this->action=='create'){
            $this->data->createID = Auth::user()->usercode;
            $this->data->createTime = Carbon::now()->format('Y-m-d H:i:s');
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }else{
            $this->data->editID = Auth::user()->usercode;
            $this->data->editTime = Carbon::now()->format('Y-m-d H:i:s');
        }
        Charges::upsert([$this->data->toArray()], ['chargeCode']);
        return redirect()->route('charges');
    }

    public function render()
    {
        return view('livewire.page.common.charges.form')->extends('layouts.main')->section('main-content');
    }
}
