<?php

namespace App\Console\Commands;

use App\Services\Contracts\MailingServiceInterface;
use App\Services\MailingService;
use Illuminate\Console\Command;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:messages {frequency?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send messages to user with posts that he was subscribed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $frequency = $this->argument('frequency');
        /** @var MailingService $mailingService */
        $mailingService = resolve(MailingServiceInterface::class);

        $mailingService->sendSubscription($frequency);
    }
}
