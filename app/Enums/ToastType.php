<?php

namespace App\Enums;

enum ToastType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case WARNING = 'warning';
    case INFO = 'info';

    public function title(): string
    {
        return match ($this) {
            ToastType::SUCCESS => __('Success'),
            ToastType::ERROR => __('Error'),
            ToastType::WARNING => __('Warning'),
            ToastType::INFO => __('Info'),
        };
    }
}
