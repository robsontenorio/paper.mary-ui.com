<?php

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public ?Comment $comment;

    #[Rule('required|min:5')]
    public ?string $body;

    public function mount(Post $post, ?Comment $comment)
    {
        $this->comment = $comment->id ? $comment : new Comment();

        $this->body = $comment?->body;
        $this->post = $post;
    }

    public function save()
    {
        // Update
        if ($this->comment->id) {
            $this->comment->update($this->validate());
        }

        // Create
        if (! $this->comment->id) {
            $this->comment->fill($this->validate());
            $this->comment->author_id = auth()->user()->id;

            $this->post->comments()->save($this->comment);
            $this->post->touch('updated_at');

            $this->comment = new Comment();
        }

        $this->reset('body');
        $this->dispatch('comment-done');
    }
}; ?>

<div>
    <div class="lg:flex gap-8 mt-10">
        @if(! $comment?->id)
            <div>
                <div class="avatar">
                    <div class="w-8 lg:w-16 rounded-full">
                        <img src="{{ auth()->user()?->avatar }}" />
                    </div>
                </div>
            </div>
        @endif

        <x-form wire:submit="save" class="flex-1" @keydown.meta.enter="$wire.save()">
            <x-textarea placeholder="Reply..." wire:model="body" />

            <x-slot:actions>
                @if($comment?->id)
                    <x-button label="Cancel" wire:click="$dispatch('comment-done')" />
                @endif

                <x-button label="Reply" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
