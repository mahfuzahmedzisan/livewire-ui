<aside class="transition-all duration-300 ease-in-out z-50 max-h-screen py-2 pl-2"
    :class="{
        // 'relative': desktop,
        'w-72': desktop && sidebar_expanded,
        'w-20': desktop && !sidebar_expanded,
        'fixed top-0 left-0 h-full': !desktop,
        'w-72 translate-x-0': !desktop && mobile_menu_open,
        'w-72 -translate-x-full': !desktop && !mobile_menu_open,
    }">

    <div class="sidebar-glass-card h-full custom-scrollbar rounded-xl overflow-y-auto">
        <!-- Sidebar Header -->
        <a href="{{ route('dashboard') }}" wire:navigate class="p-4 inline-block">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 glass-card shadow inset-shadow-lg p-0 rounded-xl flex items-center justify-center">
                    <flux:icon name="bolt" class="w-5 h-5 text-text-primary" />
                </div>
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    <h1 class="text-xl font-bold text-text-primary ">Dashboard</h1>
                    <p class="text-text-secondary  text-sm">Dashboard Pro</p>
                </div>
            </div>
        </a>

        <flux:separator class="bg-accent!" />

        <!-- Navigation Menu -->
        <nav class="p-2 space-y-2">
            <!-- Dashboard -->

            {{-- 1. SINGLE NAVLINK (replaces your original single-navlink) --}}
            <x-navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('dashboard')"
                active="admin-dashboard" :page_slug="$active" />

            <x-navlink type="single" icon="layout-dashboard" name="Button UI" active="button-ui"
                :page_slug="$active" />


            <x-navlink type="dropdown" icon="users" name="Admin Management" :page_slug="$active"
                :items="[
                    [
                        'name' => 'Admin',
                        'route' => '#',
                        'icon' => 'user-circle',
                        'active' => 'admin-dashboard',
                    ],
                    [
                        'name' => 'Role',
                        'route' => '#',
                        'icon' => 'shield-exclamation',
                        'active' => 'role',
                    ],
                    [
                        'name' => 'Permission',
                        'route' => '#',
                        'icon' => 'shield-check',
                        'active' => 'permission',
                    ],
                ]" />

            <x-navlink type="dropdown" icon="users" name="User Management" :page_slug="$active"
                :items="[
                    [
                        'name' => 'All Users',
                        'route' => '#',
                        'icon' => 'user',
                        'active' => 'admin-dashboard',
                    ],
                    [
                        'name' => 'Top Reposters',
                        'route' => '#',
                        'icon' => 'user',
                        'active' => 'admin-users',
                    ],
                    [
                        'name' => 'Banned Users',
                        'route' => '#',
                        'icon' => 'user',
                        'active' => 'admin-users',
                    ],
                    [
                        'name' => 'Multi Dropdown',
                        'icon' => 'user',
                        'subitems' => [
                            [
                                'name' => 'Subitem 1',
                                'route' => '#',
                                'icon' => 'user',
                                'active' => 'admin-users',
                            ],
                            [
                                'name' => 'Subitem 2',
                                'route' => '#',
                                'icon' => 'user',
                                'active' => 'admin-dashboard',
                            ],
                        ],
                    ],
                ]" />

            <x-navlink type="dropdown" icon="users" name="Package Management" :page_slug="$active"
                :items="[
                    [
                        'name' => 'Credit',
                        'route' => '#',
                        'icon' => 'user',
                        'active' => 'credit',
                    ],
                ]" />
        </nav>
    </div>
</aside>
