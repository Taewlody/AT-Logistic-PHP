<?php

namespace App\Livewire\Page\Common\Country;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Common\Country;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $countryCode = '';

    public Country $data;

    public function mount()
    {
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->countryCode!=''){
            $this->data = Country::find($this->countryCode);
        }else{
            $this->action = 'create';
            $this->data = new Country();
        }
        $this->countryCode;
        
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
        Country::updateOrCreate(['countryCode'=>$this->data->countryCode], $this->data->toArray());
        return redirect()->route('country');
    }
    
    public function render()
    {
        return view('livewire.page.common.country.form')->extends('layouts.main')->section('main-content');
    }
}
