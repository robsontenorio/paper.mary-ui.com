<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/favicon.ico') }}">
    <link rel="mask-icon" href="{{ asset('/favicon.ico') }}" color="#ff2d20">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <livewire:paper-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <livewire:paper-brand class="pt-3 pb-1 ps-4" />

            {{-- MENU --}}
            <x-menu activate-by-route class="pt-0">

                {{-- User --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" sub-value="email" no-separator no-hover class="-mx-2 !-my-2">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-sm" tooltip-left="logoff" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>
                @endif

                <x-menu-separator />

                <x-button label="New discussion" link="/posts/create" icon="o-plus" class="btn-primary btn-block mt-5" />
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}

            <div class="flex mt-10">
                <x-button label="Source code" icon="o-code-bracket" link="https://github.com/robsontenorio/paper.mary-ui.com" class="btn-ghost" external />
                <x-button label="Built with maryUI" icon="o-heart" link="https://mary-ui.com" class="btn-ghost !text-pink-500" external />
            </div>
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
