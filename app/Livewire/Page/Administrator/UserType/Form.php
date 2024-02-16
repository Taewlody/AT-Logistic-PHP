<?php

namespace App\Livewire\Page\Administrator\UserType;

use App\Models\UserType;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public UserType $data;

    public function boot()
    {
        // $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = UserType::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new UserType();
        }
        
    }

    public function render()
    {
        return view('livewire.page.administrator.user-type.form')->extends('layouts.main')->section('main-content');
    }
}
