<header class="sticky top-0 z-30 pt-2 px-2">
    <div class="glass-card rounded-xl">
        <div class="flex items-center justify-between p-4 lg:p-6">
            <div class="flex items-center gap-4">
                <!-- Menu Toggle Button -->
                <button @click="toggleSidebar()"
                    class="p-2 rounded-xl hover:bg-bg-black/10 dark:hover:bg-bg-white/10  text-text-primary transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-white/20 group"
                    :aria-label="desktop ? (sidebar_expanded ? 'Collapse sidebar' : 'Expand sidebar') : (mobile_menu_open ?
                        'Close menu' : 'Open menu')">
                    <flux:icon name="bars-4" x-show="!sidebar_expanded && !mobile_menu_open"
                        class="w-5 h-5 group-hover:scale-110 transition-transform" />
                    <flux:icon name="bars-3" x-show="sidebar_expanded && !mobile_menu_open"
                        class="w-5 h-5 group-hover:scale-110 transition-transform" />
                </button>

                <div class="hidden sm:block">
                    <h1 class="text-xl lg:text-2xl font-bold text-text-primary">Good morning,
                        Alex!</h1>
                    <p class="text-text-secondary text-text-secondary text-sm">Here's what's happening
                        today
                    </p>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-3">
                <!-- Search -->
                <x-admin.search-form placeholder="Search here..." />

                {{-- <!-- Theme Toggle --> --}}
                <flux:button x-data x-on:click="$flux.dark = !$flux.dark" variant="subtle"
                    aria-label="Toggle dark mode">
                    <flux:icon name="moon" class="w-5 h-5" x-show="$flux.dark" />
                    <flux:icon name="sun" class="w-5 h-5" x-show="!$flux.dark" />
                </flux:button>


                <!-- Notifications -->
                <button @click="toggleNotifications()"
                    class="relative p-2 rounded-xl hover:bg-bg-black/10 dark:hover:bg-bg-white/10 transition-colors">
                    <flux:icon name="bell" class="w-5 h-5 text-accent" />
                    <div x-show="notifications.length > 0"
                        class="absolute top-1 right-1 w-2 h-2 bg-red-400 rounded-full notification-badge">
                    </div>
                </button>

                <!-- Profile -->
                <div class="relative" x-data="{ open: false }">
                    {{-- <button @click="open = !open"
                     class=" flex items-center gap-2 p-1 rounded-xl hover:bg-bg-white/10 transition-colors">
                     <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face&auto=format"
                         alt="Profile" class="avatar rounded-lg object-cover">
                 </button> --}}

                    <button @click="open = !open" class="avatar">
                        <div class="w-8 rounded-xl">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face&auto=format"
                                alt="" class="object-cover w-full h-full">
                        </div>
                    </button>

                    <!-- Profile Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="hidden absolute right-0 mt-2 w-fit min-w-40 glass-card bg-bg-white dark:bg-bg-dark-tertiary rounded-xl shadow-lg py-2 z-50"
                        :class="open ? '!block' : '!hidden'">
                        <x-admin.profile-navlink route="#" name="{{ __('Profile') }}" />
                        <x-admin.profile-navlink route="#" name="{{ __('Settings') }}" />
                        <x-admin.profile-navlink route="{{ route('logout') }}" logout='true'
                            name="{{ __('Sign Out') }}" />
                        {{-- <a href="#"
                         class="block px-4 py-2 text-text-primary hover:bg-bg-white/10 transition-colors">Profile</a>
                     <a href="#"
                         class="block px-4 py-2 text-text-primary hover:bg-bg-white/10 transition-colors">Settings</a>
                     <div class="border-t border-white/10 my-2"></div>
                     <a href="#"
                         class="block px-4 py-2 text-text-primary hover:bg-bg-white/10 transition-colors">Sign
                         out</a> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Breadcrumb -->
        <div class="px-4 lg:px-6 pb-4">
            <nav class="flex items-center gap-2 text-sm text-text-secondary">
                <a href="{{ route('admin.dashboard') }}">{{ __('Admin Dashboard') }}</a>
                <flux:icon name="chevron-right" class="w-4 h-4" />
                <span class="text-text-muted capitalize"> {{ $breadcrumb }}</span>
            </nav>
        </div>
    </div>

</header>
