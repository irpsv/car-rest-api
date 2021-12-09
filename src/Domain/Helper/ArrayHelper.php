<?php

namespace App\Domain\Helper;

use App\Domain\Exception\ArrayNotExistRequiredField;

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

        foreach ($fields as $name) {
            if (array_key_exists($name, $data) && property_exists($entity, $name)) {
                // приведение типов оставляем на типизации
                $entity->{$name} = $data[$name];
                $isChanged = true;
            }
        }

        return $isChanged;
    }
}