<?php

namespace App\Livewire\Page\Common\ChargesType;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\ChargesType;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.charges-type.page', [ 'data'=> ChargesType::paginate(50)])->extends('layouts.main')->section('content');
    }
}
