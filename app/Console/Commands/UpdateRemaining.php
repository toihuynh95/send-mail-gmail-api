<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Project\Http\Controllers\ProjectController;

class UpdateRemaining extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:remaining';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Remaining Of Project By Month';

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
        ProjectController::updateRemainingByMonth();
    }
}
