<?php

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public Comment $comment;

    #[Rule('required|min:5')]
    public ?string $body;

    public function mount(Comment $comment): void
    {
        $this->body = $comment->body;
    }

    // You should use authorization rules here!
    public function save(): void
    {
        $this->comment->update($this->validate());
        $this->post->touch('updated_at');

        $this->reset('body');
        $this->dispatch('comment-edited');
    }
}; ?>

<div>
    <x-form wire:submit="save" class="flex-1" @keydown.meta.enter="$wire.save()">
        <x-textarea placeholder="Reply..." wire:model="body" />

        <x-slot:actions>
            <x-button label="Cancel" wire:click="$dispatch('comment-edited')" />
            <x-button label="Save" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
