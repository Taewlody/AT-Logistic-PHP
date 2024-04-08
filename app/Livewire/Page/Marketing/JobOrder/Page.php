<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Marketing\JobOrder;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $documentID = '';
    public $invNo = '';
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['saleman', '=', $this->salemanSearch];
        }
        if($this->documentID != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentID.'%'];
        }
        if($this->invNo != null) {
            $this->query[] = ['invoiceNo', 'like', '%'.$this->invNo.'%'];
        }
    }

    public function delete($id) {
        JobOrder::find($id)->delete();
        $this->render();
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.page',[ 
            'data'=> JobOrder::where($this->query)->orderBy('documentID', 'DESC')->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
