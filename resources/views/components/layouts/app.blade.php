<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200/50">

<x-nav sticky class="lg:hidden">
    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer" />
        </label>

        <livewire:paper-brand />
    </x-slot:brand>
</x-nav>

<x-main>
    <x-slot:sidebar drawer="main-drawer">
        <div class="ml-5 my-8">
            <span class="font-extrabold text-4xl text-primary">
                <a href="/" wire:navigate>
                    <x-icon name="o-paper-airplane" class="w-8 h-8" />
                    paper
                </a>
            </span>
        </div>

        <div class="mx-3">
            {{-- User --}}
            @if($user = auth()->user())
                <x-list-item :item="$user" value="username" link="/users/{{ $user->username }}" no-separator>
                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" link="/logout" tooltip-left="logoff" />
                    </x-slot:actions>
                </x-list-item>
            @endif

            <hr class="mb-5" />

            <x-button label="New discussion" link="/posts/create" icon="o-plus" class="btn-primary btn-block" />
        </div>

    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content class="mb-20 lg:max-w-5xl">
        {{ $slot }}
    </x-slot:content>
</x-main>

{{-- TOAST --}}

<x-toast />
</body>
</html>
