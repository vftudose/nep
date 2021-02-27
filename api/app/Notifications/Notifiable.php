<?php

namespace App\Notifications;

interface Notifiable
{
    const BRIZZ_CHANNEL = 'brizz-chanel';
    const INVOICE_GENERATED_EVENT = 'invoice-generated-event';

    public function notify(): void;
}
