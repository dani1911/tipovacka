<flux:modal name="info-modal" class="min-w-[22rem]">
    <div class="space-y-6">
        <flux:heading size="lg">
            {{ $modalTitle }}
        </flux:heading>

        <flux:text class="mt-2">
            {!! nl2br(e($modalMessage)) !!}
        </flux:text>

        <div class="flex gap-2 justify-end">
            <flux:spacer />

            <flux:modal.close>
                <flux:button variant="primary" class="cursor-pointer">{{ __('OK') }}</flux:button>
            </flux:modal.close>
        </div>
    </div>
</flux:modal>