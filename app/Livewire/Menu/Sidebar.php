<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class Sidebar extends Component
{
    public $mainMenu = [];

    public $ActiveMenu = '';
    
    public function mount()
    {
        $this->ActiveMenu = $ActiveMenu ?? '';
        $this->mainMenu = [
            [
                'name' => 'Dashboard', 
                'icon' => 'fa fa-th-large', 
                'menu' => [
                    ['name' => 'Dashboard', 'route_name' => 'dashboard']
                ],
            ],
            [
                'name' => 'Common Data', 
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
                ]
            ],
            [
                'name' => 'Marketing',
                'icon' => 'fa fa-shopping-cart',
                'menu' => [
                    ['name' => 'Job Order', 'route_name' => 'job-order'],
                    ['name' => 'Trailer Booking', 'route_name' => 'trailer-booking'],
                    ['name' => 'Bill of Lading', 'route_name' => 'bill-of-lading'],
                ]
            ],
            [
                'name' => 'Customer',
                'icon' => 'fa fa-user-circle-o',
                'menu' => [
                    ['name' => 'Advance Payment', 'route_name' => 'advance-payment'],
                ]
            ],
            [
                'name' => 'Shipping',
                'icon' => 'fa fa-truck',
                'menu' => [
                    ['name' => 'Payment voucher', 'route_name' => 'payment-voucher'],
                    ['name' => 'Petty Cash', 'route_name' => 'petty-cash'],
                    ['name' => 'Deposit', 'route_name' => 'deposit'],
                ]
            ],
            [
                'name' => 'Messenger',
                'icon' => 'fa fa-taxi',
                'menu' => [
                    ['name' => 'messenger booking', 'route_name' => 'messanger-booking'],
                    ['name' => 'Calendar booking', 'route_name' => 'calendar-booking'],
                ]
            ],
            [
                'name' => 'Accounting',
                'icon' => 'fa fa-folder-open',
                'menu' => [
                    ['name' => 'Invoice', 'route_name' => 'invoice'],
                    ['name' => 'Tax Invoice', 'route_name' => 'tax-invoice'],
                    ['name' => 'Payment Voucher', 'route_name' => 'payment-voucher'],
                    ['name' => 'Receipt Voucher', 'route_name' => 'receipt-voucher'],
                    ['name' => 'billing receipt', 'route_name' => 'billing-receipt'],
                    ['name' => 'Petty cash', 'route_name' => 'petty-cash'],
                    ['name' => 'Withholding Tax', 'route_name' => 'withholding-tax'],
                ]
            ],
            [
                'name' => 'Report',
                'icon' => 'fa fa-line-chart',
                'menu' => [
                    ['name' => 'งานระหว่างทำ', 'route_name' => 'report1'],
                    ['name' => 'กำไร-ขาดทุนตาม Job', 'route_name' => 'report2'],
                    ['name' => 'ยอดขายตามใบแจ้งหนี้', 'route_name' => 'report3'],
                    ['name' => 'ยอดขายตามใบกำกับภาษี', 'route_name' => 'report4'],
                    ['name' => 'ใบแจ้งหนี้ค้างชำระ', 'route_name' => 'report5'],
                    ['name' => 'ใบสำคัญจ่าย', 'route_name' => 'report6'],
                    ['name' => 'ใบสำคัญรับ', 'route_name' => 'report7'],
                    ['name' => 'ภาษีขาย', 'route_name' => 'report8'],
                    ['name' => 'ภาษีซื้อ', 'route_name' => 'report9'],
                    ['name' => 'ภาษีหัก ณ ที่จ่าย', 'route_name' => 'report10'],
                ]
            ],
            [
                'name' => 'Administrator',
                'icon' => 'fa fa-cog',
                'menu' => [
                    ['name' => 'UserType', 'route_name' => 'user-type'],
                    ['name' => 'User', 'route_name' => 'user'],
                ]
            ],
        ];
    }

    public function setActiveMenu( $menu)
    {
        Log::info("setActiveMenu: $menu");
        $this->ActiveMenu = $menu;
    }

    public function getActiveMenu()
    {
        return $this->ActiveMenu;
    }

    public function render()
    {
        return view('livewire.menu.sidebar');
    }
}
