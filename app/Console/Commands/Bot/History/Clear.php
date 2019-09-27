<?php

namespace App\Console\Commands\Bot\History;

use App\Repositories\Contracts\SentMessagesRepository;
use Illuminate\Console\Command;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:history:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'clean bot sent messages history';
    /**
     * @var SentMessagesRepository
     */
    private $sentMessagesRepository;

    /**
     * Create a new command instance.
     *
     * @param SentMessagesRepository $sentMessagesRepository
     */
    public function __construct(SentMessagesRepository $sentMessagesRepository)
    {
        parent::__construct();
        $this->sentMessagesRepository = $sentMessagesRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sentMessagesRepository->deleteAll();
    }
}
