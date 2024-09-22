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
    }

    #[Computed]
    public function getTotalAmount()
    {

        $this->totalAmount = JobOrder::sum('total_amt');
        return $this->totalAmount;
    }

    #[Computed]
    public function getTotalCost()
    {

        $jobOrders = JobOrder::with('charge')->get();

        foreach ($jobOrders as $jobOrder) {
            foreach ($jobOrder->charge as $charge) {
                $this->totalCost += $charge->chargesCost;
            }
        }
        
        return $this->totalCost;
    }

    #[Computed]
    public function getTotalProfit()
    {

        $this->totalProfit = JobOrder::sum('tax3');
        // $this->totalProfit = JobOrder::with('charge')->get()->sum(function($jobOrder) {
        //     $totalChargesCost = 0;
        //     foreach ($jobOrder->charge as $charge) {
        //         $totalChargesCost += $charge->chargesCost;
        //     }
        //     $difference = $jobOrder->total_amt - $totalChargesCost - $jobOrder->total_vat;
        //     return $difference;

        // });
        
        return $this->totalProfit;
    }

    #[Computed]
    public function getTotalNetProfit()
    {

        $this->totalNetProfit = JobOrder::sum('tax1');
        // $this->totalNetProfit = JobOrder::with('charge')->get()->sum(function($jobOrder) {
        //     $totalChargesCost = 0;
        //     foreach ($jobOrder->charge as $charge) {
        //         $totalChargesCost += $charge->chargesCost;
        //     }
        //     $difference = $jobOrder->total_amt - $totalChargesCost - $jobOrder->total_vat - $jobOrder->tax3 - $jobOrder->tax1;
        //     return $difference;

        // });
        
        return $this->totalNetProfit;
    }

    public function mount()
    {

        $this->monthSearch = date('m');
        $this->yearSearch = date('Y');

        $this->yearList = range(date('Y'), date('Y')-4);
        
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');

    }

    public function render()
    {
        // $data = JobOrder::with(['charge', 'customerRefer'])->orderBy('documentDate', 'DESC')->get();
        $data = JobOrder::selectRaw("joborder.documentID, 
        joborder.tax3, joborder.tax1,
        joborder.total_amt, 
        documentDate, 
        SUM(joborder_charge.chargesCost) as cost, 
        joborder.total_amt - SUM('joborder_charge.chargesCost') - joborder.total_vat as profit, 
        joborder.total_amt - SUM('joborder_charge.chargesCost') - joborder.total_vat - joborder.tax3 - joborder.tax1 as netprofit, common_customer.custNameEN")
        ->join('joborder_charge', 'joborder_charge.documentID', 'joborder.documentID')
        ->join('common_customer', 'common_customer.cusCode', 'joborder.cusCode')
        ->where($this->query)
        ->groupBy('joborder.documentID', 'joborder.documentDate', 'joborder.total_amt', 'joborder.total_vat', 'joborder.tax3', 'joborder.tax1', 'common_customer.custNameEN')
        ->orderBy('documentDate', 'DESC');
        
        return view('livewire.page.report.report-profit-and-loss-job.page', ['data'=> $data->paginate(20)
        ])->extends('layouts.main')->section('main-content');
    }
}
