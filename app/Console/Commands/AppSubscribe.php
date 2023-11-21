<?php

namespace App\Console\Commands;

use App\Services\NoteService;
use Illuminate\Console\Command;
use App\Helpers\IPubSubPublisher;

class AppSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscribe';
    protected $description = 'Subscribe to a Redis channel';

    public function __construct(
        public IPubSubPublisher $pubSubPublisher,
        public NoteService $noteService,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $subscribeList = [
            'user_registered',
        ];

        $subscribeCallbacks = [];
        $subscribeCallbacks['userRegistered'] = function ($message, $publisher) {
            var_dump('inside method', $message);
            $data['user_id'] = $message->user_id;
            $this->noteService->CreateWelcomeNoteForRegisterdUser($data);
        };

        $this->pubSubPublisher->subscribe($subscribeList, $subscribeCallbacks);
    }

}

