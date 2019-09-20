<?php


namespace App\Console\Commands\Bot\History;

use App\Console\Commands\Bot\TelegramTrait;
use Illuminate\Console\Command;

/**
 * Class Retrieve
 *
 * @package App\Console\Commands\Bot\History
 */
class Retrieve extends Command
{
    use TelegramTrait;


    /**
     * @var string
     */
    protected $signature = 'bot:history {peer?}';

    /**
     * @var string
     */
    protected $description = 'Send message';


    /**
     * @return void
     */
    public function handle(): void
    {
        $madeline = $this->getMadelineInstance();

        $dialogs = $madeline->get_dialogs();

        $peer = $this->argument('peer');

        if(null === $peer){
            $peer = readline('Enter peer: ');
        }

        $messages = $madeline->messages->getHistory([
            'peer' => $peer,
            'offset_id' => 0,
            'offset_date' => 0,
            'add_offset' => 0,
            'limit' => 15,
            'max_id' => 0,
            'min_id' => 0,
            ]);

        foreach ($messages['messages'] as $message){
            dump($message['message']);
        }

        $messages = $madeline->messages->searchGlobal(
            [
                'q' => 'string',
                'offset_rate' => 0,
                'offset_id' => 0,
                'limit' => 100,
                ]
        );
        dump($messages);
    }
}