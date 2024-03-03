<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Models\Common\Charges;
use App\Models\Common\Customer;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\JobOrderCharge;
use App\Models\Marketing\JobOrderContainer;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Marketing\JobOrderPacked;
use App\Models\Marketing\JobOrderGoods;


class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    private ?JobOrder $data = null;

    public $job;

    public $createBy;

    public $editBy;

    public Collection $containerList;

    public Collection $packagedList;

    public Collection $goodsList;

    public Collection $chargeList;

    public Collection $advancePayment;


    protected array $rules = [
        // 'data.charge.*' => 'unique:App\Models\Marketing\JobOrderCharge',\
        'containerList.*'=> 'unique:App\Models\Marketing\JobOrderContainer',
        'containerList.*.items'=> 'integer',
        'containerList.*.comCode'=> 'string',
        'containerList.*.documentID'=> 'required|string',
        'containerList.*.containerType'=> 'string',
        'containerList.*.containerSize'=> 'string',
        'containerList.*.containerNo'=> 'string',
        'containerList.*.containerSealNo'=> 'string',
        'containerList.*.containerGW'=> 'string',
        'containerList.*.containerGW_unit'=> 'string',
        'containerList.*.containerNW'=> 'string',
        'containerList.*.containerNW_Unit'=> 'string',
        'containerList.*.containerTareweight'=> 'string',
        'packagedList.*'=> 'unique:App\Models\Marketing\JobOrderPacked',
        'packagedList.*.items'=> 'integer',
        'packagedList.*.comCode'=> 'string',
        'packagedList.*.documentID'=> 'required|string',
        'packagedList.*.packaed_width'=> 'string',
        'packagedList.*.packaed_length'=> 'string',
        'packagedList.*.packaed_height'=> 'string',
        'packagedList.*.packaed_qty'=> 'string',
        'packagedList.*.packaed_weight'=> 'string',
        'packagedList.*.packaed_unit'=> 'string',
        'packagedList.*.packaed_totalCBM'=> 'string',
        'packagedList.*.packaed_totalWeight'=> 'string',
        'goodsList.*' => 'unique:App\Models\Marketing\JobOrderGoods',
        'goodsList.*.items'=> 'integer',
        'goodsList.*.comCode'=> 'string',
        'goodsList.*.documentID'=> 'required|string',
        'goodsList.*.goodNo'=> 'string',
        'goodsList.*.goodDec'=> 'string',
        'goodsList.*.goodWeight'=> 'string',
        'goodsList.*.good_unit'=> 'string',
        'goodsList.*.goodUnit'=> 'string',
        'goodsList.*.goodSize'=> 'string',
        'goodsList.*.goodKind'=> 'string',
        'chargeList.*' => 'unique:App\Models\Marketing\JobOrderCharge',
        'chargeList.*.items'=> 'integer',
        'chargeList.*.comCode'=> 'string',
        'chargeList.*.documentID'=> 'required|string',
        'chargeList.*.ref_paymentCode'=> 'string',
        'chargeList.*.chargeCode'=> 'string',
        'chargeList.*.detail'=> 'string',
        'chargeList.*.chargesCost'=> 'string',
        'chargeList.*.chargesReceive'=> 'string',
        'chargeList.*.chargesbillReceive'=> 'string'
    ];

    public function boot()
    {
        
    }

    public function mount()
    {
        $this->data = new JobOrder;
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = JobOrder::find($this->id);
            if($this->data == null){
                $this->data = new JobOrder;
            }
            dd($this->data);
        } else {
            $this->action = 'create';
            // $this->data->documentID = JobOrder::GenKey();
            // dd($this->data);
        }
        // dd($this->data, new JobOrder);
        $this->job = $this->data->withoutRelations();
        // if($this->job->good_total_num_package == null) $this->job->good_total_num_package = '';
        // if($this->job->good_commodity == null) $this->job->good_commodity = '';
        $this->createBy = $this->data->userCreate;
        $this->editBy = $this->data->userEdit;
        $this->containerList = $this->data->containerList;
        $this->packagedList= $this->data->packedList;
        $this->goodsList = $this->data->goodsList;
        $this->chargeList = $this->data->charge;
        $this->advancePayment = $this->data->AdvancePayment;
        // dd($this->job->toArray());
    }

    #[On('Add-Container')]
    public function addContainer($typeContainer, $sizeContainer, $quantityContainer)
    {
        $dataContainer = new JobOrderContainer;
        $dataContainer->documentID = $this->job->documentID;
        $dataContainer->comCode = 'C01';
        $dataContainer->containerType = $typeContainer;
        $dataContainer->containerSize = $sizeContainer;
        for ($i = 1; $i <= $quantityContainer; $i++) {
            $this->containerList->push($dataContainer);
        }
        // $this->skipRender();
    }

    #[On('Remove-Container')]
    public function removeContainer(int $index){
        $this->containerList->forget($index);
        $this->containerList = $this->containerList->values();
    }

    #[On('Add-Packaged')]
    public function addRowPacked()
    {
        $dataPacked = new JobOrderPacked;
        $dataPacked->documentID = $this->job->documentID;
        $dataPacked->comCode = 'C01';
        $this->packagedList->push($dataPacked);
    }

    #[On('Remove-Packaged')]
    public function removeRowPacked(int $index){
        $this->packagedList->forget($index);
        $this->packagedList = $this->packagedList->values();
    }

    #[On('Add-Goods')]
    public function addGoods(){
        $goods = new JobOrderGoods;
        $goods->documentID = $this->job->documentID;
        $goods->comCode = 'C01';
        $this->goodsList->push($goods);
    }

    #[On('Remove-Goods')]
    public function removeGoods(int $index){
        $this->goodsList->forget($index);
        $this->goodsList = $this->goodsList->values();
    }

    #[On('Update-Good-Total-Num-Package')]
    public function GoodTotalPackage($value){
        $this->job->good_total_num_package = $value;
        $this->skipRender();
    }

    #[On('Update-Good-Commodity')]
    public function GoodCommodity($value){
        $this->job->good_commodity = $value;
        $this->skipRender();
    }

    #[On('Add-Charge')]
    public function addCharge($chargeCode)
    {
        $charge = new JobOrderCharge;
        $charge->documentID = $this->job->documentID;
        $charge->comCode = 'C01';
        $charge->chargeCode = $chargeCode;
        $getCharge = Charges::find($chargeCode);
        if($getCharge != null)
        {
            $charge->detail = $getCharge->chargeName;
        }
        $this->chargeList->push($charge);
    }

    #[On('Remove-Charge')]
    public function removeCharge($index){
        $this->chargeList->forget($index);
        $this->chargeList =  $this->chargeList->values();
    }

    #[Computed]
    public function groupedContainer()
    {
        if($this->containerList->isNotEmpty()){
            return $this->containerList->groupBy('referContainerSize.containersizeName')->map(function($item, $key){
                return collect($item)->count();
            })->toArray();
        }else{
            return [];
        }

    }

    public function save() {
        // if($this->job->getKey() == null) {
        //     dd($this->job);
        // }
        // dd($this->job->cusCode);
        // $customer = Customer::find($this->job->cusCode);
        // $this->job->customerRefer()->associate($customer);
        // $this->job->customerRefer()->save($customer);
        // dd($this->job->customerRefer);
        $this->job->save();
        $this->job->containerList()->saveMany($this->containerList->map(function(JobOrderContainer $item) {
            if($item->documentID == null || $item->documentID == ''){
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->packedList()->saveMany($this->packagedList->map(function(JobOrderPacked $item) {
            if($item->documentID == null || $item->documentID == ''){
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->goodsList()->saveMany($this->goodsList->map(function(JobOrderGoods $item){
            if( $item->documentID == null || $item->documentID == ''){
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->job->charge()->saveMany($this->chargeList->map(function(JobOrderCharge $item) {
            if( $item->documentID == null || $item->documentID == ''){
                $item->documentID = $this->job->getKey();
            }
            return $item;
        }));
        $this->redirectRoute('job-order');
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
