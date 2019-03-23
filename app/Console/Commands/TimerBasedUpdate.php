<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Business\Services\DueDateUpdate\Processor;

class TimerBasedUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'duedate:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $processor = new Processor();
        $processor->timerBased();
    }
}
