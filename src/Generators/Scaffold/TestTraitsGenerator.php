<?php

namespace LaravelRussian\Generator\Generators\Scaffold;

use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Generators\BaseGenerator;
use LaravelRussian\Generator\Utils\FileUtil;

class TestTraitsGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /**
     * Test traits to publish
     *
     * @var array
     */
    private $testTraits = [
        'api_test_trait' => 'ApiTestTrait',
        'model_test_trait' => 'ModelTestTrait',
    ];

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('laravel-russian.laravel_generator.path.tests', base_path('tests/'));
    }

    public function generate()
    {
        foreach ($this->testTraits as $stubFileName => $className) {
            $templateData = get_template("test.{$stubFileName}", 'laravel-generator');

            $templateData = $this->fillTemplate($templateData);

            FileUtil::createFile($this->path, $this->getFileName($className), $templateData);

            $this->commandData->commandObj->comment("\nTest Traits created: ");
            $this->commandData->commandObj->info($this->getFileName($className));
        }
    }

    private function fillTemplate($templateData)
    {
        return fill_template($this->commandData->dynamicVars, $templateData);
    }

    public function rollback()
    {
        foreach ($this->testTraits as $stubFileName => $className) {
            if ($this->rollbackFile($this->path, $this->getFileName($className))) {
                $this->commandData->commandComment('Test trait file deleted: ' . $this->getFileName($className));
            }
        }
    }

    private function getFileName(string $className)
    {
        return "{$className}.php";
    }
}
