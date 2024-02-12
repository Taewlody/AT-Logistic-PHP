<?php

namespace App\Livewire\Page\Marketing\JobOrder;

use App\Models\Common\Charges;
use App\Models\Common\ContainerSize;
use App\Models\Common\ContainerType;
use App\Models\Common\UnitContainer;
use App\Models\Marketing\JobOrder;
use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\Common\TransportType;
use App\Models\Common\Port;
use App\Models\Common\Place;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Common\Feeder;
use App\Models\Marketing\JobOrderContainer;
use App\Models\Marketing\JobOrderPacked;
use App\Models\Marketing\JobOrderGoods;

class Form extends Component
{

    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public $section = [1,2];
    public ?JobOrder $data = null;

    public $transportTypeList = [];
    public $portList = [];
    public $placeList = [];
    public $customerList = [];
    public $salemanList = [];
    public $supplierList = [];
    public $feederList = [];
    public $containerTypeList = [];
    public $containerSizeList = [];
    public $containerUnitList = [];
    public $chargesList = [];



    public $typeContainer = '';
    public $sizeContainer = '';
    public $quantityContainer = 1;

    public $chargeCode = '';

    public function boot()
    {
        $this->data = new JobOrder();
        if ($this->action == '') {
            $this->action = 'view';
        } else {
            $this->action;
        }

        if ($this->id != '') {
            $this->data = JobOrder::find($this->id);
        } else {
            $this->action = 'create';
        }

        $this->transportTypeList = TransportType::all();
        $this->portList = Port::all();
        $this->placeList = Place::all();
        $this->customerList = Customer::all();
        $this->salemanList = Saleman::all();
        $this->supplierList = Supplier::all();
        $this->feederList = Feeder::all();
        $this->containerTypeList = ContainerType::all();
        $this->containerSizeList = ContainerSize::all();
        $this->containerUnitList = UnitContainer::all();
        $this->chargesList = Charges::all();

        if($this->data->containerList->isEmpty()){
            $this->data->containerList->push(new JobOrderContainer());
        }
        if($this->data->packedList->isEmpty()){
            $this->data->packedList->push(new JobOrderPacked());
        }
        if($this->data->goodsList->isEmpty()){
            $this->data->goodsList->push(new JobOrderGoods());
        
        }
    }
    public function mount()
    {
    }

    public function updateSection(int $section)
    {
        if(in_array($section, $this->section)){
            $this->section = array_diff($this->section, [$section]);
        }else{
            array_push($this->section, $section);
        }
    }

    public function addContainer()
    {
        // dd($this->data);
        // $this->data = new JobOrder(($this->data)->toArray());
        // $data = $this->data;
        $dataContainer = new JobOrderContainer(
            [
                'documentID' => $this->data->documentID,
                'containerType' => $this->typeContainer,
                'containerSize' => $this->sizeContainer
            ]
        );
        // dd($data);
        $this->data->containerList->push($dataContainer);
        // $this->data->containerList = $list;
        // $this->data->addContainer(new JobOrderContainer(['documentID' => $this->data->documentID, 'containerType' => $this->typeContainer, 'containerSize' => $this->sizeContainer]));
        $this->reset('typeContainer', 'sizeContainer', 'quantityContainer');
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.form')->extends('layouts.main')->section('main-content');
    }
}
