<?php

namespace LaravelRussian\Generator\Commands\Common;

use LaravelRussian\Generator\Commands\BaseCommand;
use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Generators\ModelGenerator;

class ModelGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laravel-russian:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model command';

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

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->generate();

        $this->performPostActions();
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
