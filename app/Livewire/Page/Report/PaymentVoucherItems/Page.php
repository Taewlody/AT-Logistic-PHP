<?php

namespace App\Livewire\Page\Report\PaymentVoucherItems;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Payment\PaymentVoucher;
use App\Models\Common\Customer;
use App\Models\Common\Supplier;

class Page extends Component
{
    use WithPagination;

    public $query = [];
    public $dateStart;
    public $dateEnd;
    public $documentID = '';
    public $supplierList = [];
    public $supplierSearch = "";

    #[On('post-search')] 
    public function search() {
        $this->query = [];

        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->documentID != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentID.'%'];
        }
        if($this->supplierSearch != null) {
            $this->query[] = ['supCode', '=', $this->supplierSearch];
        }
    }

    public function mount()
    {
        $this->dateStart = Carbon::parse('first day of this month')->format('Y-m-d');
        $this->dateEnd = Carbon::parse('last day of this month')->format('Y-m-d');
        $this->supplierList = Supplier::all()->sortBy('supNameEN');
        $this->search();

    }

    public function render()
    {
        return view('livewire.page.report.payment-voucher-items.page',[ 
            'data'=> PaymentVoucher::with(['items', 'supplier', 'docStatus'])
            ->where($this->query)
            ->orderBy('documentID', 'DESC')
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
