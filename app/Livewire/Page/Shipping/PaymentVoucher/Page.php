<?php

namespace App\Livewire\Page\Shipping\PaymentVoucher;

use Livewire\Attributes\On;
use App\Models\Common\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Payment\PaymentVoucher;

class Page extends Component
{
    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $supplierList = [];
    public $supplierSearch = "";
    public $documentNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = Carbon::now()->subDays(7)->toDateString();
        $this->dateEnd = Carbon::now()->toDateString();
        $this->supplierList = Supplier::all()->sortBy('supNameEN');
    }

    
    public function updating($property, $value) {

        // if($property == 'documentNo') {
        //     $this->query = $this->query('documentID', 'like', '%'.$value.'%');
        // }
        
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
            $this->query[] = ['refJobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }


    public function render()
    {
        $data = PaymentVoucher::with(['supplier', 'docStatus'])
        ->whereBetween('documentDate', [$this->dateStart, $this->dateEnd] )
        // ->whereBetween('documentDate', ['2024/2/1', '2024/2/26'] )
        ->where($this->query)
        ->orderBy('documentDate', 'desc')->paginate(20);
        // dd($d);

        return view('livewire.page.shipping.payment-voucher.page', [ 
            'data'=> $data
            ])->extends('layouts.main')->section('main-content');
    }
}
