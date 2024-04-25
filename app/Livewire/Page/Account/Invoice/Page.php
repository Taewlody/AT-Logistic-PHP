<?php

namespace App\Livewire\Page\Account\Invoice;

use Livewire\Attributes\On;
use App\Models\Account\Invoice;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Page extends Component
{

    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $invNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('salemanNameEN');
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
        if($this->invNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->invNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['ref_jobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }

    public function delete($id) {
        Invoice::find($id)->delete();
        $this->render();
    }

    public function render()
    {
        return view('livewire.page.account.invoice.page', [ 'data'=> Invoice::where($this->query)->orderBy('documentID', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
