<?php

namespace App\Domain\Helper;

use App\Domain\Exception\NameIsRequired;

/**
 * Для сущностей у которых есть свойство 'name'
 */
trait Nameable
{
    /**
     * Задать значение
     *
     * @param string $value
     * @return void
     */
    public function setName(string $value): void
    {
        $value = trim($value);
        if (empty($value)) {
            throw new NameIsRequired(get_called_class());
        }
        $this->name = $value;
    }

    /**
     * Получить значение
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}