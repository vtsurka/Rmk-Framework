<?php
/**
 * Абстрактный класс коллекции объектов.
 *
 * Абстрактный класс коллекции объектов предназначен для реализации базовой
 * функциональности коллекции объектов.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use Rmk\Util;

abstract class AbstractCollection implements Collection
{

    /**
     * Помощник определения типов значений.
     *
     * @var Util\Value\Type\Helper
     */
    protected $_valueTypeHelper;

    /**
     * Конструктор.
     *
     * @param  string $valueType
     * @return void
     */
    public function __construct($valueType)
    {
        $this->_valueTypeHelper = new Util\Value\Type\Helper($valueType);
    }

    /**
     * Возвращает тип значений.
     *
     * Возвращает тип значений. Если тип значений не задан, то будет выброшено
     * исключение UnexpectedValueException.
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getValueType()
    {
        return $this->_valueTypeHelper->getType();
    }

    /**
     * Устанавливает тип значений.
     *
     * Устанавливает тип значений. При попытке изменить тип значений у
     * заполненной коллекции будет выброшено исключение RuntimeException.
     *
     * @param  string $type
     * @return void
     * @throws RuntimeException
     */
    public function setValueType($type)
    {
        if (!$this->isEmpty()) {
            throw new RuntimeException(
                    'Невозможно изменить тип значения заполненной коллекции.'
            );
        }

        $this->_valueTypeHelper->setType($type);
    }

    /**
     * Проверяет, содержит ли коллекция переданную коллекцию.
     *
     * @param  Collection $collection
     * @return boolean
     */
    public function containsCollection(Collection $collection)
    {
        if ($this === $collection) {
            return true;
        }

        $self     = $this;
        $contains = true;

        $collection->each(function($value) use ($self, &$contains) {
                    return $contains = $self->contains($value);
                }
        );

        return $contains;
    }

    /**
     * Проверяет, одинаковые ли коллекции.
     *
     * @param  Collection $collection
     * @return boolean
     */
    public function equals(Collection $collection)
    {
        if ($this === $collection) {
            return true;
        }

        $contains = true;

        $this->each(function($value) use ($collection, &$contains) {
                    return $contains = $collection->contains($value);
                }
        );

        return $contains;
    }

    /**
     * Проверяет, пустая ли коллекция.
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return $this->count() > 0;
    }

    /**
     * Удаляет коллекцию из коллекции.
     *
     * @param  Collection $collection
     * @return void
     */
    public function removeCollection(Collection $collection)
    {
        $self = $this;

        $collection->each(function($value) use ($self) {
                    $self->remove($value);
                }
        );
    }

    /**
     * Проверяет, является ли тип значения соответствующим.
     *
     * Проверяет, является ли тип значения соответствующим. Если тип значения
     * не является соответствующим, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  mixed $value
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureValueType($value)
    {
        if (!$this->_valueTypeHelper->is($value)) {
            throw new InvalidArgumentException(
                    'Значение не соответствует типу значений коллекции.'
            );
        }
    }

    /**
     * Проверяет, является ли функция пригодной для вызова.
     *
     * Проверяет, является ли функция пригодной для вызова. Если обработчик не
     * пригоден для вызова, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureCallable($callback)
    {
        if (!is_callable($callback)) {
            throw new InvalidArgumentException(
                    'Обработчик не пригоден для вызова.'
            );
        }
    }

}