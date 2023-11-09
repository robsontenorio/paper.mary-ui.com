<?php

use App\Models\Post;
use Livewire\Attributes\Renderless;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Post $post;

    public function archive(): void
    {
        $this->post->update(['archived_at' => now()]);
        $this->warning('Post archived.');
    }

    public function unarchive(): void
    {
        $this->post->update(['archived_at' => null]);
        $this->success('Post unarchived.');
    }
}; ?>

<div>
    {{--  TITLE  --}}
    <div class="font-extrabold text-4xl"> {{ $post->title }} </div>

    {{--  OPTIONS: ARCHIVE/EDIT  --}}
    <div class="mt-3 flex flex-wrap gap-3 lg:gap-8 items-center justify-between">
        <livewire:categories.tag :category="$post->category" />

        @if($post->author->isOwner())
            <div>
                @if(! $post->archived_at)
                    <x-button label="Archive" wire:click="archive" icon="o-archive-box" class="btn-sm btn-ghost" />
                    <x-button label="Edit" link="/posts/{{ $post->id }}/edit" icon="o-pencil" class="btn-sm btn-ghost" />
                @else
                    <x-button label="Unarchive" wire:click="unarchive" icon="o-archive-box" class="btn-sm btn-ghost" />
                @endif
            </div>
        @endif
    </div>

    <hr class="my-5" />

    {{--  POST BODY  --}}
    <x-card class="leading-7 mb-10 border" separator shadow>

        {{--  TITLE --}}
        <x-slot:title class="flex gap-2 items-center">
            <livewire:users.avatar :user="$post->author" />
            <livewire:timestamp :dateTime="$post->created_at" />
        </x-slot:title>

        {{--   BODY  --}}
        {!! nl2br($post->body) !!}
    </x-card>

    {{--  ARCHIVED WARNING  --}}
    @if($post->archived_at)
        <x-alert title="This post was archived {{ $post->archived_at->diffForHumans() }}" icon="o-archive-box" class="alert-warning mb-10" />
    @endif

    {{--  COMMENTS --}}
    <livewire:comments.index :post="$post" />
</div>
