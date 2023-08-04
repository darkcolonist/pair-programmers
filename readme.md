# pair programmers

to display programmer pairups

# requirements
* php-7.3.9

## usage
* copy `members.txt.example` to `members.txt`
* copy `current.txt.example` to `current.txt`
pairups will change depending on the number in `current.txt`.

## cronjobs
to run the increment mon-fri every 7am `0 7 * * 1-5 /path/to/php /path/to/increment.php`