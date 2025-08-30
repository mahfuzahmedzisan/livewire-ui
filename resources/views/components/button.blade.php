@props([
    'icon' => null,
    'iconPosition' => 'left',
    'type' => 'button',
    'href' => 'javascript:void(0);',
    'route' => false,
    'target' => '_self',
    'disabled' => false,
    'title' => '',
    'outline' => false,
    'dashed' => false,
    'linkText' => false,
    'variant' => 'primary',
])

@php
    $classes = Flux::classes('flex items-center justify-center gap-2');

    if ($outline) {
        $classes .= ' border border-accent';
    }

    if ($dashed) {
        $classes .= ' border-dashed';
    }

    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed pointer-events-none';
    }
    if ($linkText) {
        $classes .= ' !bg-transparent !p-0 !h-auto !shadow-none !ring-0 hover:!bg-transparent focus:!ring-0';
    }
    if ($variant === 'secondary') {
        $classes .= ' bg-accent text-accent-foreground';
    } elseif ($variant === 'tertiary') {
        $classes .= ' bg-accent-foreground text-accent';
    } else {
        $classes .= ' bg-accent text-accent-foreground';
    }
    if ($icon) {
        if ($iconPosition === 'left') {
            $classes .= ' pl-3 pr-4';
        } else {
            $classes .= ' pl-4 pr-3';
        }
    }
    if (!$icon) {
        $classes .= ' px-4';
    }
    $classes .=
        ' py-2 rounded-xl text-sm font-medium shadow hover:shadow-md focus:shadow-md focus:outline-none focus:ring-2 focus:ring-accent-foreground/30 transition-all duration-200';
    return $classes;
@endphp
@if ($route)
    <a href="{{ $route }}" target="{{ $target }}" title="{{ $title }}"
        class="{{ $classes }} {{ $attributes->get('class') }}"
        {{ $disabled ? 'aria-disabled=true tabindex=-1' : '' }} {{ $attributes->except('class') }}>
        @if ($icon && $iconPosition === 'left')
            <flux:icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'right')
            <flux:icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
    </a>
@else
    <button type="{{ $type }}" title="{{ $title }}"
        class="{{ $classes }} {{ $attributes->get('class') }}"
        {{ $disabled ? 'disabled aria-disabled=true tabindex=-1' : '' }} {{ $attributes->except('class') }}>
        @if ($icon && $iconPosition === 'left')
            <flux:icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon && $iconPosition === 'right')
            <flux:icon name="{{ $icon }}" class="w-5 h-5" />
        @endif
    </button>
@endif
