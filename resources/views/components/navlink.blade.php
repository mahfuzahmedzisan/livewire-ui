@props([
    'icon' => 'folder', // Default parent icon
    'name' => 'Multi Navlink',
    'boxicon' => false,
    'active' => '',
    'page_slug' => '',
    'items' => [], // Array of nav items (single, dropdown, or multi-dropdown)
    'type' => 'dropdown', // 'dropdown' or 'single' - determines if main item is clickable
    'route' => '', // Route for main item when type is 'single'
    'permission' => '',
])

@php
    // Default icons for different levels
    $defaultParentIcon = $icon ?: 'folder';
    $defaultSubitemIcon = 'tags';
    $defaultMultiSubitemIcon = 'circle';

    // Filter items based on permissions
    $filteredItems = [];
    $mainPermissions = [];

    foreach ($items as $item) {
        $hasPermission = true;

        // Check permission for the item itself
        if (isset($item['permission']) && !empty($item['permission'])) {
            $hasPermission = auth()->user()->can($item['permission']);
            $mainPermissions[] = $item['permission'];
        }

        // If this is a multi-dropdown item with subitems, filter subitems
        if (isset($item['subitems']) && count($item['subitems']) > 0) {
            $filteredSubitems = [];

            foreach ($item['subitems'] as $subitem) {
                $hasSubPermission = true;

                if (isset($subitem['permission']) && !empty($subitem['permission'])) {
                    $hasSubPermission = auth()->user()->can($subitem['permission']);
                }

                if ($hasSubPermission) {
                    $filteredSubitems[] = $subitem;
                }
            }

            // Only include parent if it has accessible subitems
            if (count($filteredSubitems) > 0) {
                // Changed this condition
                $item['subitems'] = $filteredSubitems;
                $filteredItems[] = $item;
            }
        } else {
            // For single items, only include if user has permission
            if ($hasPermission) {
                $filteredItems[] = $item;
            }
        }
    }

    // Use filtered items
    $items = $filteredItems;

    // Check if main item or any sub-item is active
    $isMainActive = $type === 'single' && $page_slug == $active;
    $isDropdownActive = false;

    foreach ($items as $item) {
        if (isset($item['active']) && $page_slug == $item['active']) {
            $isDropdownActive = true;
            break;
        }
        // Check nested items for multi-dropdown
        if (isset($item['subitems'])) {
            foreach ($item['subitems'] as $subitem) {
                if (isset($subitem['active']) && $page_slug == $subitem['active']) {
                    $isDropdownActive = true;
                    break 2;
                }
            }
        }
    }

    $isAnyActive = $isMainActive || $isDropdownActive;
    $shouldShowComponent =
        $type === 'single' ? empty($permission) || auth()->user()->can($permission) : count($items) > 0;

@endphp

