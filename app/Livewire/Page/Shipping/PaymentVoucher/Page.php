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
        $this->dateStart = null;
        $this->dateEnd = null;
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
            $this->query[] = ['jobNo', 'like', '%'.$this->jobNo.'%'];
        }
    }


    public function render()
    {
        return view('livewire.page.shipping.payment-voucher.page', [ 'data'=> PaymentVoucher::where($this->query)->orderBy('documentDate', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
