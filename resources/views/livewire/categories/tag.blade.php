<?php

use App\Models\Category;
use Livewire\Volt\Component;

new class extends Component {
    public Category $category;
}; ?>

<span>
    <x-badge :value="$category->name" class="badge-outline {{ $category->color }}" />
</span>
