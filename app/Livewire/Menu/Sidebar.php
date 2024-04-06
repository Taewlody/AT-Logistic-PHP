<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;

// #[Lazy]
class Sidebar extends Component
{
    #[Locked]
    public $mainMenu = [
        [
            'name' => 'Dashboards',
            'menu_name' => 'dashboard', 
            'icon' => 'fa fa-th-large', 
            'menu' => [
                ['name' => 'Dashboard', 'route_name' => 'dashboard']
            ],
        ],
        [
            'name' => 'Common Data', 
            'menu_name' => 'common',
            'icon' => 'fa fa-bars', 
            'menu' => [
                ['name' => 'Country', 'route_name' => 'country'],
                ['name' => 'Port', 'route_name' => 'port'],
                ['name' => 'Customer', 'route_name' => 'customer'],
                ['name' => 'Supplier', 'route_name' => 'supplier'],
                ['name' => 'Saleman', 'route_name' => 'saleman'],
                ['name' => 'Feeder', 'route_name' => 'feeder'],
                ['name' => 'Charges', 'route_name' => 'charges'],
                ['name' => 'Bank Account', 'route_name' => 'bank-account'],
                ['name' => 'Charges Type', 'route_name' => 'charges-type'],
                ['name' => 'Transport Type', 'route_name' => 'transport-type'],
                ['name' => 'Container Type', 'route_name' => 'container-type'],
                ['name' => 'Container Size', 'route_name' => 'container-size'],
                ['name' => 'Place', 'route_name' => 'place'],
                ['name' => 'Unit', 'route_name' => 'unit'],
                ['name' => 'Currency', 'route_name' => 'currency'],
                ['name' => 'Company', 'route_name' => 'company']
            ]
         ],
        [
            'name' => 'Marketing',
            'menu_name' => 'marketing',
            'icon' => 'fa fa-shopping-cart',
            'menu' => [
                ['name' => 'Job Order', 'route_name' => 'job-order'],
                ['name' => 'Trailer Booking', 'route_name' => 'trailer-booking'],
                ['name' => 'Bill of Lading', 'route_name' => 'bill-of-lading'],
            ]
        ],
        [
            'name' => 'Customer',
            'menu_name' => 'customer',
            'icon' => 'fa fa-user-circle-o',
            'menu' => [
                ['name' => 'Advance Payment', 'route_name' => 'advance-payment'],
            ]
        ],
        [
            'name' => 'Shipping',
            'menu_name' => 'shipping',
            'icon' => 'fa fa-truck',
            'menu' => [
                ['name' => 'Payment voucher', 'route_name' => 'shipping-payment-voucher'],
                ['name' => 'Petty Cash', 'route_name' => 'shipping-petty-cash'],
                ['name' => 'Deposit', 'route_name' => 'deposit'],
            ]
        ],
        [
            'name' => 'Messenger',
            'menu_name' => 'messenger',
            'icon' => 'fa fa-taxi',
            'menu' => [
                ['name' => 'messenger booking', 'route_name' => 'messanger-booking'],
                ['name' => 'Calendar booking', 'route_name' => 'calendar-booking'],
            ]
        ],
       [
            'name' => 'Account',
            'menu_name' => 'account',
            'icon' => 'fa fa-folder-open',
            'menu' => [
                ['name' => 'Invoice', 'route_name' => 'invoice'],
                ['name' => 'Tax Invoice', 'route_name' => 'tax-invoice'],
                ['name' => 'Payment Voucher', 'route_name' => 'account-payment-voucher'],
                ['name' => 'Receipt Voucher', 'route_name' => 'receipt-voucher'],
                ['name' => 'billing receipt', 'route_name' => 'billing-receipt'],
                ['name' => 'Petty cash', 'route_name' => 'account-petty-cash'],
                ['name' => 'Withholding Tax', 'route_name' => 'withholding-tax'],
            ]
        ],
        [
            'name' => 'Report',
            'menu_name' => 'report',
            'icon' => 'fa fa-line-chart',
            'menu' => [
                ['name' => 'งานระหว่างทำ', 'route_name' => 'report-job'],
                ['name' => 'กำไร-ขาดทุนตาม Job', 'route_name' => 'report-profit-and-loss-job'],
                ['name' => 'ยอดขายตามใบแจ้งหนี้', 'route_name' => 'report-sale-invoice'],
                ['name' => 'ยอดขายตามใบกำกับภาษี', 'route_name' => 'report-sale-tax-invoice'],
                ['name' => 'ใบแจ้งหนี้ค้างชำระ', 'route_name' => 'report-invoice-overdue'],
                ['name' => 'ใบสำคัญจ่าย', 'route_name' => 'report-payment-voucher-items'],
                ['name' => 'ใบสำคัญรับ', 'route_name' => 'report-receipt-voucher'],
                ['name' => 'ภาษีขาย', 'route_name' => 'report-tax-invoice'],
                ['name' => 'ภาษีซื้อ', 'route_name' => 'report-payment-voucher'],
                ['name' => 'ภาษีหัก ณ ที่จ่าย', 'route_name' => 'report10'],
                
            ]
        ],
        [
            'name' => 'Administrator',
            'menu_name' => 'administrator',
            'icon' => 'fa fa-cogs',
            'menu' => [
                ['name' => 'UserType', 'route_name' => 'user-type'],
                ['name' => 'User', 'route_name' => 'user'],
            ]
        ],
    ];

    public $ActiveMenu = "";
    
    public function mount()
    {
        $this->ActiveMenu;
        // $this->emit('update', ["mainMenu" => $this->mainMenu]);
        $this->mainMenu;
    }

    // #[Computed]
    public function update(String $ActiveMenu) {
        if($this->ActiveMenu == $ActiveMenu){
            $this->ActiveMenu = "";
        }else{
            $this->ActiveMenu = $ActiveMenu;
        }
        // $this->dispatch('update', ActiveMenu: $this->ActiveMenu);

    }

    public function render()
    {
        return view('livewire.menu.sidebar');
    }
}
