<?php

namespace LaravelRussian\Generator\Commands\Scaffold;

use LaravelRussian\Generator\Commands\BaseCommand;
use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Generators\Scaffold\RequestGenerator;

class RequestsGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laravel-russian.scaffold:requests';

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

        $requestGenerator = new RequestGenerator($this->commandData);
        $requestGenerator->generate();

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
