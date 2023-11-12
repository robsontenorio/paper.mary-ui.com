<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class extends Component {
    public DateTime $dateTime;
}; ?>

<div class="text-xs font-normal text-gray-500 tooltip" data-tip="{{ $dateTime }}">
    {{ $dateTime->diffForHumans() }}
</div>

