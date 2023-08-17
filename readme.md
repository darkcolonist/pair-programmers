# pair programmers
to display programmer pairups

# requirements
* php-7.3.9
* laravel/lumen-framework ^8.3.1

## usage
* copy `storage/app/members.txt.example` to `storage/app/members.txt`
* copy `storage/app/current.txt.example` to `storage/app/current.txt`
pairups will change depending on the number in `storage/app/current.txt`.

## commands
* `php artisan current:increment` to increment the value in the `storage/app/current.txt` file
* `php artisan current:decrement` to decrement the value in the `storage/app/current.txt` file
* `php artisan discord:current` to send the current list of pairups to discord webhook

## cronjobs
`* * * * * /path/to/php artisan schedule:run`
