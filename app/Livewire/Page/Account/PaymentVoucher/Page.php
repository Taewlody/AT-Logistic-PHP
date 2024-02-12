<?php

namespace App\Livewire\page\Account\PaymentVoucher;

use Livewire\Attributes\On;
use App\Models\Payment\PaymentVoucher;
use App\Models\Common\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Page extends Component
{

    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $supplierList = [];
    public $supplierSearch = "";
    public $invoiceNo = "";
    public $jobNo = "";
    public $documentNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->supplierList = Supplier::all()->sortBy('supNameTH');
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
        if($this->supplierSearch != null) {
            $this->query[] = ['supCode', '=', $this->supplierSearch];
        }
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
        if($this->jobNo != null) {
            $this->query[] = ['refjobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }

    public function render()
    {
        return view('livewire.page.account.payment-voucher.page', [ 'data'=> PaymentVoucher::where($this->query)->orderBy('documentDate', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
