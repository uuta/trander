<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RequestLimits\RestoreRequestLimitService;
use App\Repositories\RequestLimits\RequestLimitRepository;

class RestoreRequestLimitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:restore-request-limit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore request limit';

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
        (new RestoreRequestLimitService(new RequestLimitRepository()))->handle();
    }
}
