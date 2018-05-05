<?php

namespace App\Events;

use App\Models\Contact;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Project\Services\AwsService;

class ContactDeleted
{
    use InteractsWithSockets, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;

        $this->contact->notes->each(function($item, $key) {
            $item->delete();
        });

        $this->contact->files->each(function($item, $key) {
            AwsService::removeFromS3($item->path);
            $item->delete();
        });

        $this->contact->address->delete();

    }

}
