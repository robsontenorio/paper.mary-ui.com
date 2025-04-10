<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\Url;

new class extends Component {
    #[Url]
    public string $search = '';

    #[Url]
    public ?int $category_id = 0;

    #[Url]
    public string $sort = 'updated_at';

    public function sorts(): array
    {
        return [
            [
                'id' => 'updated_at',
                'name' => 'Last updated'
            ],
            [
                'id' => 'created_at',
                'name' => 'Newest'
            ]
        ];
    }

    public function clear(): void
    {
        $this->reset();
    }

    public function categories(): Collection
    {
        return Category::withCount('posts')->get();
    }

    public function posts(): Collection
    {
        return Post::query()
            ->with(['category', 'author', 'latestComment'])
            ->withCount('comments')
            ->when($this->category_id, fn(Builder $q) => $q->where('category_id', $this->category_id))
            ->where('title', 'like', "%$this->search%")
            ->take(10)
            ->latest($this->sort)
            ->get();
    }

    public function with(): array
    {
        return [
            'categories' => $this->categories(),
            'posts' => $this->posts(),
            'sorts' => $this->sorts()
        ];
    }
}; ?>

<div>
    <x-header title="Posts" separator progress-indicator />

    <div class="grid gap-3 sm:flex sm:justify-between">
        <x-input placeholder="Search ..." wire:model.live.debounce="search" icon="o-magnifying-glass">
            <x-slot:prepend>
                <x-select wire:model.live="category_id" :options="$categories" placeholder="All" placeholder-value="0" class="join-item !min-w-30" icon="o-tag" />
            </x-slot:prepend>
        </x-input>

        <x-group wire:model.live="sort" :options="$sorts" class="[&:checked]:!btn-primary btn-sm" />
    </div>

    <x-card class="mt-10 !p-0 sm:!p-2" shadow>
        {{-- POSTS LIST --}}
        @forelse($posts as $post)
            <x-list-item :item="$post" value="title" sub-value="body" avatar="author.avatar" link="/posts/{{ $post->id }}">
                {{--  SUB VALUE  --}}
                <x-slot:subValue class="flex items-center gap-3 pt-0.5">
                    @if($post->latestComment)
                        <x-icon name="o-arrow-uturn-left" class="w-4 h-4 font-bold" label="{{ $post->latestComment?->author->username }}" />
                        <livewire:timestamp :dateTime="$post->latestComment?->created_at" wire:key="time-{{ $post->id }}" />
                    @else
                        <livewire:timestamp :dateTime="$post->updated_at" wire:key="time-{{  $post->id }}" />
                    @endif

                    @if($post->archived_at)
                        <x-icon name="o-archive-box" class="w-4 h-4" label="Archived" />
                    @endif
                </x-slot:subValue>

                {{-- ACTIONS --}}
                <x-slot:actions>
                    <livewire:categories.tag :category="$post->category" class="hidden lg:inline-flex" wire:key="tag-{{ $post->id }}-{{ $post->category_id }}" />
                    <x-icon name="o-chat-bubble-left" class="w-4 h-4 text-sm" label="{{ $post->comments_count }}" />
                </x-slot:actions>
            </x-list-item>
        @empty
            {{-- NO RESULTS--}}
            <x-alert title="Nothing here!" description="Try to remove some filters." icon="o-exclamation-triangle" class="bg-base-100 border-none">
                <x-slot:actions>
                    <x-button label="Clear filters" wire:click="clear" icon="o-x-mark" spinner />
                </x-slot:actions>
            </x-alert>
        @endforelse
    </x-card>
</div>
