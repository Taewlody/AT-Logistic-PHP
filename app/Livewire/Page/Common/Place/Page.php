<?php

namespace App\Livewire\Page\Common\Place;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Place;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.place.page', [ 'data'=> Place::paginate(50)])->extends('theme.layout.master')->section('main-content');
    }
}
