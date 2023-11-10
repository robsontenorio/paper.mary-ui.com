<?php

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {
    public ?User $user;

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
    <x-avatar :image="$user->avatar" class="w-24">
        <x-slot:title class="text-3xl pl-2">
            {{ $user->username }}
        </x-slot:title>
        <x-slot:subtitle class="flex flex-col gap-2 mt-2 pl-2">
            <x-icon name="o-paper-airplane" label="{{ $user->posts()->count() }} posts" />
            <x-icon name="o-chat-bubble-left" label="{{ $user->comments()->count() }} comments" />
        </x-slot:subtitle>
    </x-avatar>

    {{--  TABS  --}}
    <x-tabs selected="posts-tab" class="mt-8">

        {{--  POSTS  --}}
        <x-tab name="posts-tab" label="POSTS" icon="o-paper-airplane">
            <x-card>
                @foreach($posts as $post)
                    <x-list-item :item="$post" value="title" link="/posts/{{ $post->id }}" class="!px-2">
                        <x-slot:subValue class="flex items-center gap-3 pt-1">
                            <x-icon name="o-chat-bubble-left" class="w-4 h-4" label="{{ $post->comments_count }}" />
                            <span class="font-bold">{{ $post->created_at->diffForHumans() }}</span>
                        </x-slot:subValue>
                    </x-list-item>
                @endforeach
            </x-card>
        </x-tab>

        {{-- COMMENTS --}}
        <x-tab name="comments-tab" label="COMMENTS" icon="o-chat-bubble-left">
            <x-card>
                @foreach($comments as $comment)
                    <x-list-item
                        :item="$comment"
                        value="post.title"
                        avatar="post.author.avatar"
                        link="/posts/{{ $comment->post->id }}"
                    >
                        <x-slot:subValue class="flex gap-3">
                            <span class="font-bold">{{ $comment->created_at->diffForHumans() }}</span>
                            {{ $comment->body }}
                        </x-slot:subValue>
                    </x-list-item>
                @endforeach
            </x-card>
        </x-tab>
    </x-tabs>
</div>
