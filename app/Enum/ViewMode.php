<?php

namespace App\Enum;

enum ViewMode: string 
{
    public const CREATE = 'create';
    public const EDIT = 'edit';
    public const VIEW = 'view';

    public static function getValues(): array
    {
        return [
            self::CREATE,
            self::EDIT,
            self::VIEW,
        ];
    }


    public function toFormMode(): FormMode
    {
        return match ($this) {
            'view' => FormMode::from('readonly'),
            'disabled'=> FormMode::from('disabled'),
            ['edit', 'create'] => FormMode::from('none'),
        };
    }

}