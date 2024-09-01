<?php

namespace App\Livewire\Page\Dashboard\Element;

use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Functions\EngDate;
use App\Models\Common\Supplier;
use App\Models\PettyCash\PettyCash;

class CommissionStaff extends Component
{ 
    public $commission_staff;
    public $yearSearch;

    public function mount()
    {
        $this->yearSearch = date('Y');
        $this->getCommisstionStaff();
    }

    public function getNameSup($sup)
    {
        $name = Supplier::find($sup);
        return $name->supNameTH;
        // dd($name);
    }

    public function getCommisstionStaff()
    {
        // dd('get commission');
        $yearSearch = $this->yearSearch;
        $this->commission_staff = Cache::remember('commission_staff_' . $yearSearch, 60, function () use ($yearSearch) {
            return PettyCash::selectRaw('supCode, MONTH(dueDate) as month, SUM(sumTotal) as sumTotal')
                ->whereRaw("documentstatus = 'A'")
                ->whereYear('dueDate', $yearSearch)
                ->groupBy('supCode', 'month')
                ->orderBy('supCode')
                ->orderBy('month')
                ->get()
                ->mapToGroups(function ($item) {
                    return [$item->supCode => $item];
                });
        });
    }

    public function render()
    {
        // dd($this->expense_payment);
        return view('livewire.page.dashboard.element.commission-staff');
    }
}