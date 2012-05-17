<?php
/**
 * Интерфейс коллекции объектов.
 * 
 * Данный интерфейс предназначен для описания базовых функций работы с 
 * множеством объектов. Он наследует интерфейсы Countable и 
 * Iterable, что позволяет получать количество объектов в 
 * коллекции и выполнять обход и применение пользовательской функции для каждого
 * объекта коллекции. Интерфейс коллекции подразумевает, что в коллекции 
 * находятся объекты одного типа.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

use \Countable as Countable;

interface Collection extends Countable, Iterable
{

    /**
     * Возвращает тип значений.
     *
     * Возвращает тип значений. Если тип значений не задан, то будет выброшено
     * исключение UnexpectedValueException.
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getValueType();

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
    public function setValueType($type);

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
    public function contains($value);

    /**
     * Проверяет, содержит ли коллекция переданную коллекцию.
     *
     * @param  Collection $collection
     * @return boolean
     */
    public function containsCollection(Collection $collection);

    /**
     * Проверяет, одинаковые ли коллекции.
     *
     * @param  Collection $collection
     * @return boolean
     */
    public function equals(Collection $collection);

    /**
     * Проверяет, пустая ли коллекция.
     *
     * @return boolean
     */
    public function isEmpty();

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
    public function remove($value);

    /**
     * Удаляет коллекцию из коллекции.
     *
     * @param  Collection $collection
     * @return void
     */
    public function removeCollection(Collection $collection);

    /**
     * Очищает коллекцию.
     *
     * @return void
     */
    public function clear();

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
    public function toArray();
}