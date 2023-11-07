<?php

use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    #[Computed]
    public function categories(): Collection
    {
        return Category::query()->withCount('posts')->get();
    }

    public function with(): array
    {
        return [
            'categories' => $this->categories()
        ];
    }
}; ?>

<div>
    @foreach($categories as $category)
        <div class="my-3" wire:key="{{ $category->id }}">
            <a href="/?category_id={{$category->id}}" wire:navigate>
                <x-badge :value="$category->posts_count" class="badge-sm font-mono {{ $category->color }}" /> {{ $category->name }}
            </a>
        </div>
    @endforeach
</div>
