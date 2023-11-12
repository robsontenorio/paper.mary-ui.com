<?php

use App\Models\Category;
use App\Traits\HasCssClassAttribute;
use Livewire\Volt\Component;

new class extends Component {
    use HasCssClassAttribute;

    public Category $category;
}; ?>

<span>
    <x-badge :value="$category->name" class="badge-outline {{ $class }} {{ $category->color }}" />
</span>
