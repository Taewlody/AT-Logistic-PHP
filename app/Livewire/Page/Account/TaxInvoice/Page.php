<?php

namespace App\Livewire\page\Account\TaxInvoice;

use Livewire\Attributes\On;
use App\Models\Account\TaxInvoice;
use App\Models\Account\TaxInvoiceItems;
use App\Models\Account\Invoice;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Common\Customer;

class Page extends Component
{

    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $documentNo = "";
    public $jobNo = "";
    public $query = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
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
        if($this->documentNo != null) {
            $this->query[] = ['documentID', 'like', '%'.$this->documentNo.'%'];
        }
    }

    public function delete($id) {
        $tax_item = TaxInvoiceItems::where('documentID', $id)->get();
        foreach($tax_item as $item) {
            Invoice::where('documentID', $item->invNo)->update(['taxivRef' => '']);
        }
        TaxInvoiceItems::where('documentID', $id)->delete();
        $tax = TaxInvoice::find($id)->delete();

        $this->render();
    }

    public function render()
    {
        return view('livewire.page.account.tax-invoice.page', [ 'data'=> TaxInvoice::where($this->query)->orderBy('documentID', 'desc')->paginate(20)])->extends('layouts.main')->section('main-content');
    }
}
