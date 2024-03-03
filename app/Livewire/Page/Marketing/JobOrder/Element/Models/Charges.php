<?php


namespace App\Livewire\Page\Marketing\JobOrder\Element\Models;
use App\Models\Marketing\JobOrderCharge;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Livewire\Wireable;


class JobCharge extends Synth {

    public static $key = 'JobCharge';
   
    /**
     *
     * @param mixed $target
     */
    static function match($target) {
        return $target instanceof JobOrderCharge;
    }

    static function dehydrate($target) {
        return $target->toArray();
    }

    /**
     *
     * @param mixed $target
     * @return mixed
     */
    public function hydrate($target) {
        return $target;
    }
}