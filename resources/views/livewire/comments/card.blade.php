<?php

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Comment $comment;

    public ?Comment $commentEdit;

    public Post $post;

    public function mount(Comment $comment): void
    {
        $this->post = $comment->post;
    }

    // You should use authorization rules here!
    public function delete(Comment $comment): void
    {
        $comment->delete();
        $this->dispatch('comment-done');
    }

    public function edit(Comment $comment): void
    {
        $this->commentEdit = $comment;
    }

    #[On('comment-edited')]
    public function done(): void
    {
        $this->reset('commentEdit');
        $this->dispatch('comment-done');
    }
}; ?>

<div>
    <x-card
        @class(["mt-5", "border border-primary/30" => $comment->author->isOwner()])
        shadow
        separator
    >
        {{--  TITLE --}}
        <x-slot:title class="flex gap-2 items-center">
            <livewire:users.avatar :user="$post->author" />
            <livewire:posts.timestamp :$post />
        </x-slot:title>

        {{-- MENU --}}
        <x-slot:menu>
            @if(! $post->archived_at && $comment->author->isOwner())
                <x-dropdown right>
                    <x-slot:trigger>
                        <x-button icon="o-ellipsis-vertical" class="btn-sm btn-ghost btn-circle" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit" icon="o-pencil" wire:click="edit({{ $comment->id  }})" />
                    <x-menu-item title="Remove" icon="o-trash" wire:click="delete({{ $comment->id  }})" class="text-error" />
                </x-dropdown>
            @endif
        </x-slot:menu>

        {{-- COMMENT BODY --}}
        <div class="leading-7">
            @if($commentEdit?->is($comment))
                <livewire:comments.edit :post="$comment->post" :comment="$comment" wire:key="comment-edit-{{ $comment->id }}" />
            @else
                {!!  nl2br($comment->body) !!}
            @endif
        </div>
    </x-card>
</div>
