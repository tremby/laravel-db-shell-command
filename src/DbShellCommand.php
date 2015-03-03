<?php
namespace Tremby\DbShellCommand;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DbShellCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:shell';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Launch a database shell";

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$connection = $this->option('connection');
		$config = \Config::get('database.connections.' . $connection);
		if (!$config) {
			$this->error("Didn't find database connection '$connection'");
			return 1;
		}

		$c = array_map('escapeshellarg', $config);

		switch ($config['driver']) {
			case 'mysql':
				$args = array('mysql');
				array_push($args, '-h', $c['host']);
				if (isset($config['port'])) {
					array_push($args, '-P', $c['port']);
				}
				array_push($args, '-u', $c['username']);
				if ($config['password'] !== null && strlen($config['password']) > 0) {
					array_push($args, '-p' . $c['password']);
				}
				array_push($args, $c['database']);
				break;
			default:
				$this->error("Unsupported database driver '{$config['driver']}' for connection '$connection'");
				return 1;
		}

		$command = implode(' ', $args);
		$this->info("running command: $command");
		$proc = proc_open($command, array(STDIN, STDOUT, STDERR), $pipes);

		if ($proc === false) {
			$this->error("Failed to open process");
			return 2;
		}

		return proc_close($proc);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array(
				"connection", 'c',
				InputOption::VALUE_REQUIRED,
				"The identifier of the connection to use; a key of your "
					. "'database.connections' configuration array.",
				\Config::get('database.default'),
			),
		);
	}

}
