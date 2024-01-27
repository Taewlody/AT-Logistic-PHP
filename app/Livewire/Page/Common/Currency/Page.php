<?php

namespace App\Livewire\Page\Common\Currency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Common\Currency;

class Page extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.page.common.currency.page', [ 'data'=> Currency::paginate(50)])->extends('theme.layout.master')->section('main-content');
    }
}
