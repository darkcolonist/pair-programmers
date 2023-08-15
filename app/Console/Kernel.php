<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  /**
   * The Artisan commands provided by your application.
   *
   * @var array
   */
  protected $commands = [
    \App\Console\Commands\DecrementCommand::class,
    \App\Console\Commands\IncrementCommand::class,
    \App\Console\Commands\DiscordSendCurrentCommand::class,
    \App\Console\Commands\TestLogCommand::class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    $schedule->command('current:increment"')->dailyAt('07:00')->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ]);
    $schedule->command('discord:current"')->dailyAt('07:05')->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ]);

    /**
     * below are test cases that need to be deleted soon!
     */
    $schedule->command('test:log "daily cron #1"')->dailyAt('07:00')->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ]);
    $schedule->command('test:log "daily cron #2"')->dailyAt('07:05')->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ]);
  }
}
