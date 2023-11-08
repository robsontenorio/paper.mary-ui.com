<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
}; ?>

<div class="flex gap-2 items-center">
    {{-- AVATAR --}}
    <div>
        <div class="avatar">
            <div class="w-6 rounded-full">
                <img src="{{ $user->avatar }}" />
            </div>
        </div>
    </div>
    {{--  USERNAME  --}}
    <div class="text-sm">
        {{ $user->username }}
    </div>
</div>

