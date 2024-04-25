<?php

namespace App\Livewire\Page\Marketing\TrailerBooking;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Marketing\TrailerBooking;

class Page extends Component
{

    use WithPagination;

    public $dateStart;
    public $dateEnd;
    public $customerList = [];
    public $customerSearch = "";
    public $salemanList = [];
    public $salemanSearch = "";
    public $query = [];
    public $queryJoborder = [];

    public function mount(){
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->customerList = Customer::all()->sortBy('custNameEN');
        $this->salemanList = Saleman::all()->sortBy('empName');
    }

    #[On('post-search')] 
    public function search() {
        $this->query = [];
        $this->queryJoborder = [];
        if($this->dateStart != null) {
            $this->query[] = ['trailer_booking.documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['trailer_booking.documentDate', '<=', $this->dateEnd];
        }
        if($this->salemanSearch != null) {
            $this->query[] = ['joborder.saleman', '=', $this->salemanSearch];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['joborder.cusCode', $this->customerSearch];
        }
    }

    public function delete($id) {
        TrailerBooking::find($id)->delete();
        $this->render();
    }

    public function render()
    {
        
        return view('livewire.page.marketing.trailer-booking.page', [ 
            // 'data'=> TrailerBooking::join('joborder', 'joborder.documentID', 'trailer_booking.ref_jobID')->where($this->query)->orderBy('trailer_booking.documentID', 'DESC')->paginate(20)
            'data'=> TrailerBooking::where($this->query)->orderBy('documentID', 'DESC')->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
