<?php
/**
 * Интерфейс карты объектов.
 *
 * Данный интерфейс предназначен для описания функциональности карты объектов.
 * Карта объектов предназначена для построения ассоциативных связей между
 * объектами, где один из объектов является ключем, а другой значением.
 * Интерфейс карты объектов подразумевает, что в карте находятся ключи одного
 * типа. Интерфейс карты объектов подразумевает, что в карте находятся значения
 * одного типа. Интерфейс карты объектов наследует интерфейс
 * Collection.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;
use \InvalidArgumentException as InvalidArgumentException;
use \RuntimeException as RuntimeException;

interface Map extends Collection
{

    /**
     * Возвращает тип ключей.
     *
     * Возвращает тип ключей. Если тип ключей не задан, то будет выброшено
     * исключение UnexpectedValueException.
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getKeyType();

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
    public function setKeyType($type);

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
    public function containsKey($key);

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
    public function get($key);

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
    public function set($key, $value);

    /**
     * Возвращает ключ по значению.
     *
     * Возвращает ключ по значению. Если ключ для указанного значения не найден,
     * то будет возвращено null. Если тип значения не является соответствующим,
     * то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function keyOf($value);

    /**
     * Возращает последний ключ по значению.
     *
     * Возвращает последний ключ по значению. Если ключ для указанного значения
     * не найден, то будет возвращено null. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function lastKeyOf($value);

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
    public function removeKey($key);

    /**
     * Возвращает хэш значения.
     *
     * @param  mixed $value
     * @return string
     */
    public function getHash($value);

    /**
     * Склеивает указанную карту с собственной.
     *
     * @param  Map $map
     * @return void
     */
    public function merge(Map $map);
}