<?php
/**
 * Интерфейс обхода коллекции объектов.
 * 
 * Данный интерфейс предоставляет возможность выполнять обход объектов коллекции
 * и применять к каждому объекту пользовательскую функцию.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \InvalidArgumentException as InvalidArgumentException;

interface Iterable
{

    /**
     * Выполняет переданную функцию для каждого объекта коллекции.
     *
     * Выполняет переданную функцию для каждого объекта коллекции. Если функция
     * возвращает false, то дальнейшая обработка прекращается. Если обработчик
     * не пригоден для вызова, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    public function each($callback);
}