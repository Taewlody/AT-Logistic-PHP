<?php 

namespace App\Enum;

enum FormMode: string 
{
    case READONLY = 'readonly';
    case DISABLED = 'disabled';
    case NONE = 'none';

    public static function getValues(): array
    {
        return [
            self::READONLY,
            self::DISABLED,
            self::NONE,
        ];
    }

    public function toViewMode(): ViewMode
    {
        return match ($this) {
            self::READONLY => ViewMode::from('view'),
            self::DISABLED => ViewMode::from('view'),
            self::NONE => ViewMode::from('create'),
        };
    }

    

}