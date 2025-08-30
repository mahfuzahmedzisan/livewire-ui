<div class="flex items-center justify-center min-h-screen p-4 sm:p-0">
    <div class="bg-white dark:bg-zinc-800 shadow-xl rounded-xl p-6 sm:p-8 w-full max-w-sm">
        <div class="flex flex-col gap-6">
            <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

            <x-auth-session-status class="text-center" :status="session('status')" />

            <form method="POST" wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
                <flux:input
                    wire:model="email"
                    :label="__('Email Address')"
                    type="email"
                    required
                    autofocus
                    placeholder="email@example.com"
                />

                <flux:button variant="primary" type="submit" class="w-full">{{ __('Email password reset link') }}</flux:button>
            </form>

            <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
                <span>{{ __('Or, return to') }}</span>
                <flux:link :href="route('login')" wire:navigate>{{ __('log in') }}</flux:link>
            </div>
        </div>
    </div>
</div>
