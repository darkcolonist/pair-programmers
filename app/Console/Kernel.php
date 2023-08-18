<?php

namespace App\Console;

use App\Helpers\DateSkipper;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use \App\Helpers\Random;

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
    \App\Console\Commands\DiscordSendCustomMessageCommand::class,
    \App\Console\Commands\TestLogCommand::class,
    \App\Console\Commands\TestDiscordCommand::class,
  ];

  /**
   * Define the application's command schedule.
   *
   * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
   * @return void
   */
  protected function schedule(Schedule $schedule)
  {
    $randomMinuteForDiscordCurrent = Random::int(5, 21, date('Ymd'));

    $schedule->command('current:increment')->dailyAt('07:00')->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ])->skip(function () {
      return DateSkipper::matchToday();
    });

    $schedule->command('discord:current')->dailyAt('07:'.$randomMinuteForDiscordCurrent)->days([
      Schedule::MONDAY,
      Schedule::TUESDAY,
      Schedule::WEDNESDAY,
      Schedule::THURSDAY,
      Schedule::FRIDAY,
    ])->skip(function () {
      return DateSkipper::matchToday();
    });

    // $schedule->command('test:log "run"')->everyMinute()->skip(function () {
    //   return DateSkipper::matchToday();
    // });
  }
}
