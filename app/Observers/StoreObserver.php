<?php

namespace App\Observers;

use App\Models\Store;
use Illuminate\Support\Str;

class StoreObserver
{
    /**
     * Handle the Store "created" event.
     */
    public function creating(Store $store): void
    {
        $store['uuid'] = Str::uuid();
    }

    /**
     * Handle the Store "updated" event.
     */
    public function updated(Store $store): void
    {
        //
    }

    /**
     * Handle the Store "deleted" event.
     */
    public function deleted(Store $store): void
    {
        //
    }

    /**
     * Handle the Store "restored" event.
     */
    public function restored(Store $store): void
    {
        //
    }

    /**
     * Handle the Store "force deleted" event.
     */
    public function forceDeleted(Store $store): void
    {
        //
    }
}
