# Clio

Clio is a lightweight utility and helper classes for CLI applications.
It provides colored output, prompts, confirmation inputs, selections, background
processes, as well as a way to start and stop daemons.

## Installation

The prefered way to install Clio is through [composer][Composer]; the minimum
composer.json configuration is:

```
{
    "require": {
        "clio/clio": "@stable"
    }
}
```

PHP 5.3.2 or newer is required; PHP 5.4 is strongly recommended. This library is
developed on and is meant to be used on POSIX systems with the posix, pcntl, and
sockets extensions loaded.

## Console

The Console class provides helpers for interactive command line input/output.

### Console::stdout($text, $raw = false)

Prints `$text` to STDOUT. The text can contain text color and style specifiers.
This method detects whether the text is to be sent out to TTY or to a file
through the use of shell redirection and acts accordingly, in the case of the
latter, by stripping the text of all color and style specifiers.

If the second parameter is set to true, then it will print `$text` as is with
all text color and style specifiers intact regardless of whether it's printing
to TTY or to a file.

```php
<?php
use Clio\Console;
Console::stdout('Hello, World!');
```

### Console::output($text, $raw = false)

The same as `Console::stdout` except it automatically appends a `PHP_EOL`.

### Console::stderr($text, $raw = false)

Behaves like `Console::stdout` except it's for STDERR.

### Console::error($text, $raw = false)

The same as `Console::stderr` except it automatically appends a `PHP_EOL`.

### Console::prompt($text, $options)

This function prompts the user for input. Several options are available:

- `required`: True if input is necessary, false otherwise.
- `default`: If the user does not provide an input, this is the default value.
- `pattern`: Regular expression pattern to match.
- `validator`: Callable to validate input. Must return `true` or `false`.

If an input error occurs, the prompt will repeat and will keep asking the user
for input until it satisfies all the requirements in the `$options` array. Note
that if you supply a `default` option, `required` is not enforced.

```php
<?php
$db_host = Console::prompt('database host', ['default' => 'localhost']);
```

### Console::confirm($text)

Asks the user for a simple y/n answer. The answer can be `'y'`, `'n'`, `'Y'`, or
`'N'`. Returns either `true` or `false`.

```php
<?php
$sure = Console::confirm('are you sure?');
```

### Console::select($text, $options)

Asks the user to choose from a selection of options. The `$options` array is a
key-value pairs of input and explanation. The `'?'` input option is appended
automatically and it serves as the help option showing all other options along
with their respective explanations.

```php
<?php
$opt = Console::select('apply this patch?',
    ['y' => 'yes', 'n' => 'no', 'a' => 'all']
);
```

### Console::work(Closure $callable)

Forks another process to run `$callable` in the background while showing status
updates to the standard output. By default the status update is a simple spinner
which will stop once the `$callable` returns. By providing `$callable` with a
`$socket` parameter, the status update is whatever is sent from the background
process to the foreground process using the `socket_write()` function:

```php
<?php
Console::stdout('Working ... ');
Console::work(function($socket) { // $socket is optional, defaults to a spinner
    $n = 100;
    for ($i = 1; $i <= $n; $i++) {
        // do whatever it is you need to do
        socket_write($socket, "[$i/$n]\n");
        sleep(1); // sleep is good for you
    }
});
Console::stdout("%g[DONE]%n\n");
```

Messages sent to the foreground process needs to end with a `"\n"` character.

### Text color and style specifiers

You can use text color and style specifiers in the format of `%x` where `x` is
the specifier:

```php
<?php
Console::output('this is %rcolored%n and %Bstyled%n');
```

The `%n` specifier normalizes the color and style of the text to that of the
shell's defaults. This specifier is taken from PEAR's Console_Color package.
Consult the source code for the full set of specifiers. To print a percentage
symbol, simply put two `%` characters.

## Daemon

The Daemon class provides helpers for starting and killing daemonized processes.

### Daemon::isRunning($pid)

Tests if a daemon is currently running or not. Returns true or false:

```php
<?php
use Clio\Daemon;
if (Daemon::isRunning('/path/to/process.pid')) {
    echo "daemon is running.\n";
} else {
    echo "daemon is not running.\n";
}
```

### Daemon::work(array $options, Closure $callable)

Daemonize a `$callable` Closure object. The `$options` key-value array must
contain `pid` as the path to the PID file:

```php
<?php
use Clio\Daemon;
if (Daemon::isRunning('/path/to/process.pid')) {
    echo "daemon is already running.\n";
} else {
    Daemon::work(array(
            'pid'    => '/path/to/process.pid', // required
            'stdin'  => '/dev/null',            // defaults to /dev/null
            'stdout' => '/path/to/stdout.txt',  // defaults to /dev/null
            'stderr' => '/path/to/stderr.txt',  // defaults to php://stdout
        ),
        function($stdin, $stdout, $stderr) { // these parameters are optional
            while (true) {
                // do whatever it is daemons do
                sleep(1); // sleep is good for you
            }
        }
    );
    echo "daemon is now running.\n";
}
```

The PID file is an ordinary text file with the process ID as its only content.
It will be created by the library automatically if it doesn't exist. It is
highly recommended to put a call to `sleep` to ease the system load.

### Daemon::kill($pid, $delete = false)

Kill a daemonized process:

```php
<?php
use Clio\Daemon;

if (Daemon::isRunning('/path/to/process.pid')) {
    echo "killing running daemon ...\n";
    if (Daemon::kill('/path/to/process.pid')) {
        echo "daemon killed.\n";
    } else {
        echo "failed killing daemon.\n";
    }
} else {
    echo "nothing to kill.\n";
}
```

If the second parameter is set to `true`, this function will try to delete the
PID file after successfully sending the process a kill signal. 

## Acknowledgments

The text color and style specifiers are taken entirely from PEAR's Console_Color
class by Stefan Walk. The Daemon class is heavily inspired from Andy Thompson's
blog post on [daemonizing a PHP CLI script on a POSIX system][post].

## License

Clio is released under the [MIT License][MIT].

[Composer]: http://getcomposer.org/
[MIT]: http://en.wikipedia.org/wiki/MIT_License
[post]: http://andytson.com/blog/2010/05/daemonising-a-php-cli-script-on-a-posix-system/

