<?php

require __DIR__ . '/clio/src/Clio/Console.php';

use Clio\Console;

/**
 * Class Deploy
 */
class Deploy
{
	private $root;
	private $phpPath = 'php';
	private $windows = false;
	private $configDirs = array(
		'/common/config',
		'/frontend/config',
		'/console/config',
		'/backend/config'
	);
	private $environments = array(
		'private',
		'prod'
	);

	public function __construct()
	{
		$this->root = __DIR__ . '/../../';
		$this->windows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
		if ($this->windows) {
			$this->phpPath = 'php';
		} else {
			$this->phpPath = exec('which php');
		}
	}


	public function run($argc, $argv)
	{
		if (1 === $argc || in_array('--help', $argv) || (null === ($env = $this->getEnv($argv)))) {
			$this->help($argv[0]);
			return;
		}
		//$this->runComposer($env);
		chmod($this->root . 'frontend/runtime', 02777);
		chmod($this->root . 'backend/runtime', 02777);
		chmod($this->root . 'console/runtime', 02777);
		chmod($this->root . 'frontend/www/assets', 02777);
		chmod($this->root . 'backend/www/assets', 02777);
		$this->createEnvConfigs($env);
		if (in_array('--migrate', $argv)) {
			$this->runYiiMigrations();
		}
		Console::output("%yDone!%n");
	}

	/**
	 * Gen environment code. You can list available codes in {@link $environments}
	 * @param $argv
	 * @return string|null
	 */
	private function getEnv($argv)
	{
		foreach ($this->environments as $env) {
			if (false !== in_array($env, $argv, true)) {
				return $env;
			}
		}
	}

	/**
	 * Print help message
	 * @param $cmd
	 */
	private function help($cmd)
	{
		Console::output("%yUsage:%n");
		Console::output("$cmd [--[no-]migrate] [environment]\n");
		Console::output("%yArguments:%n");
		Console::output(" environment\t\tEnvironment of the application.");
		$environments = implode(', ', array_map(function ($env) {
			return "%y" . $env . "%n";
		}, $this->environments));
		Console::output("\t\t\tCould be {$environments}");
		Console::output("%yOptions:%n");
		Console::output(" --[no-]migrate\t\tWhether or not run migrations.");
	}

	/**
	 * Run composer install command
	 * @link http://getcomposer.org/
	 * @param $env
	 */
	private function runComposer($env)
	{
		$dev = 'prod' === $env ? '--no-dev' : '--dev';
		$this->runCommand($this->phpPath . " {$this->root}composer.phar install " . $dev);
	}

	/**
	 * Runs a shell command and print "Error" on failure
	 * @param $command
	 */
	private function runCommand($command)
	{
		Console::output("%yExecuting %g" . $command . "%n");
		$return = -1;
		passthru($command, $return);
		if (0 !== $return) {
			Console::output("%k%1Error!%n");
		}
	}

	/**
	 * Run Yii console migrate command
	 */
	private function runYiiMigrations()
	{
		$root = $this->root;
		$phpPath = $this->phpPath;
		$this->runCommand($phpPath . ' \'' . $root . "yiic' migrate --interactive=0");
	}

	/**
	 * Copy environment specific config file to main-env.php for each config directory
	 * @param $env
	 */
	private function createEnvConfigs($env)
	{
		Console::output("%yCreate environment config files:%n");
		foreach ($this->configDirs as $dir) {
			$source = "{$dir}/environments/{$env}.php";
			if (file_exists($this->root . $source)) {
				$destination = $dir . '/main-env.php';
				Console::output("%gCopy:%n\t\t{$source} => {$destination}");
				copy($this->root . $source, $this->root . $destination);
			} else {
				Console::output("%wNot found:%n\t{$source}");
			}
		}
		Console::output("");
	}
}
