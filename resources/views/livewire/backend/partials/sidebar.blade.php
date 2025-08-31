<aside class="transition-all duration-300 ease-in-out z-50 max-h-screen py-2 pl-2"
    :class="{
        'w-72': desktop && sidebar_expanded,
        'w-20': desktop && !sidebar_expanded,
        'fixed top-0 left-0 h-full': !desktop,
        'w-72 translate-x-0': !desktop && mobile_menu_open,
        'w-72 -translate-x-full': !desktop && !mobile_menu_open,
    }">

    <div class="sidebar-glass-card h-full custom-scrollbar rounded-xl overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" wire:navigate class="p-4 inline-block">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 glass-card shadow inset-shadow-lg p-0 rounded-xl flex items-center justify-center">
                    <flux:icon name="bolt" class="w-5 h-5 text-zinc-500" />
                </div>
                <div x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)"
                    x-transition:enter="transition-all duration-300 delay-75"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition-all duration-200"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-4">
                    <h1 class="text-xl font-bold text-accent-content">{{ site_short_name ()}}</h1>
                    <p class="text-text-secondary text-sm">{{ site_tagline() }}</p>
                </div>
            </div>
        </a>

        <flux:separator class="bg-accent!" />

        <nav class="p-2 space-y-2">
            <x-backend.navlink type="single" icon="layout-dashboard" name="Dashboard" :route="route('admin.dashboard')"
                active="admin-dashboard" :page_slug="$active" />
            <x-backend.navlink type="single" icon="chart-pie" name="Analytics"  active="analytics"
                :page_slug="$active" />
            <x-backend.navlink type="single" icon="inbox" name="Inbox" active="inbox"
                :page_slug="$active" />

            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">Management</p>
                <p class="text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="desktop && !sidebar_expanded">...</p>
            </div>
            <x-backend.navlink type="dropdown" icon="users" name="Admin Management" :page_slug="$active" :items="[
                [
                    'name' => 'Admins',
                    'route' => '#',
                    'icon' => 'user-circle',
                    'active' => 'admin',
                ],
                [
                    'name' => 'Roles',
                    'route' => '#',
                    'icon' => 'shield-exclamation',
                    'active' => 'role',
                ],
                [
                    'name' => 'Permissions',
                    'route' => '#',
                    'icon' => 'shield-check',
                    'active' => 'permission',
                ],
            ]" />

            <x-backend.navlink type="dropdown" icon="user-group" name="User Management" :page_slug="$active" :items="[
                [
                    'name' => 'All Users',
                    'route' => route('admin.users'),
                    'icon' => 'user',
                    'active' => 'admin-users',
                ],
                [
                    'name' => 'Pending Users',
                    'route' => '#',
                    'icon' => 'user-plus',
                    'active' => 'admin-users-pending',
                ],
                [
                    'name' => 'Banned Users',
                    'route' => '#',
                    'icon' => 'user-round-x',
                    'active' => 'admin-users-banned',
                ],
            ]" />

            <div class="pt-4 pb-2">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="(desktop && sidebar_expanded) || (!desktop && mobile_menu_open)">Settings & Tools</p>
                <p class="text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase"
                    x-show="desktop && !sidebar_expanded">...</p>
            </div>
            <x-backend.navlink type="dropdown" icon="wrench-screwdriver" name="Application Settings" :page_slug="$active"
                :items="[
                    [
                        'name' => 'General Settings',
                        'route' => '#',
                        'icon' => 'cog-8-tooth',
                        'active' => 'settings-general',
                    ],
                    [
                        'name' => 'Appearance',
                        'route' => '#',
                        'icon' => 'palette',
                        'active' => 'settings-appearance',
                    ],
                    [
                        'name' => 'Security',
                        'route' => '#',
                        'icon' => 'shield',
                        'active' => 'settings-security',
                    ],
                    [
                        'name' => 'Email',
                        'route' => '#',
                        'icon' => 'envelope',
                        'active' => 'settings-email',
                    ],
                    [
                        'name' => 'Payment Gateways',
                        'route' => '#',
                        'icon' => 'credit-card',
                        'active' => 'settings-payments',
                    ],
                    [
                        'name' => 'Analytics',
                        'route' => '#',
                        'icon' => 'chart-bar',
                        'active' => 'settings-analytics',
                    ],
                    [
                        'name' => 'Support',
                        'route' => '#',
                        'icon' => 'headset',
                        'active' => 'settings-support',
                    ],
                    [
                        'name' => 'Notifications',
                        'route' => '#',
                        'icon' => 'bell',
                        'active' => 'settings-notifications',
                    ],
                    [
                        'name' => 'Database',
                        'route' => '#',
                        'icon' => 'database',
                        'active' => 'settings-database',
                    ],
                ]" />

            <div class="p-2 space-y-2">
                <flux:separator class="bg-accent!" />
                <x-backend.navlink type="single" icon="user" name="Profile" active="profile"
                    :page_slug="$active" />
                <button wire:click="logout" class="w-full text-left">
                    <x-backend.navlink type="single" icon="power" name="Logout" />
                </button>
            </div>
        </nav>
    </div>
</aside>
