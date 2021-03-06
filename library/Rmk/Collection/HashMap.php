<?php
/**
 * Хэшированная карта объектов.
 *
 * Хэшированная карта объектов предназначена для построения ассоциативных
 * связей между объектами, где один из объектов является ключем, а другой
 * значением. Ключи хэшированной карты объектов являются уникальными. Значения
 * хэшированной карты объектов не являются уникальными, что позволяет 
 * ассоциировать одно значение с несколькими ключами. Внутренняя структура
 * хэшированной карты объектов построена на основе сети ассоциативных связей.
 * Хэшированная карта объектов поддерживает любые типы данных для ключей и
 * значений.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;
use \InvalidArgumentException as InvalidArgumentException;

class HashMap extends AbstractMap
{

    /**
     * Ключи.
     *
     * @var array
     */
    private $_keys = array();

    /**
     * Значения.
     *
     * @var array
     */
    private $_values = array();

    /**
     * Ассоциации значений с ключами.
     *
     * @var array
     */
    private $_valuesToKeys = array();

    /**
     * Ассоциации ключей со значениями.
     *
     * @var array
     */
    private $_keysToValues = array();

    /**
     * Ассоциации значений и ключей к индексам.
     *
     * @var array
     */
    private $_valuesKeysToIndexes = array();

    /**
     * Возвращает количество объектов в коллекции.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_keys);
    }

    /**
     * Очищает коллекцию.
     *
     * @return void
     */
    public function clear()
    {
        $this->_keys = array();
        $this->_keysToValues = array();
        $this->_values = array();
        $this->_valuesToKeys = array();
        $this->_valuesKeysToIndexes = array();
    }

    /**
     * Проверяет, содержит ли коллекция значение.
     *
     * Проверяет, содержит ли коллекция значение. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function contains($value)
    {
        $this->_ensureValueType($value);

        $valueHash = $this->getHash($value);

        return !empty($this->_valuesKeysToIndexes[$valueHash]);
    }

    /**
     * Проверяет, содержит ли карта ключ.
     *
     * Проверяет, содержит ли карта ключ. Если тип ключа не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $key
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function containsKey($key)
    {
        $this->_ensureKeyType($key);

        $keyHash = $this->getHash($key);

        return !empty($this->_keys[$keyHash]);
    }

    /**
     * Удаляет значение из коллекции.
     *
     * Удаляет значение из коллекции. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     * Если значение удалено, то будет возвращено true, в противном случае
     * будет возвращено false.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function remove($value)
    {
        $this->_ensureValueType($value);

        $valueHash = $this->getHash($value);
        $keyHashes = array_keys($this->_valuesKeysToIndexes[$valueHash]);

        if (empty($keyHashes)) {
            return false;
        }

        $keyHash    = array_pop($keyHashes);
        $valueIndex = $this->_keysToValues[$keyHash];

        unset($this->_values[$valueIndex]);
        unset($this->_valuesToKeys[$valueIndex]);
        unset($this->_keys[$keyHash]);
        unset($this->_keysToValues[$keyHash]);
        unset($this->_valuesKeysToIndexes[$valueHash][$keyHash]);
        if (empty($this->_valuesKeysToIndexes[$valueHash])) {
            unset($this->_valuesKeysToIndexes[$valueHash]);
        }

        return true;
    }

    /**
     * Удаляет ключ и значение по нему.
     *
     * Удаляет ключ и значение по нему. Если тип ключа не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     * Если ключ и значение по нему удалено, то будет возвращено true, в
     * противном случае будет возвращено false.
     *
     * @param  mixed $key
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function removeKey($key)
    {
        $this->_ensureKeyType($key);

        $keyHash = $this->getHash($key);

        if (empty($this->_keys[$keyHash])) {
            return false;
        }

        $valueIndex = $this->_keysToValues[$keyHash];
        $valueHash  = $this->getHash($this->_values[$valueIndex]);

        unset($this->_keys[$keyHash]);
        unset($this->_keysToValues[$keyHash]);
        unset($this->_values[$valueIndex]);
        unset($this->_valuesToKeys[$valueIndex]);
        unset($this->_valuesKeysToIndexes[$valueHash][$keyHash]);
        if (empty($this->_valuesKeysToIndexes[$valueHash])) {
            unset($this->_valuesKeysToIndexes[$valueHash]);
        }

        return true;
    }

    /**
     * Преобразовывает коллекцию в массив.
     *
     * Преобразовывает коллекцию в массив. Если коллекция не может быть
     * преобразована в массив, то будет выброшено исключение
     * UnexpectedValueException.
     *
     * @return array
     * @throws UnexpectedValueException
     */
    public function toArray()
    {
        if (!$this->_keyTypeHelper->isSimpleType()) {
            throw new UnexpectedValueException(
                    'Невозможно создать массив с ключами не простых типов.'
            );
        }

        if ($this->isEmpty()) {
            return array();
        }

        return array_combine($this->_keys, $this->_values);
    }

    /**
     * Выполняет переданную функцию для каждого объекта коллекции.
     *
     * Выполняет переданную функцию для каждого объекта коллекции. Если функция
     * возвращает false, то дальнейшая обработка прекращается. Если обработчик
     * не пригоден для вызова, то будет выброшено исключение
     * InvalidArgumentException. Функция обработки принимает 3 параметра:
     * значение, соответствующий ему ключ и коллекцию, обработка которой
     * выполняется.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    public function each($callback)
    {
        $this->_ensureCallable($callback);

        foreach ($this->_values as $index => $value) {
            $keyHash = $this->_valuesToKeys[$index];
            $key     = $this->_keys[$keyHash];
            $result  = call_user_func_array(
                    $callback, array($value, $key, $this)
            );

            if (false === $result) {
                break;
            }
        }
    }

    /**
     * Возвращает значение по ключу.
     *
     * Возвращает значение по ключу. Если ключ не найден, то будет возвращено
     * null. Если тип ключа не является соответствующим, то будет выброшено
     * исключение InvalidArgumentException.
     *
     * @param  mixed $key
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get($key)
    {
        $this->_ensureKeyType($key);

        $keyHash = $this->getHash($key);

        if (empty($this->_keys[$keyHash])) {
            return null;
        }

        $valueIndex = $this->_keysToValues[$keyHash];

        return $this->_values[$valueIndex];
    }

    /**
     * Возращает ключ по значению.
     *
     * Возращает ключ по значению. Если ключ для указанного значения не найден,
     * то будет возвращено null. Если тип значения не является соответствующим,
     * то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function keyOf($value)
    {
        $this->_ensureValueType($value);

        $valueHash = $this->getHash($value);

        $keyHashes = array_keys($this->_valuesKeysToIndexes[$valueHash]);

        if (empty($keyHashes)) {
            return null;
        }

        $keyHash = $keyHashes[0];

        return $this->_keys[$keyHash];
    }

    /**
     * Возвращает последний ключ по значению.
     *
     * Возвращает последний ключ по значению. Если ключ для указанного значения
     * не найден, то будет возвращено null. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function lastKeyOf($value)
    {
        $this->_ensureValueType($value);

        $valueHash = $this->getHash($value);

        $keyHashes = array_keys($this->_valuesKeysToIndexes[$valueHash]);

        if (empty($keyHashes)) {
            return null;
        }

        $keyHash = array_pop($keyHashes);

        return $this->_keys[$keyHash];
    }

    /**
     * Устанавливает значение по ключу.
     *
     * Устанавливает значение по ключу. Если ключ не подходит по типу или
     * значение не подходит по типу, то будет выброшено исключение
     * InvalidArgumentException. Если ключ и значение установлено, то будет
     * возращено true, в противном случае будет возвращено false.
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function set($key, $value)
    {
        $this->_ensureKeyType($key);
        $this->_ensureValueType($value);

        $keyHash   = $this->getHash($key);
        $valueHash = $this->getHash($value);

        if (!empty($this->_keys[$keyHash])) {
            $valueIndex   = $this->_keysToValues[$keyHash];
            $valueHashOld = $this->getHash($this->_values[$valueIndex]);
            $this->_values[$valueIndex] = $value;
            unset($this->_valuesKeysToIndexes[$valueHashOld][$keyHash]);
            $this->_valuesKeysToIndexes[$valueHash][$keyHash] = $valueIndex;
        } else {
            $valueIndex = array_push($this->_values, $value) - 1;
            $this->_keys[$keyHash] = $key;
            $this->_valuesToKeys[$valueIndex] = $keyHash;
            $this->_keysToValues[$keyHash] = $valueIndex;
            $this->_valuesKeysToIndexes[$valueHash][$keyHash] = $valueIndex;
        }

        return true;
    }

}