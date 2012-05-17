<?php
/**
 * Связанный список объектов.
 *
 * Связанный список объектов предназначен для построения списка объектов с 
 * интерфейсом двунаправленной очереди. Данный класс реализует интерфейс 
 * двунаправленной очереди объектов Deque и наследует функциональность от 
 * ArrayList. Связанный список объектов поддерживает любые типы данных для 
 * значений.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \InvalidArgumentException as InvalidArgumentException;

class LinkedList extends ArrayList implements Deque
{

    /**
     * Добавляет объект в начало очереди.
     *
     * Добавляет объект в начало очереди. Если тип объекта не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     * Если объект добавлен в начало очереди, то будет возвращено true, в
     * противном случае будет возвращено false.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function addFirst($value)
    {
        $this->_ensureValueType($value);

        array_unshift($this->_array, $value);

        return true;
    }

    /**
     * Возвращает последний объект в очереди.
     *
     * Возвращает последний объект в очереди. Если очередь пуста, то будет
     * возвращено null.
     *
     * @return mixed
     */
    public function getLast()
    {
        $count = $this->count();

        if (0 === $count) {
            return null;
        }

        $index = $count - 1;

        if (!array_key_exists($index, $this->_array)) {
            return null;
        }

        return $this->_array[$index];
    }

    /**
     * Удаляет последний объект в очереди и возвращает его.
     *
     * Удаляет последний объект в очереди и возвращает его. Если очередь пуста,
     * то будет возвращено null.
     *
     * @return mixed
     */
    public function removeLast()
    {
        return array_pop($this->_array);
    }

    /**
     * Добавляет объект в конец очереди.
     *
     * Добавляет объект в конец очереди. Если тип объекта не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     * Если объект добавлен в конец очереди, то будет возвращено true, в
     * противном случае будет возвращено false.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function addLast($value)
    {
        $this->_ensureValueType($value);

        array_push($this->_array, $value);

        return true;
    }

    /**
     * Возвращает первый объект в очереди.
     *
     * Возвращает первый объект в очереди. Если очередь пуста, то будет
     * возвращено null.
     *
     * @return mixed
     */
    public function getFirst()
    {
        $index = 0;

        if (!array_key_exists($index, $this->_array)) {
            return null;
        }

        return $this->_array[$index];
    }

    /**
     * Удаляет первый объект в очереди и возвращает его.
     *
     * Удаляет первый объект в очереди и возвращает его. Если очередь пуста, то
     * будет возвращено null.
     *
     * @return mixed
     */
    public function removeFirst()
    {
        return array_shift($this->_array);
    }

}