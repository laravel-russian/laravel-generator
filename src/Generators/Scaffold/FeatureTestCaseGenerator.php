<?php

namespace LaravelRussian\Generator\Generators\Scaffold;

use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Generators\BaseGenerator;
use LaravelRussian\Generator\Utils\FileUtil;

class FeatureTestCaseGenerator extends BaseGenerator
{
    const CLASS_NAME = 'FeatureTestCase';
    const STUB_FILE_NAME = 'feature_test_case';
    
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;


    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = config('infyom.laravel_generator.path.tests', base_path('tests/'));
    }

    public function generate()
    {
            $templateData = get_template("test." . self::STUB_FILE_NAME, 'laravel-generator');

            $templateData = $this->fillTemplate($templateData);

            FileUtil::createFile($this->path, $this->getFileName(), $templateData);

            $this->commandData->commandObj->comment("\Abstract class for Test classes created: ");
            $this->commandData->commandObj->info($this->getFileName());
    }

    private function fillTemplate($templateData)
    {
        return fill_template($this->commandData->dynamicVars, $templateData);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->getFileName())) {
            $this->commandData->commandComment('Abstract class for Test classes file deleted: ' . $this->getFileName());
        }
    }

    private function getFileName()
    {
        return self::CLASS_NAME . ".php";
    }
}
