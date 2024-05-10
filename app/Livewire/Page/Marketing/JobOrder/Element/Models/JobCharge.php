<?php


namespace App\Livewire\Page\Marketing\JobOrder\Element\Models;
use App\Models\Marketing\JobOrderCharge;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Mechanisms\HandleComponents\Synthesizers\Synth;
use Livewire\Wireable;


class JobCharge extends Synth {

    public static $key = 'value';
   
    /**
     *
     * @param mixed $target
     */
    static function match($target) {
        if (!$target instanceof Collection) {
            return false;
        }
        if ($target->isEmpty()) {
            return false;
        }
        if (!$target->first() instanceof JobOrderCharge) {
            return false;
        }
    }

    static function dehydrate($target) {
        return [$target->toArray(), []];
    }

    /**
     *
     * @param mixed $target
     * @return mixed
     */
    public function hydrate($target) {
        return new JobOrderCharge($target);
    }

    public function get(&$target, $key) {
        return $target->{$key};
    }

    public function set(&$target, $key, $value) {
        $target->{$key} = $value;
    }
}