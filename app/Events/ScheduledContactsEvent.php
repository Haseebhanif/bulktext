<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduledContactsEvent implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    use InteractsWithQueue;
    use Queueable;


    /**
     * Create a new event instance.
     *
     * @return void
     */


    public $scheduleId;
    public $contactGroupId;

    public $contacts;

    public function __construct($scheduleId,$contactGroupId,$contacts)
    {
        $this->scheduleId =$scheduleId;
        $this->contactGroupId = $contactGroupId;
        $this->contacts = $contacts;
    }

}
