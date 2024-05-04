<?php

namespace App\Livewire\Page\Administrator\User;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url] 
    public $action = '';
    #[Url]
    public $id = '';

    public User $data;

    public $userTypeList = [];

    public function boot()
    {
        // $this->ChargesTypeList = ChargesType::all();
        if($this->action==''){
            $this->action = 'view';
        }else{
            $this->action;
        }
        if($this->id!=''){
            $this->data = User::find($this->id);
        }else{
            $this->action = 'create';
            $this->data = new User();
            $this->data->createID = Auth::user()->usercode;
            $this->data->userpass = md5($this->data->userpass);
        }

        $this->userTypeList = UserType::all();
        
    }

    public function save() {
        $this->data->editID = Auth::user()->usercode;
       
        $this->data->save();
    }

    public function render()
    {
        return view('livewire.page.administrator.user.form')->extends('layouts.main')->section('main-content');
    }
}
