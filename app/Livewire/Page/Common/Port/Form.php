<?php

namespace App\Livewire\Page\Common\Port;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Port;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Common\Country;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $portCode = '';

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
        if($this->portCode!=''){
            $this->data = Port::find($this->portCode);
        }else{
            $this->action = 'create';
            $this->data = new Port();
        }
        $this->portCode;
        
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
        Port::updateOrCreate(['portCode'=>$this->data->portCode], $this->data->toArray());
        return $this->redirect(Page::class);
    }
    public function render()
    {
        return view('livewire.page.common.port.form')->extends('layouts.main')->section('main-content');
    }
}
