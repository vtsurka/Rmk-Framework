<?php
/**
 * Интерфейс двунаправленной очереди объектов.
 * 
 * Данный интерфейс предназначен для описания функциональности двунаправленной 
 * очереди объектов. Интерфейс двунаправленной очереди объектов наследует 
 * интерфейс очереди объектов Queue и добавляет дополнительную функциональность. 
 * Функциональность двунаправленной очереди объектов подразумевает работу с 
 * очередью с обеих сторон.
 * 
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \InvalidArgumentException as InvalidArgumentException;

interface Deque extends Queue
{

    /**
     * Возвращает последний объект в очереди.
     * 
     * Возвращает последний объект в очереди. Если очередь пуста, то будет 
     * возвращено null.
     * 
     * @return mixed 
     */
    public function getLast();

    /**
     * Удаляет последний объект в очереди и возвращает его.
     * 
     * Удаляет последний объект в очереди и возвращает его. Если очередь пуста, 
     * то будет возвращено null.
     * 
     * @return mixed
     */
    public function removeLast();

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
    public function addFirst($value);
}