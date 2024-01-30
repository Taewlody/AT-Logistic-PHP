<?php

namespace App\Livewire\Page\Shipping\PaymentVoucher;

use Livewire\Attributes\On;
use App\Models\Common\Supplier;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Shipping\PaymentVoucher;

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
        $this->dateStart = Carbon::now()->subYear()->format('d/m/Y');
        $this->dateEnd = Carbon::now()->format('d/m/Y');
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
        if($this->dateStart != null && $this->dateEnd != null) {
            $this->query[] = ['documentDate', '>=', Carbon::createFromFormat('d/m/Y', $this->dateStart)->format('Y-m-d')];
            $this->query[] = ['documentDate', '<=', Carbon::createFromFormat('d/m/Y', $this->dateEnd)->format('Y-m-d')];
        }
        if($this->supplierSearch != null) {
            $this->query[] = ['supID', '=', $this->supplierSearch];
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
        return view('livewire.page.shipping.payment-voucher.page', [ 'data'=> PaymentVoucher::where($this->query)->orderBy('documentDate', 'desc')->paginate(50)])->extends('layouts.main')->section('main-content');
    }
}
