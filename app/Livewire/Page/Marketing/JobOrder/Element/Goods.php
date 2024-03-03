<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Goods extends Component
{
    public $action = '';
    protected array $rules = [
        'value.*' => 'unique:App\Models\Marketing\JobOrderGoods',
        'value.*.items'=> 'number',
        'value.*.comCode'=> 'string',
        'value.*.documentID'=> 'required|string',
        'value.*.goodNo'=> 'string',
        'value.*.goodDec'=> 'string',
        'value.*.goodWeight'=> 'string',
        'value.*.good_unit'=> 'string',
        'value.*.goodUnit'=> 'string',
        'value.*.goodSize'=> 'string',
        'value.*.goodKind'=> 'string',
    ];

    #[Modelable]
    public Collection $value;

    public String|null $good_total_num_package = '';
    public String|null $good_commodity = '';

    public function mount($action, String|null $good_total_num_package = null, String|null $good_commodity = null){
        $this->action = $action;
        $this->good_total_num_package = $good_total_num_package ?? '';
        $this->good_commodity = $good_commodity ?? '';
    }

    public function updatedGoodTotalNumPackage($value, $key) {
        $this->dispatch("Update-Good-Total-Num-Package", $this->good_total_num_package);
    }

    public function updatedGoodCommodity($value, $key) {
        $this->dispatch("Update-Good-Commodity", $this->good_commodity);
    }
    
    public function render()
    {
        return view('livewire.page.marketing.job-order.element.goods');
    }
}
