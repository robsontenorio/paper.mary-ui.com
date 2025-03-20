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

    public Post $post;

    #[Rule('required|min:5')]
    public string $title;

    #[Rule('required|min:10')]
    public string $body;

    #[Rule('required')]
    public string $category_id;

    public function mount(Post $post): void
    {
        $this->fill($post);
    }

    public function categories(): Collection
    {
        return Category::all();
    }

    // You should use authorization here
    public function save()
    {
        $this->post->update($this->validate());
        $this->success('Post updated.', redirectTo: "/posts/{$this->post->id}");
    }

    public function with(): array
    {
        return [
            'categories' => $this->categories()
        ];
    }
} ?>

<div>
    <x-header title="Edit Post" separator />

    <div class="grid lg:grid-cols-12 gap-10">
        <x-form wire:submit="save" class="col-span-7">
            <x-input label="Title" wire:model="title" />

            <x-select label="Category" wire:model="category_id" placeholder="Select a category" :options="$categories" />

            <x-textarea label="Body" wire:model="body" rows="10" @keydown.meta.enter="$wire.save()" />

            <x-slot:actions>
                <x-button label="Cancel" link="/posts/{{  $post->id }}" />
                <x-button label="Update" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="save" />
            </x-slot:actions>
        </x-form>
        <div class="col-span-5">
            <img src="/edit-post.png" width="400" />
        </div>
    </div>
</div>
