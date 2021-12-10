<?php

namespace App\Domain\Helper;

use App\Domain\Exception\ArrayNotExistRequiredField;
use ReflectionClass;

/**
 * Хелпер для работы с массивами
 */
class ArrayHelper
{
    /**
     * Содержит ли массив все указанные поля
     *
     * @param array $data
     * @param array $needFields
     * @return void
     */
    public static function existAllFields(array $data, array $needFields): void
    {
        $notExistFields = [];
        foreach ($needFields as $name) {
            if (!array_key_exists($name, $data)) {
                $notExistFields[] = $name;
            }
        }

        if ($notExistFields) {
            throw new ArrayNotExistRequiredField($notExistFields);
        }
    }

    /**
     * Заполнить указанные поля объекта
     *
     * @param object $entity
     * @param array $data
     * @param array $fields
     * @return bool
     */
    public static function fillIfExist(object $entity, array $data, array $fields): bool
    {
        $isChanged = false;

        $refClass = new ReflectionClass($entity);
        foreach ($fields as $name) {
            if (array_key_exists($name, $data) && $refClass->hasProperty($name)) {
                $refProp = $refClass->getProperty($name);
                if (!$refProp->isPublic() && $refClass->hasMethod('set'.$name)) {
                    $refMethod = $refClass->getMethod('set'.$name);
                    $refMethod->invoke($entity, $data[$name]);
                }
                else {
                    // даже если свойство не публичное, присваиваем, чтобы словить стандартную ошибку
                    $entity->{$name} = $data[$name];
                }
                $isChanged = true;
            }
        }

        return $isChanged;
    }
}