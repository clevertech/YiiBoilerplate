<?php

namespace Clio;

class Console
{
    /**
     * Text foreground colors.
     */
    protected static $FGCOLOR = array(
        'black'  => 30,
        'red'    => 31,
        'green'  => 32,
        'brown'  => 33,
        'blue'   => 34,
        'purple' => 35,
        'cyan'   => 36,
        'grey'   => 37,
        'yellow' => 33,
    );

    /**
     * Text styling.
     */
    protected static $STYLE = array(
        'normal'     => 0,
        'bold'       => 1,
        'light'      => 1,
        'underscore' => 4,
        'underline'  => 4,
        'blink'      => 5,
        'inverse'    => 6,
        'hidden'     => 8,
        'concealed'  => 8,
    );

    /**
     * Text background color.
     */
    protected static $BGCOLOR = array(
        'black'  => 40,
        'red'    => 41,
        'green'  => 42,
        'brown'  => 43,
        'yellow' => 43,
        'blue'   => 44,
        'purple' => 45,
        'cyan'   => 46,
        'grey'   => 47,
    );

    /**
     * Color specifier conversion table. Taken from PEAR's Console_Color.
     */
    protected static $CONVERSIONS = array(
        '%y' => array('yellow', null, null),
        '%g' => array('green', null, null),
        '%b' => array('blue', null, null),
        '%r' => array('red', null, null),
        '%p' => array('purple', null, null),
        '%m' => array('purple', null, null),
        '%c' => array('cyan', null, null),
        '%w' => array('grey', null, null),
        '%k' => array('black', null, null),
        '%n' => array('reset', null, null),
        '%Y' => array('yellow', 'light', null),
        '%G' => array('green', 'light', null),
        '%B' => array('blue', 'light', null),
        '%R' => array('red', 'light', null),
        '%P' => array('purple', 'light', null),
        '%M' => array('purple', 'light', null),
        '%C' => array('cyan', 'light', null),
        '%W' => array('grey', 'light', null),
        '%K' => array('black', 'light', null),
        '%N' => array('reset', 'light', null),
        '%3' => array(null, null, 'yellow'),
        '%2' => array(null, null, 'green'),
        '%4' => array(null, null, 'blue'),
        '%1' => array(null, null, 'red'),
        '%5' => array(null, null, 'purple'),
        '%6' => array(null, null, 'cyan'),
        '%7' => array(null, null, 'grey'),
        '%0' => array(null, null, 'black'),
        // Don't use this, I can't stand flashing text
        '%F' => array(null, 'blink', null),
        '%U' => array(null, 'underline', null),
        '%8' => array(null, 'inverse', null),
        '%9' => array(null, 'bold', null),
        '%_' => array(null, 'bold', null),
    );

    /**
     * Create ANSI-control codes for text foreground and background colors, and
     * styling.
     *
     * @param string $fgcolor Text foreground color
     * @param string $style   Text style
     * @param string $bgcolor Text background color
     *
     * @return string ANSI-control code
     */
    public static function color($fgcolor, $style, $bgcolor)
    {
        $code = array();
        if ($fgcolor == 'reset') {
            return "\033[0m";
        }
        if (isset(static::$FGCOLOR[$fgcolor])) {
            $code[] = static::$FGCOLOR[$fgcolor];
        }
        if (isset(static::$STYLE[$style])) {
            $code[] = static::$STYLE[$style];
        }
        if (isset(static::$BGCOLOR[$bgcolor])) {
            $code[] = static::$BGCOLOR[$bgcolor];
        }
        if (empty($code)) {
            $code[] = 0;
        }
        return "\033[" . implode(';', $code) . 'm';
    }

