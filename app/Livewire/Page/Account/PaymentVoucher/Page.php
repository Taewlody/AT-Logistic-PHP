<?php

namespace App\Livewire\page\Account\PaymentVoucher;

use Livewire\Attributes\On;
use App\Models\Account\PaymentVoucher;
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
    public $query = [];

    public function mount(){
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
        $this->supplierList = Supplier::all()->sortBy('supNameTH');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        if($this->dateStart != null && $this->dateEnd != null) {
            $this->query[] = ['documentDate', '>=', Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d')];
            $this->query[] = ['documentDate', '<=', Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d')];
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
        return view('livewire.page.account.payment-voucher.page', [ 'data'=> PaymentVoucher::where($this->query)->orderBy('documentDate', 'desc')->paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
