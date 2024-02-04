<?php

namespace App\Livewire\Component;

use Livewire\Component;

class PageHeading extends Component
{

    public $title_main;
    public $title_sub = "";
    public $breadcrumb_main = "Home";
    public $breadcrumb_title;
    public $breadcrumb_page;
    public $breadcrumb_page_title = "";

    public function mount(String $title_main, String $breadcrumb_title, String $breadcrumb_page, String|null $title_sub = null, String|null $breadcrumb_main = null, String|null $breadcrumb_page_title = null)
    {
        $this->title_main = $title_main;
        $this->title_sub = $title_sub ?? $this->title_sub;
        $this->breadcrumb_main = $breadcrumb_main ?? $this->breadcrumb_main;
        $this->breadcrumb_title = $breadcrumb_title;
        $this->breadcrumb_page = $breadcrumb_page;
        $this->breadcrumb_page_title = $breadcrumb_page_title ?? $this->breadcrumb_page_title;
    }

    public function render()
    {
        return view('livewire.component.page-heading');
    }
}
