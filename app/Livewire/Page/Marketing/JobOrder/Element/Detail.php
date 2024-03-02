<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element;

use App\Models\Marketing\JobOrder;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Renderless;
use Livewire\Component;

#[Renderless]
class Detail extends Component
{

    public $action = '';
    
    #[Modelable]
    public JobOrder $value;

    public function mount($action){
        $this->action = $action;
    }

    public function render()
    {
        return view('livewire.page.marketing.job-order.element.detail');
    }
}
