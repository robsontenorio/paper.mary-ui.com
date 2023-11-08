<?php

use App\Models\Post;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;
}; ?>

<div class="text-xs font-normal text-gray-500 tooltip" data-tip="{{ $post->created_at }}">
    {{ $post->created_at->diffForHumans() }}
</div>

