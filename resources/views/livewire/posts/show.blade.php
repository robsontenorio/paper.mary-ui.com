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
    <x-header :title="$post->title" separator>
        <x-slot:actions>
            @if($post->author->isMyself())
                <div>
                    @if(! $post->archived_at)
                        <x-button label="Archive" wire:click="archive" icon="o-archive-box" class="btn-sm btn-ghost" responsive />
                        <x-button label="Edit" link="/posts/{{ $post->id }}/edit" icon="o-pencil-square" class="btn-sm btn-ghost" responsive />
                    @else
                        <x-button label="Unarchive" wire:click="unarchive" icon="o-archive-box" class="btn-sm btn-ghost" responsive />
                    @endif
                </div>
            @endif
        </x-slot:actions>
    </x-header>

    <div class="-mt-8 mb-5">
        <livewire:categories.tag :category="$post->category" />
    </div>

    {{--  POST BODY  --}}
    <x-card class="text-sm/7 mb-10 border border-base-content/10" separator shadow>
        {{--  TITLE --}}
        <x-slot:title class="!text-sm flex gap-2 items-center">
            <x-avatar :image="$post->author->avatar" :title="$post->author->username" />
            <livewire:timestamp :dateTime="$post->created_at" />
        </x-slot:title>

        {{--   BODY  --}}
        {!! nl2br(e($post->body)) !!}
    </x-card>

    {{--  ARCHIVED WARNING  --}}
    @if($post->archived_at)
        <x-alert title="This post was archived {{ $post->archived_at->diffForHumans() }}" icon="o-archive-box" class="alert-warning mb-10" />
    @endif

    {{--  COMMENTS --}}
    <livewire:comments.index :post="$post" lazy wire:key="comments-{{  $post->updated_at }}" />
</div>