    /**
     * Taken from PEAR's Console_Color:
     *
     * Converts colorcodes in the format %y (for yellow) into ansi-control
     * codes. The conversion table is: ('bold' meaning 'light' on some
     * terminals). It's almost the same conversion table irssi uses.
     * <pre> 
     *                  text      text            background
     *      ------------------------------------------------
     *      %k %K %0    black     dark grey       black
     *      %r %R %1    red       bold red        red
     *      %g %G %2    green     bold green      green
     *      %y %Y %3    yellow    bold yellow     yellow
     *      %b %B %4    blue      bold blue       blue
     *      %m %M %5    magenta   bold magenta    magenta
     *      %p %P       magenta (think: purple)
     *      %c %C %6    cyan      bold cyan       cyan
     *      %w %W %7    white     bold white      white
     *
     *      %F     Blinking, Flashing
     *      %U     Underline
     *      %8     Reverse
     *      %_,%9  Bold
     *
     *      %n     Resets the color
     *      %%     A single %
     * </pre>
     * First param is the string to convert, second is an optional flag if
     * colors should be used. It defaults to true, if set to false, the
     * colorcodes will just be removed (And %% will be transformed into %)
     *
     * @param string $text String to color
     *
     * @return string
     */
    public static function colorize($text, $color = true)
    {
        $text = str_replace('%%', '% ', $text);
        foreach (static::$CONVERSIONS as $key => $value) {
            list($fgcolor, $style, $bgcolor) = $value;
            $text = str_replace(
                $key,
                $color ? static::color($fgcolor, $style, $bgcolor) : '',
                $text
            );
        }
        return str_replace('% ', '%', $text);
    }

    /**
     * Strips a string from color specifiers.
     *
     * @param string $text String to strip
     *
     * @return string
     */
    public static function decolorize($text)
    {
        return static::colorize($text, false);
    }

    /**
     * Strips a string of ansi-control codes.
     *
     * @param string $text String to strip
     *
     * @return string
     */
    public static function strip($text)
    {
        return preg_replace('/\033\[(\d+)(;\d+)*m/', '', $text);
    }

    /**
     * Gets input from STDIN and returns a string right-trimmed for EOLs.
     *
     * @param bool $raw If set to true, returns the raw string without trimming
     *
     * @return string
     */
    public static function stdin($raw = false)
    {
        return $raw ? fgets(STDIN) : rtrim(fgets(STDIN), PHP_EOL);
    }

    /**
     * Prints text to STDOUT.
     *
     * @param string $text
     * @param bool   $raw
     *
     * @return int|false Number of bytes printed or false on error
     */
    public static function stdout($text, $raw = false)
    {
        if ($raw) {
            return fwrite(STDOUT, $text);
        } elseif (extension_loaded('posix') && posix_isatty(STDOUT)) {
            return fwrite(STDOUT, static::colorize($text));
        } else {
            return fwrite(STDOUT, static::decolorize($text));
        }
    }

    /**
     * Prints text to STDERR.
     *
     * @param string $text
     * @param bool   $raw
     *
     * @return int|false Number of bytes printed or false on error
     */
    public static function stderr($text, $raw = false)
    {
        if ($raw) {
            return fwrite(STDERR, $text);
        } elseif (extension_loaded('posix') && posix_isatty(STDERR)) {
            return fwrite(STDERR, static::colorize($text));
        } else {
            return fwrite(STDERR, static::decolorize($text));
        }
    }

    /**
     * Prints text to STDERR appended with a PHP_EOL.
     *
     * @param string $text
     * @param bool   $raw
     *
     * @return int|false Number of bytes printed or false on error
     */
    public static function error($text = null, $raw = false)
    {
        return static::stderr($text . PHP_EOL, $raw);
    }

    /**
     * Asks the user for input. Ends when the user types a PHP_EOL. Optionally
     * provide a prompt.
     *
     * @param string $prompt String prompt (optional)
     *
     * @return string User input
     */
    public static function input($prompt = null)
    {
        if (isset($prompt)) {
            static::stdout($prompt);
        }
        return static::stdin();
    }

    /**
     * Prints text to STDOUT appended with a PHP_EOL.
     *
     * @param string $text
     * @param bool   $raw
     *
     * @return int|false Number of bytes printed or false on error
     */
    public static function output($text = null, $raw = false)
    {
        return static::stdout($text . PHP_EOL, $raw);
    }

    /**
     * Prompts the user for input
     *
     * @param string $text    Prompt string
     * @param array  $options Set of options
     *
     * @return string
     */
    public static function prompt($text, $options = array())
    {
        $options = $options + array(
            'required'  => false,
            'default'   => null,
            'pattern'   => null,
            'validator' => null,
            'error'     => 'Input unacceptable.',
        );

        top:
        if ($options['default']) {
            $input = static::input("$text [" . $options['default'] . ']: ');
        } else {
            $input = static::input("$text: ");
        }

        if (!strlen($input)) {
            if (isset($options['default'])) {
                $input = $options['default'];
            } elseif ($options['required']) {
                static::output($options['error']);
                goto top;
            }
        } elseif ($options['pattern'] && !preg_match($options['pattern'], $input)) {
            static::output($options['error']);
            goto top;
        } elseif ($options['validator'] &&
            !call_user_func_array($options['validator'], array($input, &$error))) {
            static::output(isset($error) ? $error : $options['error']);
            goto top;
        }

        return $input;
    }

