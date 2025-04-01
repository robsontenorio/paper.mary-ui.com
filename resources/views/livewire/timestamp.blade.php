<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class extends Component {
    public DateTime $dateTime;
}; ?>

<div class="text-xs font-normal text-base-content/60 tooltip" data-tip="{{ $dateTime }}">
    {{ $dateTime->diffForHumans() }}
</div>

