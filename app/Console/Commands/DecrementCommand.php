<?php
namespace App\Console\Commands;
use Exception;
use Illuminate\Console\Command;

class DecrementCommand extends Command
{
  protected $signature = "current:decrement";
  protected $description = "decrement the current counter";

  public function handle()
  {
    $file = storage_path('app/current.txt');

    try {
      if (!file_exists($file)) {
        throw new Exception("The file '$file' does not exist.");
      }

      $currentValue = intval(file_get_contents($file));

      if($currentValue == 0)
        $this->info("unable to decrement, value is already 0");
      else{
        $newValue = $currentValue - 1;

        if (!is_writable($file)) {
          throw new Exception("The file '$file' is not writable.");
        }

        file_put_contents($file, strval($newValue));

        $this->info("Current value: $currentValue");
        $this->info("Updated value: $newValue");
      }
    } catch (Exception $e) {
      $this->error($e->getMessage());
    }
  }
}