    /**
     * Asks the user for a simple yes/no confirmation.
     *
     * @param string $text    Prompt string
     *
     * @return bool Either true or false
     */
    public static function confirm($text)
    {
        top:
        $input = strtolower(static::input("$text [y/n]: "));
        if (!in_array($input, array('y', 'n'))) goto top;
        return $input === 'y' ? true : false;
    }

    /**
     * Gives the user an option to choose from. Giving '?' as an input will show
     * a list of options to choose from and their explanations.
     *
     * @param string $text    Prompt string
     * @param array  $options Key-value array of options to choose from
     *
     * @return string An option character the user chose
     */
    public static function select($text, $options = array())
    {
        top:
        static::stdout("$text [" . implode(',', array_keys($options)) . ",?]: ");
        $input = static::stdin();
        if ($input === '?') {
            foreach ($options as $key => $value) {
                echo " $key - $value\n";
            }
            echo " ? - Show help\n";
            goto top;
        } elseif (!in_array($input, array_keys($options))) goto top;
        return $input;
    }

    /**
     * Execute a Closure as another process in the background while showing a
     * status update. The status update can be an indefinite spinner or a string
     * periodically sent from the background process, depending on whether the
     * provided Closure object has a $socket parameter or not. Messaging to the
     * main process is done by socket_* functions. The return value is either
     * the return value of the background process, or false if the process fork
     * failed.
     *
     * @param Closure $callable Closure object
     *
     * @return int|false Process exit status
     */
    public static function work(\Closure $callable)
    {
        if (!extension_loaded('pcntl')) {
            throw new \Exception('pcntl extension required');
        }

        if (!extension_loaded('sockets')) {
            throw new \Exception('sockets extension required');
        }

        $spinner = array('|', '/', '-', '\\');
        $i = 0; $l = count($spinner);
        $delay = 100000;

        $func = new \ReflectionFunction($callable);

        $socket = (bool)$func->getNumberOfParameters();

        if ($socket) {
            $sockets = array();
            if (socket_create_pair(AF_UNIX, SOCK_STREAM, 0, $sockets) === false) {
                return false;
            }
        }

        $pid = pcntl_fork();

        if ($pid > 0) {
            $done   = false;
            $retval = 0;
            pcntl_signal(SIGCHLD, function() use ($pid, &$done, &$retval) {
                $child_pid = pcntl_waitpid($pid, $status);
                if (pcntl_wifexited($status)) {
                    $retval = pcntl_wexitstatus($status);
                }
                $done = true;
            });

            if ($socket) {
                $text = '';
                while (!$done) {
                    $r = array($sockets[1]);
                    $w = null;
                    $e = null;
                    if ($status = socket_select($r, $w, $e, 0)) {
                        $data = socket_read($sockets[1], 4096, PHP_NORMAL_READ);
                        if ($data === false) {
                            throw new \Exception(
                                sprintf(
                                    'socket write error %s',
                                    socket_strerror(socket_last_error($sockets[1]))
                                )
                            );
                        }
                        echo str_repeat(chr(8), strlen($text));
                        $text = rtrim($data, "\n");
                        Console::stdout($text);
                    } else {
                        pcntl_signal_dispatch();
                    }
                    usleep($delay);
                }
                echo str_repeat(chr(8), strlen($text));
                socket_close($sockets[0]);
                socket_close($sockets[1]);
            } else {
                while (!$done) {
                    pcntl_signal_dispatch();
                    echo $spinner[$i];
                    usleep($delay);
                    echo chr(8);
                    $i = $i === $l - 1 ? 0 : $i + 1;
                }
            }

            return $retval;
        } elseif ($pid === 0) {
            if ($socket) {
                call_user_func($callable, $sockets[0]);
            } else {
                call_user_func($callable);
            }
            exit;
        } else {
            // Unable to fork process.
            return false;
        }
    }
}

