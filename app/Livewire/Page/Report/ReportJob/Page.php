<?php

namespace App\Livewire\Page\Report\ReportJob;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Marketing\JobOrder;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;

    public $query = [];

    public $documentID = '';
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    
    public function mount(){
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        $this->queryCustomer = [];

        if($this->documentID != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentID.'%'];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['saleman', '=', $this->salemanSearch];
        }
    }

    public function render()
    {
        return view('livewire.page.report.report-job.page',[ 
            'data'=> JobOrder::with(['customerRefer', 
            'salemanRefer',
            'docStatus' => function ($query) {
                $query->where('status_code', 'P');
            }])
            ->where($this->query)
            ->orderBy('documentID', 'DESC')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
