<?php
/**
 * Интерфейс набора объектов.
 * 
 * Данный интерфейс предназначен для описания функциональности набора объектов, 
 * где объекты являются уникальными в рамках коллекции. Уникальность объектов 
 * осуществляется с помощью метода getIdentity(). Интерфейс набора объектов 
 * наследует интерфейс Collection.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \InvalidArgumentException as InvalidArgumentException;

interface Set extends Collection
{

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
    public function add($value);

    /**
     * Возвращает идентификатор значения.
     *
     * @param  mixed $value
     * @return string
     */
    public function getIdentity($value);
}