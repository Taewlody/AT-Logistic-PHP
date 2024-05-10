<?php

namespace App\Enum;

use App\Enum\FormMode;
enum ViewMode: string 
{
    case CREATE = 'create';
    case EDIT = 'edit';
    case VIEW = 'view';

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
            self::CREATE => FormMode::from('none'),
            self::EDIT => FormMode::from('none'),
            self::VIEW => FormMode::from('disabled'),
        };
    }

}