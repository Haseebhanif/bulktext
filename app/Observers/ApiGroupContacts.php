<?php

namespace App\Observers;

use App\Models\ContactGroup;
use Carbon\Carbon;

class ApiGroupContacts
{
    /**
     * Handle the ContactGroup "created" event.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return ContactGroup
     */
    public function created(ContactGroup $contactGroup)
    {
        $contactGroup->created_at = Carbon::now();
        $contactGroup->updated_at = Carbon::now();
        $contactGroup->save();
    }

    /**
     * Handle the ContactGroup "updated" event.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return void
     */
    public function updated(ContactGroup $contactGroup)
    {
        $contactGroup->updated_at = Carbon::now();
        $contactGroup->save();
    }

    /**
     * Handle the ContactGroup "deleted" event.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return void
     */
    public function deleted(ContactGroup $contactGroup)
    {
        //
    }

    /**
     * Handle the ContactGroup "restored" event.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return void
     */
    public function restored(ContactGroup $contactGroup)
    {
        //
    }

    /**
     * Handle the ContactGroup "force deleted" event.
     *
     * @param  \App\Models\ContactGroup  $contactGroup
     * @return void
     */
    public function forceDeleted(ContactGroup $contactGroup)
    {
        //
    }
}
