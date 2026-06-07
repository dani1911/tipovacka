<?php

namespace App\Traits;

use App\Support\FlashToast;

trait WithToast
{
    /**
     * Boot the toast trait
     */
    public function bootWithToast(): void
    {
        FlashToast::setComponent($this);
    }
}
