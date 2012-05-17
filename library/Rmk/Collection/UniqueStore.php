<?php
/**
 * Хранилище уникальных объектов.
 *
 * Хранилище уникальных объектов предназначено для работы с набором уникальных
 * объектов. Внутренняя структура хранилища уникальных объектов построена на
 * основе ассоциативных связей между объектами и их идентификаторами. Хранилище
 * уникальных объектов поддерживает любые типы данных для значений.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;
use \InvalidArgumentException as InvalidArgumentException;

class UniqueStore extends AbstractCollection implements Set
{

    /**
     * Хранилище объектов.
     *
     * @var array
     */
    private $_store = array();

    /**
     * Возвращает идентификатор значения.
     *
     * Возвращает идентификатор значения. Для идентификации объектов 
     * используется встроенная функция spl_object_hash(). Для идентификации 
     * строк используется функция md5(). Для идентификации массивов используется
     * сериализация для трансформации в строку, после чего используется функция 
     * md5().
     * 
     * @param  mixed $value
     * @return string
     */
    public function getIdentity($value)
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
     * Возвращает количество объектов в коллекции.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_store);
    }

    /**
     * Очищает коллекцию.
     *
     * @return void
     */
    public function clear()
    {
        $this->_store = array();
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

        $id = $this->getIdentity($value);

        return !empty($this->_store[$id]);
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

        $id = $this->getIdentity($value);

        if (empty($this->_store[$id])) {
            return false;
        }

        unset($this->_store[$id]);

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
        return array_values($this->_store);
    }

    /**
     * Выполняет переданную функцию для каждого объекта коллекции.
     *
     * Выполняет переданную функцию для каждого объекта коллекции. Если функция
     * возвращает false, то дальнейшая обработка прекращается. Если обработчик
     * не пригоден для вызова, то будет выброшено исключение
     * InvalidArgumentException. Функция обработки принимает 2 параметра:
     * значение и коллекцию, обработка которой выполняется.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    public function each($callback)
    {
        $this->_ensureCallable($callback);

        foreach ($this->_store as $value) {
            $result = call_user_func_array($callback, array($value, $this));

            if (false === $result) {
                break;
            }
        }
    }

    /**
     * Добавляет значение.
     *
     * Добавляет значение. Если тип значения не является соответствующим, то
     * будет выброшено исключение InvalidArgumentException. Если значение
     * добавлено, то будет возвращено true, в противном случае будет возвращено
     * false.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function add($value)
    {
        $this->_ensureValueType($value);

        $id = $this->getIdentity($value);

        if (!empty($this->_store[$id])) {
            return false;
        }

        $this->_store[$id] = $value;

        return true;
    }

}