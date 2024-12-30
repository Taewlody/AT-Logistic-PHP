<?php

namespace App\Livewire\Page\Report\ReportProfitAndLossJob;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Marketing\JobOrder;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;

    public $monthSearch = '';
    public $yearSearch = '';
    public $totalAmount;
    public $totalCost;
    public $totalProfit;
    public $totalNetProfit;

    public $query = [];
    public $dateStart;
    public $dateEnd;
    public $documentID = '';
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";


    #[On('post-search')] 
    public function search() {
        $this->query = [];
        $this->queryCustomer = [];

        if($this->dateStart != null) {
            $this->query[] = ['joborder.documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['joborder.documentDate', '<=', $this->dateEnd];
        }
        if($this->documentID != null) {
            $this->query[] = ['joborder.documentID', 'like', '%'.$this->documentID.'%'];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['joborder.cusCode', '=', $this->customerSearch];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['joborder.saleman', '=', $this->salemanSearch];
        }
        $this->getAllData();
    }

    
    public function getAllData()
    {
        $job = Joborder::with(['invoice', 'charge', 'customerRefer'])->whereHas('invoice', function ($query) {
            $query->where('documentID', '!=', '');
        })->where($this->query);

        $chargesbillReceive = 0;
        $chargeCost = 0;

        foreach ($job->get() as $jobOrder) {
            foreach ($jobOrder->charge as $charge) {
                $chargesbillReceive += $charge->chargesbillReceive;
                $chargeCost += $charge->chargesCost;
            }
        }

        $this->totalAmount = $job->sum('total_amt') + $chargesbillReceive;

        $this->totalCost = $chargeCost + $job->sum('tax1') + $job->sum('tax3') + $job->sum('total_vat');

        $this->totalProfit = $this->totalAmount - $this->totalCost;

    }


    // #[Computed]
    // public function getTotalNetProfit()
    // {

    //     $this->totalNetProfit = JobOrder::sum('tax1');
        
    //     return $this->totalNetProfit;
    // }

    public function mount()
    {

        $this->monthSearch = date('m');
        $this->yearSearch = date('Y');

        $this->yearList = range(date('Y'), date('Y')-4);
        
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');

        $this->getAllData();

    }

    public function render()
    {

        $data = Joborder::with(['invoice', 'charge', 'customerRefer'])->whereHas('invoice', function ($query) {
            $query->where('documentID', '!=', '');
        })->where($this->query)->orderBy('documentDate', 'DESC');
        
        
        return view('livewire.page.report.report-profit-and-loss-job.page', ['data'=> $data->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
