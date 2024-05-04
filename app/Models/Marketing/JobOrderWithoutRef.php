<?php 
namespace App\Models\Marketing;

class JobOrderWithoutRef extends JobOrder
{
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['containerList', 'attachs', 'packedList', 'goodsList', 'AdvancePayment', 'charge', 'PaymentVoucher', 'PettyCash'];

}
   