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
    // public $value;

    public function mount($action){
        $this->action = $action;
    }
    
    public function render()
    {
        return view('livewire.page.marketing.job-order.element.goods');
    }
}
