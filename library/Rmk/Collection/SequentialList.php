<?php
/**
 * Интерфейс списка объектов.
 * 
 * Данный интерфейс предназначен для описания функциональности списка объектов.
 * Списком объектов является последовательность объектов, где объекты хранятся 
 * под последовательными целочисленными индексами. Кроме общей функциональности 
 * списка объектов, данный интерфейс определяет метод reverseEach() аналогичный 
 * методу Iterable::each() за исключением того, что метод reverseEach() обходит 
 * список в обратном порядке. Интерфейс списка объектов наследует интерфейс 
 * Collection.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

interface SequentialList extends Collection
{

    /**
     * Возвращает значение по индексу.
     *
     * Возвращает значение по индексу. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException. Если
     * индекс будет находиться за пределами списка, то будет выброшено
     * исключение OutOfRangeException.
     *
     * @param  int $index
     * @return mixed
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function get($index);

    /**
     * Возвращает диапазон значений из списка в виде списка.
     *
     * Возвращает диапазон значений из списка в виде списка. Если индексы
     * диапазона не будут являться целыми числами, то будет выброшено исключение
     * InvalidArgumentException. Если индексы будут находиться за пределами
     * списка, то будет выброшено исключение OutOfRangeException.
     *
     * @param  int $indexFrom
     * @param  int $indexTo
     * @return SequentialList
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function getRange($indexFrom, $indexTo);

    /**
     * Добавляет значение по индексу.
     *
     * Добавляет значение по индексу. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException. Если тип
     * значения не является соответствующим, то будет выброшено исключение
     * InvalidArgumentException. Если значение по индексу уже установлено, то
     * его индекс и индексы всех последующих значений будут увеличены на
     * единицу. Если индекс будет находится за пределами списка дальше чем на
     * единицу, то будет выброшено исключение OutOfRangeException. Если значение
     * по индексу будет добавлено, то будет возвращено true, в противном  случае
     * будет возвращено false.
     *
     * @param  int $index
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function add($index, $value);

    /**
     * Добавляет список значений по индексу.
     *
     * Добавляет список значений по индексу. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException. Если тип
     * значений добавляемого списка не является соответствующим, то будет
     * выброшено исключение InvalidArgumentException. Если значение по индексу
     * уже установлено, то его индекс и индексы всех последующих значений будут
     * увеличены на длину добавляемого списка. Если индекс будет находится за
     * пределами списка дальше чем на единицу, то будет выброшено исключение
     * OutOfRangeException. Если список значений по индексу будет добавлен, то
     * будет возвращено true, в противном  случае будет возвращено false.
     *
     * @param  int $index
     * @param  SequentialList $list
     * @return boolean
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function addList($index, SequentialList $list);

    /**
     * Устанавливает значение по индексу.
     *
     * Устанавливает значение по индексу. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException. Если тип
     * значения не является соответствующим, то будет выброшено исключение
     * InvalidArgumentException. Если индекс будет находиться за пределами
     * списка, то будет выброшено исключение OutOfRangeException. Если значение
     * по индексу будет установлено, то будет возвращено true, в противном
     * случае будет возвращено false.
     *
     * @param  int $index
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function set($index, $value);

    /**
     * Склеивает указанный список с собственным.
     *
     * Склеивает указанный список с собственным. Если тип значений склеиваемого
     * списка не является соответствующим, то будет выброшено исключение
     * InvalidArgumentException. Индексы указанного списка сохраняются без
     * изменений. Конкурирующие индексы будут установлены из указанного списка.
     * Если указанный список длиннее списка, то все значения указанного списка 
     * за пределами списка будут добавлены.
     *
     * @param  SequentialList $list
     * @return void
     * @throws InvalidArgumentException
     */
    public function merge(SequentialList $list);

    /**
     * Возвращает индекс по значению.
     *
     * Возвращает индекс по значению. Если индекс указанного значения не найден,
     * то будет возвращено null. Если тип значения не является соответствующим,
     * то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return int
     * @throws InvalidArgumentException
     */
    public function indexOf($value);

    /**
     * Возвращает последний индекс по значению.
     *
     * Возвращает последний индекс по значению. Если индекс указанного значения
     * не найден, то будет возвращено null. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $value
     * @return int
     * @throws InvalidArgumentException
     */
    public function lastIndexOf($value);

    /**
     * Проверяет, содержит ли список индекс.
     *
     * Проверяет, содержит ли список индекс. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  int $index
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function containsIndex($index);

    /**
     * Проверяет, содержит ли список диапазон индексов.
     *
     * Проверяет, содержит ли список диапазон индексов. Если индексы не будут
     * являться целыми числами, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  int $indexFrom
     * @param  int $indexTo
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function containsRange($indexFrom, $indexTo);

    /**
     * Удаляет индекс и значение по нему.
     *
     * Удаляет индекс и значение по нему. Если индекс не будет являться целым
     * числом, то будет выброшено исключение InvalidArgumentException. Если
     * индекс будет находиться за пределами списка, то будет выброшено
     * исключение OutOfRangeException. Если в списке содержались значения с
     * большими индексами, то их индексы будут уменьшены на единицу. Если индекс
     * и значение по нему удалено, то будет возвращено true, в противном случае
     * будет возвращено false.
     *
     * @param  int $index
     * @return boolean
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function removeIndex($index);

    /**
     * Удаляет диапазон индексов и значений по ним.
     *
     * Удаляет диапазон индексов и значений по ним. Если индексы диапазона не
     * будут являться целыми числами, то будет выброшено исключение
     * InvalidArgumentException. Если индексы будут находиться за пределами
     * списка, то будет выброшено исключение OutOfRangeException. Если в списке
     * содержались значения с большими индексами, то их индексы будут уменьшены
     * на единицу. Если диапазон индексов и значений по ним удален, то будет
     * возвращено true, в противном случае будет возвращено false.
     *
     * @param  int $indexFrom
     * @param  int $indexTo
     * @return boolean
     * @throws InvalidArgumentException
     * @throws OutOfRangeException
     */
    public function removeRange($indexFrom, $indexTo);

    /**
     * Выполняет переданную функцию для каждого объекта списка.
     *
     * Выполняет переданную функцию для каждого объекта списка. Обработка списка
     * начинается с конца. Если функция возвращает false, то дальнейшая
     * обработка прекращается. Если обработчик не пригоден для вызова, то будет
     * выброшено исключение InvalidArgumentException.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    public function reverseEach($callback);
}