<?php

namespace LaravelRussian\Generator\Commands\API;

use LaravelRussian\Generator\Commands\BaseCommand;
use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Utils\FileUtil;

class APIGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laravel-russian:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD API for given model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_API);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();
        $this->commandData->fireEvent('api', FileUtil::FILE_CREATING);

        $this->generateCommonItems();

        $this->generateAPIItems();

        $this->performPostActionsWithMigration();
        $this->commandData->fireEvent('api', FileUtil::FILE_CREATED);
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
}
