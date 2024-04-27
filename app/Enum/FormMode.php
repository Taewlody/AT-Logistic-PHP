<?php 

namespace App\Enum;

enum FormMode: string 
{
    public const READONLY = 'readonly';
    public const DISABLED = 'disabled';
    public const NONE = 'none';

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