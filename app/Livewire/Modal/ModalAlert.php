<?php

namespace App\Livewire\Modal;

use Livewire\Component;

class ModalAlert extends Component
{
    public bool $autoClose = true;

    public function mount(bool|null $autoClose = null)
    {
        $this->autoClose = $autoClose ?? $this->autoClose;
    }

    public function render()
    {
        return view('livewire.modal.modal-alert');
    }
}
