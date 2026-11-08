@props([
    'src' => null,
    'alt' => '',
    'category' => '',
])

@php
    $category = \Illuminate\Support\Str::lower($category);
    $placeholder = match (true) {
        str_contains($category, 'laptop'), str_contains($category, 'celular'), str_contains($category, 'tablet'), str_contains($category, 'consol'), str_contains($category, 'audio'), str_contains($category, 'smartwatch'), str_contains($category, 'phone'), str_contains($category, 'electronic'), str_contains($category, 'tecnolog') => 'electronics',
        str_contains($category, 'pantalon'), str_contains($category, 'pant'), str_contains($category, 'trouser') => 'pants',
        str_contains($category, 'accesor'), str_contains($category, 'accessor') => 'accessories',
        str_contains($category, 'buso'), str_contains($category, 'hoodie'), str_contains($category, 'sudadera') => 'hoodie',
        default => 'shirt',
    };
    $fallbackUrl = asset("images/products/{$placeholder}.svg");
@endphp

<img
    src="{{ $src ?: $fallbackUrl }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'product-image']) }}
    @if($src)
        onerror="this.onerror=null;this.src='{{ $fallbackUrl }}';"
    @endif
>
