<?php

namespace App\Livewire\Page\Common\Unit;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Unit;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.unit.page', [ 'data'=> Unit::paginate(50)])->extends('theme.layout.master')->section('main-content');
    }
}
