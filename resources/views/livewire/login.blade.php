<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {
    #[Url]
    public string $redirect_url = '';

    public function login()
    {
        // Always a random user to make it fun.
        $user = User::inRandomOrder()->first();

        Auth::login($user);

        request()->session()->regenerate();

        return redirect()->intended($this->redirect_url);
    }
}; ?>

<div>
    <div class="max-w-sm lg:ml-40">
        <img src="/login.png" width="200" class="mx-auto" />

        <x-form wire:submit="login">
            <x-input label="E-mail" value="random@random.com" icon="o-envelope" />
            <x-input label="Password" value="random" type="password" icon="o-key" />

            <x-slot:actions>
                <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
