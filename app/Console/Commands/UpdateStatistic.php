<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Statistic\Entities\Statistic;
use Modules\Statistic\Http\Controllers\StatisticController;

class UpdateStatistic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:statistic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update statistics results automatically';

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
        StatisticController::updateDailyStatisticTotal();
    }
}
