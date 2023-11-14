<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\Url;

new class extends Component {
    public ?User $user;

    #[Url]
    public string $selectedTab = 'posts-tab';

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function posts(): Collection
    {
        return $this->user
            ->posts()
            ->withCount('comments')
            ->take(10)
            ->latest()
            ->get();
    }

    public function comments(): Collection
    {
        return $this->user
            ->comments()
            ->with('post.author')
            ->take(10)
            ->latest()
            ->get();
    }

    public function with(): array
    {
        return [
            'posts' => $this->posts(),
            'comments' => $this->comments(),
        ];
    }
}; ?>

<div>
    {{-- HEADER --}}
    <x-avatar :image="$user->avatar" class="!w-20 ring ring-primary ring-offset-base-100 ring-offset-2">
        <x-slot:title class="text-2xl !font-black pl-2">
            {{ $user->username }}
        </x-slot:title>
        <x-slot:subtitle class="text-neutral flex flex-col gap-2 mt-2 pl-2">
            <x-icon name="o-paper-airplane" label="{{ $user->posts()->count() }} posts" />
            <x-icon name="o-chat-bubble-left" label="{{ $user->comments()->count() }} comments" />
        </x-slot:subtitle>
    </x-avatar>

    {{--  TABS  --}}
    <x-tabs wire:model.live="selectedTab" class="mt-14">
        {{--  POSTS  --}}
        <x-tab name="posts-tab" label="Posts" icon="o-paper-airplane">
            <x-card class="!p-0 sm:!p-2">
                @foreach($posts as $post)
                    <x-list-item :item="$post" value="title" avatar="author.avatar" link="/posts/{{ $post->id }}">
                        <x-slot:subValue class="flex items-center gap-3 pt-1">
                            {{ $post->created_at->diffForHumans() }}
                            <x-icon name="o-chat-bubble-left" class="w-4 h-4" :label="$post->comments_count" />
                        </x-slot:subValue>

                        <x-slot:actions>
                            @if($post->archived_at)
                                <x-icon name="o-archive-box" class="w-4 w-4 text-sm" label="Archived" />
                            @endif
                        </x-slot:actions>

                    </x-list-item>
                @endforeach
            </x-card>
        </x-tab>

        {{-- COMMENTS --}}
        <x-tab name="comments-tab" label="Comments" icon="o-chat-bubble-left">
            <x-card class="!p-0 sm:!p-2">
                @foreach($comments as $comment)
                    <x-list-item
                        :item="$comment"
                        value="post.title"
                        avatar="post.author.avatar"
                        link="/posts/{{ $comment->post->id }}"
                    >
                        <x-slot:subValue>
                            <span class="mr-2">{{ $comment->created_at->diffForHumans() }}</span>
                            {{ $comment->body }}
                        </x-slot:subValue>
                    </x-list-item>
                @endforeach
            </x-card>
        </x-tab>
    </x-tabs>
</div>
