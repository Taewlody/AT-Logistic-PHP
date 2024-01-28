<?php

namespace App\Livewire\Page\Common\Supplier;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Supplier;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.supplier.page', [ 'data'=> Supplier::paginate(50)])->extends('layouts.main')->section('content');
    }
}
