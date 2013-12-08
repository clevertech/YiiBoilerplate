<?php
/**
 * A command to easily switch between the environments.
 * You can look what the current environment is by issuing the command: `yiic environment`
 * You can set different environment by issuing the command: `yiic environment set --id=<ENV_ID>`
 */
class EnvironmentCommand extends CConsoleCommand
{

    /**
     * @var array List of directory names of all entry points + common config dir.
     */
    private $config_dirs;

    public function init()
    {
        $this->config_dirs = array(
            ROOT_DIR . '/common/config',
            ROOT_DIR . '/frontend/config',
            ROOT_DIR . '/console/config',
            ROOT_DIR . '/backend/config'
        );
    }

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
	and development setup where the situation is quite the opposite.
EOD;

    }

    public function actionIndex()
    {
        $config = (require ROOT_DIR . '/common/config/main.php');
        if (empty($config['params']['env.code'])) {
            echo "It seems that current common config doesn't define any environment code.\n";
        } else {
            echo "Current global environment code is `{$config['params']['env.code']}`.\n";
            echo "Note that it can be overridden by configs of individual entry points (don't do this yourself, though).\n";
        }
    }

    public function actionSet($id)
    {
        foreach ($this->config_dirs as $dir)
        {
            $source = "{$dir}/environments/{$id}.php";
            if(!file_exists($source))
            {
                echo "No config file found for this environment in {$dir}\n";
                continue;
            }

            $destination = $dir . '/overrides/environment.php';

            printf(
                "%s\n  => %s ...",
                str_replace(ROOT_DIR . '/', '', $source),
                str_replace(ROOT_DIR . '/', '', $destination)
            );

            // WARNING: current `config/overrides/environment.php` will be ERASED!
            copy($source, $destination);
            echo "done.\n";
        }

        echo "\nOperation completed.\n";
    }
}
