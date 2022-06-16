<?php

namespace LaravelRussian\Generator\Generators;

use LaravelRussian\Generator\Common\CommandData;
use LaravelRussian\Generator\Utils\FileUtil;
use LaravelRussian\Generator\Utils\GeneratorFieldsInputUtil;

/**
 * Class FactoryGenerator.
 */
class FactoryGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;
    /** @var string */
    private $path;
    /** @var string */
    private $fileName;

    /**
     * FactoryGenerator constructor.
     *
     * @param CommandData $commandData
     */
    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = $commandData->config->pathFactory;
        $this->fileName = $this->commandData->modelName . 'Factory.php';
    }

    public function generate()
    {
        $templateData = get_template('factories.model_factory', 'laravel-generator');

        $templateData = $this->fillTemplate($templateData);

        FileUtil::createFile($this->path, $this->fileName, $templateData);

        $this->commandData->commandObj->comment("\nFactory created: ");
        $this->commandData->commandObj->info($this->fileName);
    }

    /**
     * @param string $templateData
     *
     * @return mixed|string
     */
    private function fillTemplate($templateData)
    {
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);

        $templateData = str_replace(
            '$FIELDS$',
            implode(',' . infy_nl_tab(1, 3), $this->generateFields()),
            $templateData
        );

        return $templateData;
    }

    /**
     * @return array
     */
    private function generateFields()
    {
        $fields = [];

        foreach ($this->commandData->fields as $field) {
            if ($field->isPrimary) {
                continue;
            }

            $fieldData = "'" . $field->name . "' => " . '$this->faker->';

            switch ($field->fieldType) {
                case 'integer':
                case 'float':
                    $fakerData = 'randomDigitNotNull';
                    break;
                case 'string':
                    $fakerData = 'word';
                    break;
                case 'text':
                    $fakerData = 'text';
                    break;
                case 'datetime':
                case 'timestamp':
                    $fakerData = "date('Y-m-d H:i:s')";
                    break;
                case 'enum':
                    $fakerData = 'randomElement(' .
                    GeneratorFieldsInputUtil::prepareValuesArrayStr($field->htmlValues) .
                        ')';
                    break;
                default:
                    $fakerData = 'word';
            }

            $fieldData .= $fakerData;

            $fields[] = $fieldData;
        }

        
        return $this->setSoftDeleteFieldToNull($fields);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->fileName)) {
            $this->commandData->commandComment('Factory file deleted: ' . $this->fileName);
        }
    }

    private function setSoftDeleteFieldToNull(array $fields): array
    {
        $softDeleteColumn = config('laravel-russian.laravel_generator.timestamps.deleted_at', 'deleted_at');

        if(array_key_exists($softDeleteColumn, $fields)){
            $fields[$softDeleteColumn] = null;
        }

        return $fields;
    }
}
