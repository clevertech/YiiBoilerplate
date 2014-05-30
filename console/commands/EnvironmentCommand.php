<?php

use Clio\Console;

/**
 * A command to easily switch between the environments.
 * You can look what the current environment is by issuing the command: `yiic environment`
 * You can set different environment by issuing the command: `yiic environment set --id=<ENV_ID>`
 *
 * @package YiiBoilerplate\Console
 */
class EnvironmentCommand extends CConsoleCommand
{

    /**
     * @var array List of directory names of all entry points + common config dir.
     */
    private $config_dirs;

    /**
     * What to do before running any action.
     *
     * We are just setting up the defaults here.
     */
    public function init()
    {
        $this->config_dirs = array(
            ROOT_DIR . '/common/config',
            ROOT_DIR . '/frontend/config',
            ROOT_DIR . '/console/config',
            ROOT_DIR . '/backend/config'
        );
    }

    /**
     * What to show to user when he run `yiic help environment`
     *
     * @see CConsoleCommand.getHelp
     * @return string Short description of what this command does.
     */
    public function getHelp()
    {
        return <<<EOD
USAGE
	yiic environment
	yiic environment set --id=ENV_ID

DESCRIPTION
	Manages the current environment for application. Changing the environment changes the set of additional overrides
	defined in the `config/overrides/environment.php` of each entry point.

	Basically, when you change the environment, to, say, `dev`, then the `dev.php` configuration file will be extracted
	from `config/environments/` subdirectory, and copied to `config/overrides/` subdirectory with the new name
	`environment.php`. This will be done for common config as well as for each individual entry point, effectively
	installing new set of overrides for base configuration across the whole application.

	Please note that environment configuration is not your local development settings like the connection settings
	for DBMS at your workstation. It's the config which will be put into the VCS repo and is intended mainly
	to differentiate between the production setup where massive micro-optimization and no debug is expected
	and development setup where the situation is quite the opposite.\n
EOD;

    }

    /**
     * Default action.
     *
     * Will be called either by `yiic environment index` or just by `yiic environment`.
     */
    public function actionIndex()
    {
        $config = (require ROOT_DIR . '/common/config/main.php');
        if (empty($config['params']['env.code']))
        {
            Console::output($this->note("It seems that current common config doesn't define any environment code."));
            return;
        }

        $value_str = $this->value($config['params']['env.code']);
        Console::output(
            "Current global environment code is {$value_str}."
        );
        Console::output(
            $this->note("Note that it can be overridden by configs of individual entry points (don't do this yourself, though).")
        );
    }

    private function note($msg)
    {
        return "%B{$msg}%n";
    }

    private function value($msg)
    {
        return "`%C%_{$msg}%n`";
    }

    /**
     * Action to set the new environment.
     *
     * It's just the copying of the config overrides
     * from <entry_point>/config/environments/<id>.php to <entry_point>/config/overrides/environment.php
     * This action automates this mundane task.
     *
     * @param string $id ID of the environment to set.
     */
    public function actionSet($id)
    {
        foreach ($this->config_dirs as $dir)
        {
            $source = "{$dir}/environments/{$id}.php";
            if(!file_exists($source))
            {
                Console::output(
                    $this->note("No config file found for this environment in ")
                    . $this->value($dir)
                    . "."
                );
                continue;
            }

            $destination = $dir . '/overrides/environment.php';

            $conversion_report = sprintf(
                "%s\n  => %s ...",
                str_replace(ROOT_DIR . '/', '', $source),
                str_replace(ROOT_DIR . '/', '', $destination)
            );

            Console::stdout($conversion_report); // no EOL, please

            // WARNING: current `config/overrides/environment.php` will be ERASED!
            copy($source, $destination);
            Console::output("done.");
        }

        Console::output(
            $this->note("Operation completed.")
        );
    }
}
