<?php

namespace App\ViewComposers;

use App\Models\Setting;
use Illuminate\View\View;
use App\Services\ItemService;
use Illuminate\Support\Facades\Cache;

class ContactsComposer
{
    const ONE_MINUTE = 60;

    protected $contacts;

    public function __construct()
    {
        Cache::forget('contacts');
        $this->contacts = Cache::flexible(
            key: 'contacts',
            ttl: [
                self::ONE_MINUTE,
                config('cache.stores.contacts'),
            ],
            callback: function () {
                return Setting::where('data_key', 'contacts')->first();
            });
    }
    public function compose(View $view): View
    {
        return $view->with('contacts', $this->getContacts());
    }

    private function getContacts(): object
    {
        return (object) $this->contacts->data_val;
    }
}