@if ($shouldShowComponent)
    <div x-data="{
        open: {{ $isDropdownActive ? 'true' : 'false' }},
        collapsedDropdown: false,
        init() {
            // Auto expand if any dropdown item is active
            if ({{ $isDropdownActive ? 'true' : 'false' }}) {
                this.open = true;
            }
        },
        toggleCollapsedDropdown() {
            if (!desktop || !sidebar_expanded) {
                this.collapsedDropdown = !this.collapsedDropdown;
                // Close other collapsed dropdowns by dispatching event
                $dispatch('close-collapsed-dropdowns', { except: $el });
            }
        },
        closeCollapsedDropdown() {
            this.collapsedDropdown = false;
        }
    }"
        @close-collapsed-dropdowns.window="if ($event.detail.except !== $el) { closeCollapsedDropdown() }"
        @click.away="closeCollapsedDropdown()"> {{-- relative --}}

        @if ($type === 'single')
            <!-- Single Navlink (like original single-navlink) -->
            @if (empty($permission) || auth()->user()->can($permission))
                <a href="{{ $route }}" wire:navigate
                    class="sidebar-item flex items-center gap-4 p-3 rounded-xl hover:bg-bg-primary text-text-primary transition-all duration-200 group {{ $isMainActive ? 'bg-bg-primary/80' : '' }}">
                    <div
                        class="w-8 h-8 glass-card rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform relative">
                        @if ($boxicon)
                            <i class="{{ $defaultParentIcon }} {{$isMainActive ? 'text-accent' : ' text-text-primary'}}"></i>
                        @else
                            <flux:icon name="{{ $defaultParentIcon }}" class="w-5 h-5 flex-shrink-0 {{$isMainActive ? 'text-accent' : 'text-text-primary'}}" />
                        @endif
                        <!-- Active indicator for collapsed state -->
                        <div x-show="!((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) && {{ $isAnyActive ? 'true' : 'false' }}"
                            class="absolute -top-1 -right-1 w-3 h-3 bg-accent rounded-full animate-pulse invisible"
                            :class="{
                                'visible': !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) &&
                                    {{ $isAnyActive ? 'true' : 'false' }}
                            }">
                        </div>
                    </div>
                    <span x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                        x-transition:enter="transition-all duration-300 delay-75"
                        x-transition:enter-start="opacity-0 translate-x-4"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition-all duration-200"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-4"
                        class="font-medium {{ $isMainActive ? 'text-accent-content ' : 'text-text-primary ' }}">{{ __($name) }}</span>
                    <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                        class="ml-auto {{ $isMainActive ? 'block' : 'hidden' }}">
                        <div class="w-2 h-2 bg-accent rounded-full animate-pulse"></div>
                    </div>
                </a>
            @endif
        @else
            <!-- Dropdown Button -->
            <button
                @click="((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? (open = !open) : toggleCollapsedDropdown()"
                class="sidebar-item flex items-center gap-4 p-3 rounded-xl hover:bg-bg-primary text-text-primary transition-all duration-200 group w-full {{ $isAnyActive ? 'bg-bg-primary/80' : '' }}">
                {{-- relative --}}
                <div
                    class="w-8 h-8 glass-card rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform relative">
                    @if ($boxicon)
                        <i class="{{ $defaultParentIcon }} {{ $isAnyActive ? 'text-accent' : 'text-text-primary'}}"></i>
                    @else
                        <flux:icon name="{{ $defaultParentIcon }}" class="w-5 h-5 flex-shrink-0 {{ $isAnyActive ? 'text-accent' : 'text-text-primary'}}" />
                    @endif

                    <!-- Active indicator for collapsed state -->
                    <div x-show="!((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) && {{ $isAnyActive ? 'true' : 'false' }}"
                        class="absolute -top-1 -right-1 w-3 h-3 bg-accent rounded-full animate-pulse invisible"
                        :class="{
                            'visible': !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) &&
                                {{ $isAnyActive ? 'true' : 'false' }}
                        }">
                    </div>
                </div>

                <span x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4"
                    class="font-medium text-left {{ $isAnyActive ? 'text-text-primary ' : 'text-text-secondary ' }}">{{ __($name) }}</span>

                <!-- Dropdown Arrow for expanded state -->
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    class="ml-auto transition-transform duration-200" :class="open ? 'rotate-180' : ''">
                    <flux:icon name="chevron-down" class="w-5 h-5 text-text-primary flex-shrink-0" />
                </div>
            </button>
        @endif

        <!-- Collapsed State Dropdown (Floating) - FIXED VERSION -->
        @if ($type === 'dropdown' && count($items) > 0)
            <!-- Portal container for dropdown - positioned fixed to escape sidebar constraints -->
            <div x-show="collapsedDropdown && !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open))"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 translate-x-2 scale-95"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 translate-x-2 scale-95"
                class="hidden absolute z-[9999] min-w-64 max-w-80 bg-bg-primary rounded-xl shadow-2xl border border-zinc-800 dark:border-zinc-700 py-3 right-full ml-2 top-0"
                :class="(collapsedDropdown && !((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? '!block' :
                    '!hidden')"
                style="backdrop-filter: blur(12px);" x-init="// Calculate position relative  to the trigger button
                $nextTick(() => {
                    if (collapsedDropdown) {
                        const triggerRect = $el.previousElementSibling.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const dropdownHeight = 400; // approximate max height
                
                        // Position to the right of the trigger
                        $el.style.left = (triggerRect.right + 8) + 'px';
                
                        // Position vertically - center with trigger, but ensure it stays in viewport
                        let topPosition = triggerRect.top + (triggerRect.height / 2) - (dropdownHeight / 2);
                
                        // Adjust if dropdown would go off screen
                        if (topPosition < 20) {
                            topPosition = 20;
                        } else if (topPosition + dropdownHeight > viewportHeight - 20) {
                            topPosition = viewportHeight - dropdownHeight - 20;
                        }
                
                        $el.style.top = topPosition + 'px';
                    }
                })"
                x-effect="
                if (collapsedDropdown) {
                    $nextTick(() => {
                        const triggerRect = $el.previousElementSibling.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;
                        const dropdownHeight = 400;
                        
                        $el.style.left = (triggerRect.right + 8) + 'px';
                        
                        let topPosition = triggerRect.top + (triggerRect.height / 2) - (dropdownHeight / 2);
                        
                        if (topPosition < 20) {
                            topPosition = 20;
                        } else if (topPosition + dropdownHeight > viewportHeight - 20) {
                            topPosition = viewportHeight - dropdownHeight - 20;
                        }
                        
                        $el.style.top = topPosition + 'px';
                    });
                }">

                <!-- Header -->
                <div class="px-4 pb-3 border-b border-zinc-100 dark:border-zinc-800">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 glass-card rounded-lg flex items-center justify-center">
                            @if ($boxicon)
                                <i class="{{ $defaultParentIcon }} text-text-primary"></i>
                            @else
                                <flux:icon name="{{ $defaultParentIcon }}"
                                    class="w-5 h-5 text-text-primary flex-shrink-0" />
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-text-primary text-sm">{{ __($name) }}</h3>
                            <p class="text-xs text-text-secondary">{{ count($items) }} {{ __('items') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="px-2 py-2 max-h-96 overflow-y-auto custom-scrollbar">
                    @foreach ($items as $key => $item)
                        @php
                            $subitemIcon = $item['icon'] ?? $defaultSubitemIcon;
                            $subitemBoxicon = $item['boxicon'] ?? false;
                        @endphp

                        @if (isset($item['type']) && $item['type'] === 'single')
                            <!-- Single Navigation Item -->
                            <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}"
                                wire:navigate
                                class="flex items-center gap-3 p-3 mx-2 rounded-lg hover:bg-bg-teritary/50 transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-zinc-50 dark:bg-zinc-900/20 border border-zinc-200 dark:border-zinc-800' : '' }}">
                                <div
                                    class="w-8 h-8 glass-card rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                                    @if ($subitemBoxicon)
                                        <i
                                            class="{{ $subitemIcon }} text-sm {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-accent' : 'text-text-secondary' }}"></i>
                                    @else
                                        <flux:icon name="{{ $subitemIcon }}"
                                            class="w-5 h-5 text-black dark:text-white flex-shrink-0"
                                            class="w-4 h-4 {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-accent dark:stroke-accent' : 'stroke-zinc-500 dark:stroke-zinc-400' }}" />
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <span
                                        class="font-medium text-sm {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-accent' : 'text-text-teritary' }}">{{ __($item['name']) }}</span>
                                </div>
                                @if (isset($item['active']) && $page_slug == $item['active'])
                                    <div class="w-2 h-2 bg-accent rounded-full animate-pulse">
                                    </div>
                                @endif
                            </a>
                        @elseif (isset($item['subitems']) && count($item['subitems']) > 0)
                            <!-- Multi-dropdown item -->
                            <div x-data="{ subOpen: {{ (function () use ($item, $page_slug) {
                                foreach ($item['subitems'] as $subitem) {
                                    if (isset($subitem['active']) && $page_slug == $subitem['active']) {
                                        return 'true';
                                    }
                                }
                                return 'false';
                            })() }} }" class="mx-2">

                                <button @click="subOpen = !subOpen"
                                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200 w-full group">
                                    <div
                                        class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                                        @if ($subitemBoxicon)
                                            <i
                                                class="{{ $subitemIcon }} text-sm text-gray-600 dark:text-gray-400"></i>
                                        @else
                                            <flux:icon name="{{ $subitemIcon }}"
                                                class="w-4 h-4 text-black dark:text-white flex-shrink-0" />
                                        @endif
                                    </div>
                                    <span
                                        class="font-medium text-sm text-gray-700 dark:text-gray-300 flex-1 text-left">{{ __($item['name']) }}</span>
                                    <div class="transition-transform duration-200" :class="subOpen ? 'rotate-180' : ''">
                                        <flux:icon name="chevron-down"
                                            class="w-4 h-4 stroke-gray-500 dark:stroke-gray-400" />
                                    </div>
                                    @if (
                                        (function () use ($item, $page_slug) {
                                            foreach ($item['subitems'] as $subitem) {
                                                if (isset($subitem['active']) && $page_slug == $subitem['active']) {
                                                    return true;
                                                }
                                            }
                                            return false;
                                        })())
                                        <div
                                            class="w-2 h-2 bg-violet-400 dark:bg-violet-300 rounded-full animate-pulse ml-2">
                                        </div>
                                    @endif
                                </button>

                                <!-- Sub-dropdown items -->
                                <div x-show="subOpen" x-transition:enter="transition-all duration-200 ease-out"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition-all duration-150 ease-in"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="ml-4 mt-1 space-y-1 border-l-2 border-gray-200 dark:border-gray-600 pl-4">

                                    @foreach ($item['subitems'] as $subitem)
                                        @php
                                            $multiSubitemIcon = $subitem['icon'] ?? $defaultMultiSubitemIcon;
                                            $multiSubitemBoxicon = $subitem['boxicon'] ?? false;
                                        @endphp
                                        <a href="{{ $subitem['route'] }}" wire:navigate
                                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200 group {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'bg-violet-50 dark:bg-violet-900/20 border border-violet-200 dark:border-violet-800' : '' }}">
                                            <div
                                                class="w-6 h-6 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center group-hover:scale-105 transition-transform">
                                                @if ($multiSubitemBoxicon)
                                                    <i
                                                        class="{{ $multiSubitemIcon }} text-xs {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'text-violet-600 dark:text-violet-400' : 'text-gray-500 dark:text-gray-500' }}"></i>
                                                @else
                                                    <flux:icon name="{{ $multiSubitemIcon }}"
                                                        class="w-3 h-3 {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'stroke-violet-600 dark:stroke-violet-400' : 'stroke-gray-500 dark:stroke-gray-500' }}" />
                                                @endif
                                            </div>
                                            <span
                                                class="font-medium text-xs {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'text-violet-700 dark:text-violet-300' : 'text-gray-600 dark:text-gray-400' }} flex-1">{{ __($subitem['name']) }}</span>
                                            @if (isset($subitem['active']) && $page_slug == $subitem['active'])
                                                <div
                                                    class="w-1.5 h-1.5 bg-violet-400 dark:bg-violet-300 rounded-full animate-pulse">
                                                </div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Regular dropdown item -->

                            <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}"
                                wire:navigate
                                class="flex items-center gap-3 p-3 mx-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-violet-50 dark:bg-violet-900/20 border border-violet-200 dark:border-violet-800' : '' }}">
                                <div
                                    class="w-8 h-8 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                                    @if ($subitemBoxicon)
                                        <i
                                            class="{{ $subitemIcon }} text-sm {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-violet-600 dark:text-violet-400' : 'text-gray-600 dark:text-gray-400' }}"></i>
                                    @else
                                        <flux:icon name="{{ $subitemIcon }}"
                                            class="w-4 h-4 {{ isset($item['active']) && $page_slug == $item['active'] ? 'stroke-violet-600 dark:stroke-violet-400' : 'stroke-gray-600 dark:stroke-gray-400' }}" />
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <span
                                        class="font-medium text-sm {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-violet-700 dark:text-violet-300' : 'text-gray-700 dark:text-gray-300' }}">{{ __($item['name']) }}</span>
                                </div>
                                @if (isset($item['active']) && $page_slug == $item['active'])
                                    <div class="w-2 h-2 bg-violet-400 dark:bg-violet-300 rounded-full animate-pulse">
                                    </div>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Original Expanded State Dropdown -->
        @if ($type === 'dropdown' && count($items) > 0)
            <div x-show="open && ((desktop && sidebar_expanded) || (!desktop && mobile_menu_open))"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                class="ml-4 mt-2 space-y-1 border-l-2 border-bg-black/10 dark:border-bg-white/10 pl-4 hidden"
                :class="(open && ((desktop && sidebar_expanded) || (!desktop && mobile_menu_open)) ? '!block' : '!hidden')">

                @foreach ($items as $item)
                    @php
                        $subitemIcon = $item['icon'] ?? $defaultSubitemIcon;
                        $subitemBoxicon = $item['boxicon'] ?? false;
                    @endphp

                    @if (isset($item['type']) && $item['type'] === 'single')
                        <!-- Single Navigation Item -->
                        <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}" wire:navigate
                            class="sidebar-item flex items-center gap-4 p-2 rounded-lg hover:bg-bg-black/5 dark:hover:bg-bg-white/5 text-text-primary transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-violet-50 dark:bg-violet-900/20' : '' }}">
                            <div
                                class="w-6 h-6 bg-bg-black/5 dark:bg-bg-white/5 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                @if ($subitemBoxicon)
                                    <i class="{{ $subitemIcon }} text-xs"></i>
                                @else
                                    <flux:icon name="{{ $subitemIcon }}" class="w-3 h-3 stroke-current" />
                                @endif
                            </div>
                            <span
                                class="font-medium text-sm  text-left {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-violet-600 dark:text-violet-400' : 'text-text-secondary ' }}">{{ __($item['name']) }}</span>
                        </a>
                    @elseif (isset($item['subitems']) && count($item['subitems']) > 0)
                        <!-- Multi-dropdown item -->
                        <div x-data="{
                            subOpen: {{ (function () use ($item, $page_slug) {
                                foreach ($item['subitems'] as $subitem) {
                                    if (isset($subitem['active']) && $page_slug == $subitem['active']) {
                                        return 'true';
                                    }
                                }
                                return 'false';
                            })() }}
                        }">
                            <button @click="subOpen = !subOpen"
                                class="flex items-center gap-3 p-2 rounded-lg hover:bg-bg-black/5 dark:hover:bg-bg-white/5 text-text-secondary  transition-all duration-200 w-full group">
                                <div
                                    class="w-6 h-6 bg-bg-black/5 dark:bg-bg-white/5 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                    @if ($subitemBoxicon)
                                        <i class="{{ $subitemIcon }} text-xs"></i>
                                    @else
                                        <flux:icon name="{{ $subitemIcon }}" class="w-3 h-3 stroke-current" />
                                    @endif
                                </div>
                                <span class="font-medium text-sm flex-1 text-left">{{ __($item['name']) }}</span>
                                <div class="transition-transform duration-200" :class="subOpen ? 'rotate-180' : ''">
                                    <flux:icon name="chevron-down" class="w-3 h-3 stroke-current" />
                                </div>
                            </button>

                            <!-- Sub-dropdown items -->
                            <div x-show="subOpen" x-transition:enter="transition-all duration-200 ease-out"
                                x-transition:enter-start="opacity-0 -translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition-all duration-150 ease-in"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 -translate-y-1"
                                class="ml-6 mt-1 space-y-1 border-l border-bg-black/5 dark:border-bg-white/5 pl-3">

                                @foreach ($item['subitems'] as $subitem)
                                    @php
                                        $multiSubitemIcon = $subitem['icon'] ?? $defaultMultiSubitemIcon;
                                        $multiSubitemBoxicon = $subitem['boxicon'] ?? false;
                                    @endphp
                                    <a href="{{ $subitem['route'] }}" wire:navigate
                                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-bg-black/5 dark:hover:bg-bg-white/5 transition-all duration-200 group {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'bg-violet-50 dark:bg-violet-900/20' : '' }}">
                                        <div
                                            class="w-5 h-5 bg-bg-black/5 dark:bg-bg-white/5 rounded flex items-center justify-center group-hover:scale-110 transition-transform">
                                            @if ($multiSubitemBoxicon)
                                                <i class="{{ $multiSubitemIcon }} text-xs"></i>
                                            @else
                                                <flux:icon name="{{ $multiSubitemIcon }}"
                                                    class="w-2.5 h-2.5 stroke-current" />
                                            @endif
                                        </div>
                                        <span
                                            class="font-medium text-xs {{ isset($subitem['active']) && $page_slug == $subitem['active'] ? 'text-violet-600 dark:text-violet-400' : 'text-text-secondary ' }}">{{ __($subitem['name']) }}</span>
                                        @if (isset($subitem['active']) && $page_slug == $subitem['active'])
                                            <div class="ml-auto">
                                                <div
                                                    class="w-1.5 h-1.5 bg-violet-400 dark:bg-violet-300 rounded-full animate-pulse">
                                                </div>
                                            </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Regular dropdown item -->
                        <a href="{{ empty($item['route']) ? 'javascript:void(0);' : $item['route'] }}" wire:navigate
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-bg-black/5 dark:hover:bg-bg-white/5 transition-all duration-200 group {{ isset($item['active']) && $page_slug == $item['active'] ? 'bg-violet-50 dark:bg-violet-900/20' : '' }}">
                            <div
                                class="w-6 h-6 bg-bg-black/5 dark:bg-bg-white/5 rounded-md flex items-center justify-center group-hover:scale-110 transition-transform">
                                @if ($subitemBoxicon)
                                    <i class="{{ $subitemIcon }} text-xs"></i>
                                @else
                                    <flux:icon name="{{ $subitemIcon }}" class="w-3 h-3 stroke-current" />
                                @endif
                            </div>
                            <span
                                class="font-medium text-sm {{ isset($item['active']) && $page_slug == $item['active'] ? 'text-violet-600 dark:text-violet-400' : 'text-text-secondary ' }}">{{ __($item['name']) }}</span>
                            @if (isset($item['active']) && $page_slug == $item['active'])
                                <div class="ml-auto">
                                    <div
                                        class="w-1.5 h-1.5 bg-violet-400 dark:bg-violet-300 rounded-full animate-pulse">
                                    </div>
                                </div>
                            @endif
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@endif
