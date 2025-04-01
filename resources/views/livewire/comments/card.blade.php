<?php

use App\Models\Comment;
use App\Models\Post;
use App\Traits\HasCssClassAttribute;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    use HasCssClassAttribute;

    public Post $post;

    public Comment $comment;

    public bool $editing = false;

    #[Rule('required|min:5')]
    public ?string $body;

    public function mount(Comment $comment): void
    {
        $this->post = $comment->post;
        $this->body = $comment->body;
    }

    // You should use authorization rules here!
    public function delete(Comment $comment): void
    {
        $comment->delete();
        $this->dispatch('comment-done');
    }

    // You should use authorization rules here!
    public function save(): void
    {
        $this->comment->update($this->validate());
        $this->post->touch('updated_at');

        $this->editing = false;
    }
}; ?>

<div>
    <x-card
        @class([$class, "border border-primary/30" => $comment->author->isMyself()])
        wire:loading.class="opacity-60 border-dashed !border-primary"
        wire:target="delete,save"
        shadow
        separator
    >
        {{--  TITLE --}}
        <x-slot:title class="!text-sm flex gap-2 items-center">
            <x-avatar :image="$comment->author->avatar" :title="$comment->author->username" />
            <livewire:timestamp :dateTime="$comment->created_at" />
        </x-slot:title>

        {{-- MENU --}}
        <x-slot:menu>
            @if(! $post->archived_at && $comment->author->isMyself())
                <x-dropdown right>
                    <x-slot:trigger>
                        <x-button icon="o-ellipsis-vertical" class="btn-sm btn-ghost btn-circle" />
                    </x-slot:trigger>
                    <x-menu-item title="Edit" icon="o-pencil-square" @click="$wire.editing = true" />
                    <x-menu-item title="Remove" icon="o-trash" wire:click="delete({{ $comment->id  }})" class="text-error" />
                </x-dropdown>
            @endif
        </x-slot:menu>

        {{-- COMMENT --}}
        <div class="text-sm/7">
            {{--  BODY  --}}
            <div x-show="!$wire.editing">
                {!! nl2br(e($comment->body)) !!}
            </div>

            {{-- EDIT FORM --}}
            <x-form x-show="$wire.editing" wire:submit="save" class="flex-1" @keydown.meta.enter="$wire.save()">
                <x-textarea placeholder="Reply..." wire:model="body" />

                <x-slot:actions>
                    <x-button label="Cancel" @click="$wire.editing = false" />
                    <x-button label="Save" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
                </x-slot:actions>
            </x-form>
        </div>
    </x-card>
</div>
