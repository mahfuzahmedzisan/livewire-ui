<main>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="breadcrumb">Dashboard</x-slot>
    <x-slot name="page_slug">admin-dashboard</x-slot>

    <section>
        <div class="glass-card rounded-2xl p-6 mb-8">
            <div class="flex items-center justify-center">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white ">Admin Dashboard</h3>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 mb-8">
            <x-button icon="user"> ljsdlkfjlkdf</x-button>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6"
            x-transition:enter="transition-all duration-500" x-transition:enter-start="opacity-0 translate-y-8"
            x-transition:enter-end="opacity-100 translate-y-0">

            <div class="glass-card rounded-2xl p-6 card-hover float interactive-card" style="animation-delay: 0s;"
                @click="showDetails('users')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="users" class="w-6 h-6 text-blue-400" />
                    </div>
                    <div class="text-green-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-up" class="w-3 h-3" />
                        +12%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800  mb-1" x-text="stats.users.toLocaleString()">
                    12,384</h3>
                <p class="text-gray-800/60  text-sm">Total Users</p>
                <div class="mt-4 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-400 to-blue-600 rounded-full progress-bar"
                        style="width: 75%;"></div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6 card-hover float interactive-card" style="animation-delay: 0.2s;"
                @click="showDetails('revenue')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="banknotes" class="w-6 h-6 text-green-400" />
                    </div>
                    <div class="text-green-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-up" class="w-3 h-3" />
                        +23%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800  mb-1">$<span
                        x-text="stats.revenue.toLocaleString()">48,392</span></h3>
                <p class="text-gray-800/60  text-sm">Total Revenue</p>
                <div class="mt-4 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600 rounded-full progress-bar"
                        style="width: 60%;"></div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6 card-hover float interactive-card" style="animation-delay: 0.4s;"
                @click="showDetails('orders')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="shopping-bag" class="w-6 h-6 text-purple-400" />
                    </div>
                    <div class="text-red-400 text-sm font-medium flex items-center gap-1">
                        <flux:icon name="arrow-trending-down" class="w-3 h-3" />
                        -5%
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800  mb-1" x-text="stats.orders.toLocaleString()">
                    2,847</h3>
                <p class="text-gray-800/60  text-sm">Total Orders</p>
                <div class="mt-4 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-400 to-purple-600 rounded-full progress-bar"
                        style="width: 45%;"></div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-6 card-hover float interactive-card" style="animation-delay: 0.6s;"
                @click="showDetails('active')">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                        <flux:icon name="activity" class="w-6 h-6 text-yellow-400" />
                    </div>
                    <div class="text-yellow-400 text-sm font-medium flex items-center gap-1">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                        Live
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800  mb-1" x-text="stats.activeUsers.toLocaleString()">847</h3>
                <p class="text-gray-800/60  text-sm">Active Users</p>
                <div class="mt-4 h-1 bg-white/10 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full pulse-slow progress-bar"
                        style="width: 85%;"></div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-5"
            x-transition:enter="transition-all duration-500 delay-200"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">

            <!-- Main Chart -->
            <div class="lg:col-span-2 glass-card rounded-2xl p-6 card-hover">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-text-primary mb-1">Revenue Analytics</h3>
                        <p class="text-text-dark-primary text-sm">Monthly revenue breakdown</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <select
                            class="bg-white/10 text-text-primary text-sm px-3 py-2 rounded-lg border border-white/20 outline-none">
                            <option value="monthly">Monthly</option>
                            <option value="weekly">Weekly</option>
                            <option value="daily">Daily</option>
                        </select>
                        <button
                            class="btn-primary text-text-primary text-sm px-4 py-2 rounded-xl flex items-center gap-2">
                            <flux:icon name="arrow-down-tray" class="w-4 h-4" />
                            Export
                        </button>
                    </div>
                </div>
                <div class="h-64 relative">
                    <canvas id="revenueChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="space-y-6">
                <!-- Recent Activity -->
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-text-primary">Recent Activity</h3>
                        <button class="text-text-dark-primary hover:text-text-primary transition-colors">
                            <flux:icon name="move-horizontal" class="w-5 h-5" />
                        </button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="activity in recentActivity" :key="activity.id">
                            <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-colors">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    :class="activity.iconBg">
                                    <flux:icon name="activity" class="w-4 h-4" x-bind:class="activity.iconColor" />
                                </div>
                                <div class="flex-1">
                                    <p class="text-text-primary text-sm font-medium" x-text="activity.title"></p>
                                    <p class="text-text-dark-primary text-xs" x-text="activity.time"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-text-primary mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <button
                            class="btn-primary p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 hover:scale-105 transition-transform">
                            <flux:icon name="user-plus" class="w-4 h-4" />
                            Add User
                        </button>
                        <button
                            class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-white/20 hover:scale-105 transition-all">
                            <flux:icon name="envelope" class="w-4 h-4" />
                            Send Mail
                        </button>
                        <button
                            class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-white/20 hover:scale-105 transition-all">
                            <flux:icon name="file-text" class="w-4 h-4" />
                            Reports
                        </button>
                        <button
                            class="bg-white/10 hover:bg-white/20 p-3 rounded-xl text-text-primary text-sm font-medium flex items-center justify-center gap-2 border border-white/20 hover:scale-105 transition-all">
                            <flux:icon name="cog-8-tooth" class="w-4 h-4" />
                            Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
