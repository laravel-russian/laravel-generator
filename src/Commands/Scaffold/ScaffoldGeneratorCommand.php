<?php

namespace LaravelRussian\Generator\Commands\Scaffold;

use LaravelRussian\Generator\Commands\BaseCommand;
use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Utils\FileUtil;

class ScaffoldGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laravel-russian:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD views for given model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        if ($this->checkIsThereAnyDataToGenerate()) {
            $this->commandData->fireEvent('scaffold', FileUtil::FILE_CREATING);
            $this->generateCommonItems();

            $this->generateScaffoldItems();

            $this->performPostActionsWithMigration();
            $this->commandData->fireEvent('scaffold', FileUtil::FILE_CREATED);
        } else {
            $this->commandData->commandInfo('There are not enough input fields for scaffold generation.');
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }

    /**
     * Check if there is anything to generate.
     *
     * @return bool
     */
    protected function checkIsThereAnyDataToGenerate()
    {
        if (count($this->commandData->fields) > 1) {
            return true;
        }
    }
}
