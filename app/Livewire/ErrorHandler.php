<?php

namespace App\Livewire;

use Livewire\Component;

class ErrorHandler extends Component
{
    public ?string $errorMessage = null;

    protected $listeners = ['showError'];

    public function showError($message)
    {
        $this->errorMessage = $message;
    }

    public function render()
    {
        return view('livewire.error-handler');
    }
} 