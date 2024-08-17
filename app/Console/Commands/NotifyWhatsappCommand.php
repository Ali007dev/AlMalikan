<?php

namespace App\Console\Commands;

use App\Jobs\NotifyWhatsappJob;
use Illuminate\Console\Command;

class NotifyWhatsappCommand extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send daily reservation reminders to users';

    public function handle()
    {
        dispatch(new NotifyWhatsappJob());
    }
}
