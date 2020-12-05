<?php

namespace App\Console;

use App\Acme\Services\LotteryService;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $seconds = 1;

        $schedule->command('queue:restart')
            ->everyFiveMinutes();

        $schedule->command('queue:work --daemon')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->call(function () use ($schedule, $seconds) {

            $dt = Carbon::now();

            // run every second
            $x=60/$seconds;

            do{
                // do your function here that takes between 3 and 4 seconds
                (new LotteryService)->runLottery($isSystem = true);
                (new LotteryService)->addFakeParticipants($isSystem = true);

                time_sleep_until($dt->addSeconds($seconds)->timestamp);

            } while($x-- > 0);

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
