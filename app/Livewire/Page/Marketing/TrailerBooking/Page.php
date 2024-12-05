<?php

namespace App\Livewire\Page\Marketing\TrailerBooking;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Auth;

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
    public $querySale;
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
        // $this->queryJoborder = [];
        // if($this->dateStart != null) {
        //     $this->query[] = ['trailer_booking.documentDate', '>=', $this->dateStart];
        // }
        // if($this->dateEnd != null) {
        //     $this->query[] = ['trailer_booking.documentDate', '<=', $this->dateEnd];
        // }
        // if($this->salemanSearch != null) {
        //     $this->query[] = ['joborder.saleman', '=', $this->salemanSearch];
        // }
        // if($this->customerSearch != null) {
        //     $this->query[] = ['trailer_booking.cusCode', $this->customerSearch];
        // }
        if($this->dateStart != null) {
            $this->query[] = ['documentDate', '>=', $this->dateStart];
        }
        if($this->dateEnd != null) {
            $this->query[] = ['documentDate', '<=', $this->dateEnd];
        }
        if($this->customerSearch != null) {
            $this->query[] = ['cusCode', '=', $this->customerSearch];
        }
    }

    public function delete($id) {
        TrailerBooking::find($id)->delete();
        $this->render();
    }

    public function render()
    {
        if(Auth::user()->UserType->userTypeName == 'Supplier'){
            $data = TrailerBooking::with('jobOrder')->where($this->query)->where('createID', Auth::user()->usercode)->orderBy('documentID', 'DESC');
        }else{
            $data = TrailerBooking::with('jobOrder')
            ->where($this->query)
            ->orderBy('documentID', 'DESC');
        } 

        return view('livewire.page.marketing.trailer-booking.page', [ 
            'data'=> $data->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
