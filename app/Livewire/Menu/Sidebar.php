<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Locked;
use Illuminate\Support\Facades\Auth;

// #[Lazy]
class Sidebar extends Component
{
    #[Locked]
    public $mainMenu = [
        [
            'name' => 'Dashboards',
            'menu_name' => 'dashboard', 
            'icon' => 'fa fa-th-large', 
            'roles' => [1,2,3,4,5,6,7],
            'menu' => [
                ['name' => 'Dashboard', 'route_name' => 'dashboard']
            ],
        ],
        [
            'name' => 'Common Data', 
            'menu_name' => 'common',
            'icon' => 'fa fa-bars', 
            'roles' => [1, 6],
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
                ['name' => 'Company', 'route_name' => 'company'],
                ['name' => 'Commodity', 'route_name' => 'commodity']
            ]
         ],
        [
            'name' => 'Marketing',
            'menu_name' => 'marketing',
            'icon' => 'fa fa-shopping-cart',
            'roles' => [1,3,5,6,7],
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
            'roles' => [1,3,4,6,7],
            'menu' => [
                ['name' => 'Advance Payment', 'route_name' => 'advance-payment'],
            ]
        ],
        [
            'name' => 'Shipping',
            'menu_name' => 'shipping',
            'icon' => 'fa fa-truck',
            'roles' => [1,2,6,7],
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
            'roles' => [1,3,4,6,7],
            'menu' => [
                ['name' => 'messenger booking', 'route_name' => 'messanger-booking'],
                ['name' => 'Calendar booking', 'route_name' => 'calendar-booking'],
            ]
        ],
       [
            'name' => 'Account',
            'menu_name' => 'account',
            'icon' => 'fa fa-folder-open',
            'roles' => [1,7],
            'menu' => [
                ['name' => 'Invoice', 'route_name' => 'invoice'],
                ['name' => 'Billing Summary', 'route_name' => 'billing-summary'],
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
            'roles' => [1,7],
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
                ['name' => 'Check Status Job', 'route_name' => 'report-check-status'],
                
            ]
        ],
        [
            'name' => 'Administrator',
            'menu_name' => 'administrator',
            'icon' => 'fa fa-cogs',
            'roles' => [1],
            'menu' => [
                ['name' => 'UserType', 'route_name' => 'user-type'],
                ['name' => 'User', 'route_name' => 'user'],
            ]
        ],
    ];

    public $ActiveMenu = "";
    
    public function mount()
    {
        // $this->ActiveMenu;
        // $this->mainMenu;


        //new add permission

        $userCode = Auth::user()->userTypecode; // Get the userTypecode of the logged-in user

        // Filter the mainMenu based on userCode permissions
        $this->mainMenu = array_filter($this->mainMenu, function($menu) use ($userCode) {
            // Check if the menu has a roles array and if the userCode is allowed
            if (!in_array($userCode, $menu['roles'])) {
                return false;
            }

            // Filter submenu items by the same logic
            if (isset($menu['menu'])) {
                $menu['menu'] = array_filter($menu['menu'], function($submenu) use ($userCode) {
                    return !isset($submenu['roles']) || in_array($userCode, $submenu['roles']);
                });
            }

            return true;
        });


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
