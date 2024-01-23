<?php

namespace App\Livewire\Component;

use Livewire\Component;

class PageHeading extends Component
{

    public $title_en;
    public $title_th;
    public $breadcrumb_main = "Home";
    public $breadcrumb_title;
    public $breadcrumb_page;

    public function mount(String $title_en, String $title_th, String $breadcrumb_title, String $breadcrumb_page, String|null $breadcrumb_main = null,)
    {
        $this->title_en = $title_en;
        $this->title_th = $title_th;
        $this->breadcrumb_main = $breadcrumb_main ?? $this->breadcrumb_main;
        $this->breadcrumb_title = $breadcrumb_title;
        $this->breadcrumb_page = $breadcrumb_page;
    }

    public function render()
    {
        return view('livewire.component.page-heading');
    }
}
