<div
    x-data="flashToast()"
    @toast.window="show($event.detail)"
    class="w-full sm:w-auto sm:max-w-96 fixed top-2 right-0 sm:right-2 z-[50000000] space-y-2"
>
    <template x-for="(toast, index) in toasts" :key="toast.id">
        <div 
            x-show="toast.show"
            :data-toast="toast.type"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4 scale-95"
            x-transition:enter-end="opacity-100 translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="flash-toast w-11/12 sm:w-full mx-auto p-2.5 rounded-lg flex gap-4 items-center relative"
        >
            <aside>
                <template x-if="toast.type === 'success'">
                    <flux:icon.check-circle variant="solid" class="size-10" />
                </template>
                <template x-if="toast.type === 'error'">
                    <flux:icon.x-circle variant="solid" class="size-10" />
                </template>
                <template x-if="toast.type === 'warning'">
                    <flux:icon.exclamation-triangle variant="solid" class="size-10" />
                </template>
                <template x-if="toast.type === 'info'">
                    <flux:icon.information-circle variant="solid" class="size-10" />
                </template>
            </aside>
            <main>
                <header class="flex gap-2">
                    <h2 class="font-semibold" x-text="toast.title"></h2>
                </header>
                <section>
                    <p x-text="toast.message"></p>
                </section>
            </main>    
            <aside>
                <flux:icon.x-mark @click="remove(toast.id)" variant="micro" class="absolute top-1 right-1 cursor-pointer" />
            </aside>
        </div>
    </template>
</div>

<script>
function flashToast() {
    return {
        toasts: [],
        show(toast) {
            const id = Date.now();
            const show = false;
            this.toasts.push({ id, show, ...toast });

            this.$nextTick(() => {
                const toastInArray = this.toasts.find(t => t.id === id);
                if (toastInArray) {
                    toastInArray.show = true;
                }
            });

            setTimeout(() => {
                this.remove(id);
            }, toast.duration);
        },

        remove(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) {
                toast.show = false;
                
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 200);
            }
        }
    }
}
</script>