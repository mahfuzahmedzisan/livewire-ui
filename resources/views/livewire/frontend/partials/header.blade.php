<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-4" inset="left" />
    <flux:brand href="{{ route('home') }}" wire:navigate logo="https://fluxui.dev/img/demo/logo.png" name="Acme Inc."
        class="max-lg:hidden dark:hidden" />
    <flux:brand href="{{ route('home') }}" wire:navigate logo="https://fluxui.dev/img/demo/dark-mode-logo.png"
        name="Acme Inc." class="max-lg:hidden! hidden dark:flex" />
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="home" href="{{ route('home') }}" wire:navigate :current="request()->routeIs('home')">
            Home
        </flux:navbar.item>
    </flux:navbar>
    <flux:spacer />

    @auth
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
            <flux:menu>
                <flux:menu.item icon="user-circle">Profile</flux:menu.item>
                <flux:menu.item icon="envelope">Messages</flux:menu.item>
                <flux:menu.item icon="wrench-screwdriver">Settings</flux:menu.item>
                <flux:menu.item icon="credit-card">Billing</flux:menu.item>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @else
        <flux:navbar class="me-4">
            <flux:navbar.item icon="log-in" href="{{ route('login') }}" wire:navigate>Login</flux:navbar.item>
            <flux:separator vertical variant="subtle" class="my-2" />
            <flux:navbar.item icon="user-plus" href="{{ route('register') }}" wire:navigate>Register</flux:navbar.item>
        </flux:navbar>
    @endauth

</flux:header>
