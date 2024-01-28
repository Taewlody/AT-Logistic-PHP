<?php

namespace App\Livewire\Page\Common\Saleman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.saleman.page', [ 'data'=> Saleman::paginate(50)])->extends('layouts.main')->section('content');
    }
}
