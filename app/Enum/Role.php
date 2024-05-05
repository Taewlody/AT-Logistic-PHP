<?php 

namespace App\Enum;

enum Role: string 
{
    public const ADMIN = 'Admin';
    public const USER = 'User';
    public const SUPPLIER = 'Supplier';
    public const CUSTOMER = 'Customer';
    public const SALE = 'Sale';
    public const SHIPPING = 'Shipping';
    public const ACCOUNT = 'Account';

    public static function getValues(): array
    {
        return [
            self::ADMIN,
            self::USER,
            self::SUPPLIER,
            self::CUSTOMER,
            self::SALE,
            self::SHIPPING,
            self::ACCOUNT,
        ];
    }

}