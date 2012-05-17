<?php
/**
 * Интерфейс очереди объектов.
 * 
 * Данный интерфейс предназначен для описания функциональности очереди объектов.
 * Очередь объектов предназначена для описания структуры данных, когда объекты 
 * добавляются в конец очереди, а забираются с начала очереди. Интерфейс очереди
 * объектов наследует интерфейс Collection.
 * 
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \InvalidArgumentException as InvalidArgumentException;

interface Queue extends Collection
{

    /**
     * Возвращает первый объект в очереди.
     * 
     * Возвращает первый объект в очереди. Если очередь пуста, то будет 
     * возвращено null.
     * 
     * @return mixed 
     */
    public function getFirst();

    /**
     * Удаляет первый объект в очереди и возвращает его.
     * 
     * Удаляет первый объект в очереди и возвращает его. Если очередь пуста, то 
     * будет возвращено null.
     * 
     * @return mixed
     */
    public function removeFirst();

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
    public function addLast($value);
}