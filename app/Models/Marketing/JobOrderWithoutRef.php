<?php 
namespace App\Models\Marketing;
use Livewire\Wireable;

class JobOrderWithoutRef extends JobOrder implements Wireable
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['containerList', 'attachs', 'packedList', 'goodsList', 'AdvancePayment', 'charge', 'PaymentVoucher', 'PettyCash'];

}
   