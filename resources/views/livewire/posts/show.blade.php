<?php

use App\Models\Post;
use Livewire\Attributes\Renderless;
use Livewire\Volt\Component;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;

    public Post $post;

    public function archive()
    {
        $this->post->update(['archived_at' => now()]);
        $this->warning('Post archived.');
    }

    public function unarchive()
    {
        $this->post->update(['archived_at' => null]);
        $this->success('Post unarchived.');
    }
}; ?>

<div>

    {{--  TITLE  --}}
    <div class="font-extrabold text-4xl"> {{ $post->title }} </div>

    {{--  OPTIONS  --}}
    <div class="mt-3 flex flex-wrap gap-3 lg:gap-8 items-center justify-between">

        <livewire:categories.tag :category="$post->category" />

        @if(auth()->user()?->is($post->author))
            <div>
                @if(! $post->archived_at)
                    <x-button label="Archive" wire:click="archive" icon="o-archive-box" class="text-error btn-sm btn-ghost" />
                    <x-button label="Edit" link="/posts/{{ $post->id }}/edit" icon="o-pencil" class="text-primary btn-sm btn-ghost" />
                @else
                    <x-button label="Unarchive" wire:click="unarchive" icon="o-archive-box" class="btn-sm btn-ghost" />
                @endif
            </div>
        @endif
    </div>

    <hr class="my-5" />

    {{--  POST BODY  --}}
    <x-card class="leading-7 mb-10 border" separator shadow>
        {!! nl2br($post->body) !!}

        {{--  TITLE --}}
        <x-slot:title>
            <div class="flex gap-2">
                {{-- AVATAR --}}
                <div>
                    <div class="avatar">
                        <div class="w-6 rounded-full">
                            <img src="{{ $post->author->avatar }}" />
                        </div>
                    </div>
                </div>
                {{--  USERNAME  --}}
                <div>
                    <div class="flex items-center gap-3">
                        <div class="text-sm">{{ $post->author->username }}</div>
                        <div class="text-xs font-normal text-gray-500 tooltip" data-tip="{{ $post->created_at }}">
                            {{ $post->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </x-slot:title>
    </x-card>

    {{--  ARCHIVE WARNING  --}}
    @if($post->archived_at)
        <x-alert title="This post was archived {{ $post->archived_at->diffForHumans() }}" icon="o-archive-box" class="alert-warning mb-10" />
    @endif

    {{--  COMMENTS --}}
    <livewire:comments.index :post="$post" lazy wire:key="comments-{{ rand() }}" />
</div>
