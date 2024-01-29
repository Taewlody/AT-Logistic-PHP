<?php

namespace App\Livewire\Page\Common\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Customer;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.customer.page', [ 'data'=> Customer::paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
