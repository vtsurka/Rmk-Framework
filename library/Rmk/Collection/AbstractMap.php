<?php
/**
 * Абстрактный класс карты объектов.
 *
 * Абстрактный класс карты объектов предназначен для реализации базовой
 * функциональности карты объектов.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use Rmk\Util;

abstract class AbstractMap extends AbstractCollection implements Map
{

    /**
     * Помощник определения типов ключей.
     *
     * @var Util\Value\Type\Helper
     */
    protected $_keyTypeHelper;

    /**
     * Конструктор.
     *
     * @param  string $valueType
     * @param  string $keyType = 'string'
     * @return void
     */
    public function __construct($valueType, $keyType = 'string')
    {
        parent::__construct($valueType);
        $this->_keyTypeHelper = new Util\Value\Type\Helper($keyType);
    }

    /**
     * Возвращает тип ключей.
     *
     * Возвращает тип ключей. Если тип ключей не задан, то будет выброшено
     * исключение UnexpectedValueException.
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getKeyType()
    {
        return $this->_keyTypeHelper->getType();
    }

    /**
     * Устанавливает тип ключей.
     *
     * Устанавливает тип ключей. При попытке изменить тип ключей у
     * заполненной карты будет выброшено исключение RuntimeException.
     *
     * @param  string $type
     * @return void
     * @throws RuntimeException
     */
    public function setKeyType($type)
    {
        if (!$this->isEmpty()) {
            throw new RuntimeException(
                    'Невозможно изменить тип ключей заполненной коллекции.'
            );
        }

        $this->_keyTypeHelper->setType($type);
    }

    /**
     * Возвращает хэш значения.
     *
     * Возвращает хэш значения. Для хэширования объектов используется встроенная
     * функция spl_object_hash(). Для хэширования строк используется функция
     * md5(). Для хэширования массивов используется сериализация для
     * трансформации в строку, после чего используется функция md5().
     *
     * @param  mixed $value
     * @return string
     */
    public function getHash($value)
    {
        if (is_object($value)) {
            return spl_object_hash($value);
        }

        if (is_string($value)) {
            return md5($value);
        }

        if (is_array($value)) {
            $value = serialize($value);
        }

        return md5($value);
    }

    /**
     * Склеивает указанную карту с собственной.
     *
     * @param  Map $map
     * @return void
     */
    public function merge(Map $map)
    {
        $self = $this;

        $map->each(function($value, $key) use ($self, &$result) {
                    $self->set($key, $value);
                }
        );
    }

    /**
     * Проверяет, является ли тип ключа соответствующим.
     *
     * Проверяет, является ли тип ключа соответствующим. Если тип ключа не
     * является соответствующим, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  mixed $key
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureKeyType($key)
    {
        if (!$this->_keyTypeHelper->is($key)) {
            throw new InvalidArgumentException(
                    'Ключ не соответствует типу ключей коллекции.'
            );
        }
    }

}