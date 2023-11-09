<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public function comments(): Collection
    {
        return Comment::query()
            ->with(['author', 'post'])
            ->whereBelongsTo($this->post)
            ->oldest()
            ->get();
    }

    #[On('comment-done')]
    public function done(): void
    {
        // None. Just refresh the list from child events when necessary
    }

    // For lazy loading
    public function placeholder(): string
    {
        return <<<'HTML'
        <div>
            <div class="loading loading-spinner"></div>
        </div>
        HTML;
    }

    public function with(): array
    {
        return [
            'comments' => $this->comments()
        ];
    }
}; ?>

<div>
    {{-- COMMENT COUNT --}}
    <div class="font-bold">Comments ({{ $comments->count() }})</div>

    <hr class="mt-5" />

    {{-- COMMENT LIST --}}
    @foreach($comments as $comment)
        <livewire:comments.card :$comment wire:key="comment-{{ $comment->id }}" class="mt-5" />
    @endforeach

    {{-- REPLY --}}
    @if(! $post->archived_at && auth()->user())
        <livewire:comments.create :post="$post" />
    @endif

    {{-- LOGIN--}}
    @if (! auth()->user())
        <x-button label="Log in to reply" link="/login?redirect_url=/posts/{{ $post->id }}" icon-right="o-arrow-right" class="btn-primary mt-10" />
    @endif

</div>
