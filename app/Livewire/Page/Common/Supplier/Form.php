<?php

namespace App\Livewire\Page\Common\Supplier;

use Livewire\Attributes\Url;
use Carbon\Carbon;
use App\Models\Common\Supplier;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Common\Country;

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
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = Supplier::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new Supplier();
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
        Supplier::updateOrCreate(['supCode'=>$this->data->supCode], $this->data->toArray());
        return $this->redirect(Page::class);
    }
    
    public function render()
    {
        return view('livewire.page.common.supplier.form')->extends('layouts.main')->section('main-content');
    }
}
