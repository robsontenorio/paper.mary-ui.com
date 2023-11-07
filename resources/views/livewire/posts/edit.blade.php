<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public ?Post $post;

    #[Rule('required|min:5')]
    public string $title;

    #[Rule('required|min:10')]
    public string $body;

    #[Rule('required')]
    public string $category_id;

    public function mount(Post $post)
    {
        $post->id
            ? $this->fill($post)
            : $this->post = new Post();
    }

    public function categories(): Collection
    {
        return Category::all();
    }

    public function save()
    {
        // Update
        if ($this->post->id) {
            $this->post->update($this->validate());
        }

        // Create
        if (! $this->post->id) {
            $this->post->fill($this->validate());
            $this->post->author_id = auth()->user()->id;
            $this->post->save();
        }

        $this->success('Post saved.', redirectTo: "/posts/{$this->post->id}");
    }

    public function with(): array
    {
        return [
            'categories' => $this->categories()
        ];
    }
}; ?>

<div>
    <x-header title="{{ $post->id ? 'Edit' : 'Create' }} Post" separator />

    <div class="grid lg:grid-cols-4 gap-10">
        <x-form wire:submit="save" class="col-span-3">
            <x-input label="Title" wire:model="title" />

            <x-select label="Category" wire:model="category_id" placeholder="Select a category" :options="$categories" />

            <x-textarea label="Body" wire:model="body" rows="10" @keydown.meta.enter="$wire.save()" />

            <x-slot:actions>
                <x-button label="Cancel" link='{{ $post->id ? "/posts/$post->id" : "/" }}' />
                <x-button label="{{ $post->id ? 'Update' : 'Create' }}" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
            </x-slot:actions>
        </x-form>
        <div class="col-span-1">
            <img src="/create-post.png" width="400" />
        </div>
    </div>
</div>
