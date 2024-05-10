<?php

namespace App\Livewire\Page\Marketing\JobOrder\Element\Models;
use App\Models\Common\ChargesType;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;

class JobChargeType extends Synth {
    
    public static $key = 'charges_type';

    /**
     *
     * @param mixed $target
     * @return bool
     */
    public static function match($target) {
        return $target instanceof ChargesType;
    }

    /**
     *
     * @param mixed $target
     * @return array
     */
    public static function dehydrate($target) {
        return $target->toArray();
    }

    /**
     *
     * @param mixed $target
     * @return mixed
     */
    public function hydrate($target) {
        return new ChargesType($target);
    }

    /**
     *
     * @param mixed $target
     * @param string $key
     * @return mixed
     */
    public function get(&$target, $key) {
        return $target->{$key};
    }

    /**
     *
     * @param mixed $target
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(&$target, $key, $value) {
        $target->{$key} = $value;
    }

}