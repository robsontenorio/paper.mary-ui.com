<?php

use App\Traits\HasCssClassAttribute;
use Livewire\Volt\Component;

new class extends Component {
    use HasCssClassAttribute;
}; ?>

<div class="font-bold text-3xl text-primary sm:ps-4 {{ $class }}">
    <a href="/" wire:navigate>
        <x-icon name="o-paper-airplane" class="w-7 h-7" />
        paper
    </a>
</div>
