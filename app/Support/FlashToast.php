<?php

namespace App\Support;

use App\Enums\ToastType;
use Livewire\Component;

class FlashToast
{
    protected static ?Component $component = null;

    protected ToastType $type;

    protected string $message;

    protected ?string $title = null;

    protected ?int $duration = null;

    protected int $defaultDuration = 3000;

    /**
     * Set the Livewire component context
     */
    public static function setComponent(Component $component): void
    {
        static::$component = $component;
    }

    /**
     * Create a new toast instance
     */
    protected function __construct(ToastType $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Show a success toast
     */
    public static function success(string $message, ?string $title = null, ?int $duration = null): void
    {
        static::make(ToastType::SUCCESS, $message)
            ->title($title)
            ->duration($duration)
            ->dispatch();
    }

    /**
     * Show an error toast
     */
    public static function error(string $message, ?string $title = null, ?int $duration = null): void
    {
        static::make(ToastType::ERROR, $message)
            ->title($title)
            ->duration($duration)
            ->dispatch();
    }

    /**
     * Show a warning toast
     */
    public static function warning(string $message, ?string $title = null, ?int $duration = null): void
    {
        static::make(ToastType::WARNING, $message)
            ->title($title)
            ->duration($duration)
            ->dispatch();
    }

    /**
     * Show an info toast
     */
    public static function info(string $message, ?string $title = null, ?int $duration = null): void
    {
        static::make(ToastType::INFO, $message)
            ->title($title)
            ->duration($duration)
            ->dispatch();
    }

    /**
     * Create a new toast instance (for fluent API)
     */
    public static function make(ToastType $type, string $message): static
    {
        return new static($type, $message);
    }

    /**
     * Set the toast title
     */
    public function title(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the toast duration
     */
    public function duration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Dispatch the toast event
     */
    public function dispatch(): void
    {
        if (! static::$component) {
            throw new \RuntimeException('FlashToast component context not set. Use FlashToast::setComponent() first.');
        }

        static::$component->dispatch('toast',
            type: $this->type->value,
            message: $this->message,
            title: $this->title ?? $this->type->title(),
            duration: $this->duration ?? $this->defaultDuration,
        );
    }

    /**
     * Send the toast (alias for dispatch)
     */
    public function send(): void
    {
        $this->dispatch();
    }
}
