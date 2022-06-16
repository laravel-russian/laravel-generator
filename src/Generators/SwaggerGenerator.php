<?php

namespace LaravelRussian\Generator\Generators;

use LaravelRussian\Generator\Common\GeneratorField;

class SwaggerGenerator
{
    public static $swaggerTypes = [];

    /**
     * @param GeneratorField[] $inputFields
     *
     * @return array
     */
    public static function generateTypes($inputFields)
    {
        if (!empty(self::$swaggerTypes)) {
            return self::$swaggerTypes;
        }

        $fieldTypes = [];

        foreach ($inputFields as $field) {
            $fieldData = self::getFieldType($field->fieldType);
            $fieldType = $fieldData['fieldType'];
            $fieldFormat = $fieldData['fieldFormat'];

            if (!empty($fieldType)) {
                $fieldType = [
                    'name'   => $field->name,
                    'type'   => $fieldType,
                    'format' => $fieldFormat,
                ];

                $fieldType['description'] = (!empty($field->description)) ? $field->description : '';

                $fieldTypes[] = $fieldType;
            }
        }

        self::$swaggerTypes = $fieldTypes;

        return self::$swaggerTypes;
    }

    public static function getFieldType($type)
    {
        $fieldType = null;
        $fieldFormat = null;
        switch (strtolower($type)) {
            case 'increments':
            case 'integer':
            case 'smallinteger':
            case 'long':
            case 'biginteger':
                $fieldType = 'integer';
                $fieldFormat = 'int32';
                break;
            case 'double':
            case 'float':
            case 'real':
            case 'decimal':
                $fieldType = 'number';
                $fieldFormat = 'number';
                break;
            case 'boolean':
                $fieldType = 'boolean';
                break;
            case 'string':
            case 'char':
            case 'text':
            case 'mediumtext':
            case 'longtext':
            case 'enum':
                $fieldType = 'string';
                break;
            case 'byte':
                $fieldType = 'string';
                $fieldFormat = 'byte';
                break;
            case 'binary':
                $fieldType = 'string';
                $fieldFormat = 'binary';
                break;
            case 'password':
                $fieldType = 'string';
                $fieldFormat = 'password';
                break;
            case 'date':
                $fieldType = 'string';
                $fieldFormat = 'date';
                break;
            case 'datetime':
            case 'timestamp':
                $fieldType = 'string';
                $fieldFormat = 'date-time';
                break;
        }

        return ['fieldType' => $fieldType, 'fieldFormat' => $fieldFormat];
    }

    public static function generateSwagger($fields, $fillables, $variables)
    {
        $template = get_template('model_docs.model', 'swagger-generator');

        $templateData = fill_template($variables, $template);

        $templateData = str_replace('$REQUIRED_FIELDS$', '"'.implode('", "', $fillables).'"', $templateData);

        $propertyTemplate = get_template('model_docs.property', 'swagger-generator');

        $properties = self::preparePropertyFields($propertyTemplate, $fields);

        $templateData = str_replace('$PROPERTIES$', implode(",\n", $properties), $templateData);

        return $templateData;
    }

    /**
     * @param $template
     * @param $fields
     *
     * @return array
     */
    public static function preparePropertyFields($template, $fields)
    {
        $templates = [];

        foreach ($fields as $field) {
            $fieldName = $field['name'];
            $type = $field['type'];
            $format = $field['format'];
            $propertyTemplate = str_replace('$FIELD_NAME$', $fieldName, $template);
            $description = $field['description'];
            if (empty($description)) {
                $description = $fieldName;
            }
            $propertyTemplate = str_replace('$DESCRIPTION$', $description, $propertyTemplate);
            $propertyTemplate = str_replace('$FIELD_TYPE$', $type, $propertyTemplate);
            if (!empty($format)) {
                $format = ",\n *          format=\"".$format.'"';
            }
            $propertyTemplate = str_replace('$FIELD_FORMAT$', $format, $propertyTemplate);
            $templates[] = $propertyTemplate;
        }

        return $templates;
    }
}
