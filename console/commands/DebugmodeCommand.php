<?php
/**
 * This is the command to manage debug mode for a project
 *
 * @see `common/boostrap.php`
 * @see `common/debugmode.php`
 */
class DebugmodeCommand extends CConsoleCommand
{
	/**
	 * @var string Name of the file which serves as a marker for whether we enable debug mode.
	 */
	private static $marker_file_name;

	public function init()
	{
		parent::init();
		self::$marker_file_name = ROOT_DIR . DS . 'debugmodeon';
	}

	public function actionIndex()
	{
		$this->printDebugStatus();
	}

	private function printDebugStatus()
	{
		echo $this->isDebugEnabled()
			? "Debug mode is ON\n"
			: "Debug mode is OFF\n";
	}

	/**
	 * Debug mode is enabled when the file named 'debugmodeon' is present in the root dir of project.
	 *
	 * NOTE that if you delete this file midway through the execution of the program debug mode will not be disabled
	 * instantly. This marker file is meaningful only upon the initialization of the application.
	 *
	 * @return bool Whether or not debug mode is enabled.
	 */
	private function isDebugEnabled()
	{
		return file_exists(self::$marker_file_name);
	}

	public function getHelp()
	{
		return <<<EOD
USAGE
	yiic debugmode [on|off]

DESCRIPTION
	Allows you to enable/disable the debug mode for the current application.
	Also allows you to check the status of debug mode.

	Debug mode enables Yii's specific logging facilities and also forces PHP to use super-strict error checking.
	All errors catched in debug mode are sent to the client's browser.

PARAMETERS
	on: enables debug mode
	off: disables debug mode

	When called without any parameters echoes back the status of debug mode (on/off).
EOD;
	}

	public function actionOn()
	{
		$this->printDebugStatus();
		if (!file_exists(self::$marker_file_name))
		{
			echo "Enabling debug mode...\n";
			fclose(fopen(self::$marker_file_name, 'w'));
			$this->printDebugStatus();
		}
	}

	public function actionOff()
	{
		$this->printDebugStatus();
		if (file_exists(self::$marker_file_name))
		{
			echo "Disabling debug mode...\n";
			unlink(self::$marker_file_name);
			$this->printDebugStatus();
		}
	}

}
