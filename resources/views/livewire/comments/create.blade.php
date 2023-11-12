<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    #[Rule('required|min:5')]
    public ?string $body;

    // You should use authorization rules here!
    public function save(): void
    {
        $comment = (new Comment())->fill($this->validate());
        $comment->author_id = auth()->user()->id;

        $this->post->comments()->save($comment);
        $this->post->touch('updated_at');

        $this->reset('body');
        $this->dispatch('comment-done');
    }
}; ?>

<div class="lg:flex gap-5 mt-10">
    <div class="hidden lg:block">
        <x-avatar image="{{ auth()->user()?->avatar }}" class="!w-8 lg:!w-16" />
    </div>
    <x-form wire:submit="save" class="flex-1" @keydown.meta.enter="$wire.save()">
        <x-textarea placeholder="Reply..." wire:model="body" />

        <x-slot:actions>
            <x-button label="Reply" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
