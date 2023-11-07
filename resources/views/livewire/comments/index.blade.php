<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public Post $post;

    public ?Comment $commentEdit;

    #[Rule('required|min:5')]
    public string $body = '';

    public function comments()
    {
        return Comment::query()
            ->with('post')
            ->whereBelongsTo($this->post)
            ->oldest()
            ->get();
    }

    public function edit(Comment $comment)
    {
        $this->commentEdit = $comment;
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
    }

    #[On('comment-done')]
    public function done()
    {
        $this->resetExcept('post');
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <div class="loading loading-spinner"></div>
        </div>
        HTML;
    }

    public function with(): array
    {
        return [
            'comments' => $this->comments()
        ];
    }
}; ?>

<div>
    {{-- COMMENT COUNT --}}
    <div class="font-bold">Comments ({{ $comments->count() }})</div>

    <hr class="mt-5" />

    {{-- COMMENT LIST --}}
    @foreach($comments as $comment)
        <x-card @class(["mt-5", "border border-primary/30" => $comment->author()->is(auth()->user())]) wire:key="comment-{{ $comment->id }}" shadow separator>

            {{-- COMMENT BODY --}}
            <div class="leading-7">
                @if($commentEdit?->is($comment))
                    <livewire:comments.edit :post="$comment->post" :comment="$comment" wire:key="comment-edit-{{ $comment->id }}" />
                @else
                    {!!  nl2br($comment->body) !!}
                @endif
            </div>

            {{--  TITLE --}}
            <x-slot:title>
                <div class="flex gap-2">
                    {{-- AVATAR --}}
                    <div>
                        <div class="avatar">
                            <div class="w-6 rounded-full">
                                <img src="{{ $comment->author->avatar }}" />
                            </div>
                        </div>
                    </div>
                    {{--  USERNAME  --}}
                    <div>
                        <div class="flex items-center gap-3">
                            <div class="text-sm">{{ $comment->author->username }}</div>
                            <div class="text-xs font-normal text-gray-500 tooltip" data-tip="{{ $comment->created_at }}">
                                {{ $comment->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot:title>

            {{-- MENU --}}
            <x-slot:menu>
                @if(! $post->archived_at && auth()->user()?->is($comment->author))
                    <x-dropdown right>
                        <x-slot:trigger>
                            <x-button icon="o-ellipsis-vertical" class="btn-sm btn-ghost btn-circle" />
                        </x-slot:trigger>
                        <x-menu-item title="Edit" icon="o-pencil" wire:click="edit('{{ $comment->id  }}')" />
                        <x-menu-item title="Remove" icon="o-trash" wire:click="delete('{{ $comment->id  }}')" class="text-error" />
                    </x-dropdown>
                @endif
            </x-slot:menu>
        </x-card>
    @endforeach

    {{-- REPLY --}}
    @if(! $post->archived_at && auth()->user())
        <livewire:comments.edit :post="$post" />
    @endif

    {{-- LOGIN--}}
    @if (! auth()->user())
        <x-button label="Log in to reply" link="/login?redirect_url=/posts/{{ $post->id }}" icon-right="o-arrow-right" class="btn-primary mt-10" />
    @endif

</div>
