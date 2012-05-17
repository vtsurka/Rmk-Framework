<?php
/**
 * Список объектов.
 * 
 * Список объектов предназначен для построения списка объектов, где объекты 
 * хранятся под последовательными целочисленными индексами. Данный класс 
 * реализует интерфейс списка объектов SequentialList и наследует часть 
 * функциональности от AbstractCollection. Список объектов поддерживает 
 * последовательный порядок индексов при изменении своей структуры. Список 
 * объектов поддерживает любые типы данных для значений.
 *
 * @category Rmk
 * @package  Rmk_Collection
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Collection;

class ArrayList extends AbstractCollection implements SequentialList
{

    /**
     * Массив списка.
     *
     * @var array
     */
    protected $_array = array();

    /**
     * Возвращает количество объектов в коллекции.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_array);
    }

    /**
     * Очищает коллекцию.
     *
     * @return void
     */
    public function clear()
    {
        $this->_array = array();
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

        return in_array($value, $this->_array, true);
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
        return $this->_array;
    }

    /**
     * Удаляет значение из коллекции.
     *
     * Удаляет значение из коллекции. Если тип значения не является
     * соответствующим, то будет выброшено исключение InvalidArgumentException.
     * Если значение удалено, то будет возвращено true, в противном случае
     * будет возвращено false. Если в списке содержались значения с большими
     * индексами, то их индексы будут уменьшены на единицу.
     *
     * @param  mixed $value
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function remove($value)
    {
        $this->_ensureValueType($value);

        $index = array_search($value, $this->_array, true);

        if (false === $index) {
            return false;
        }

        unset($this->_array[$index]);
        $this->_array = array_values($this->_array);

        return true;
    }

    /**
     * Выполняет переданную функцию для каждого объекта коллекции.
     *
     * Выполняет переданную функцию для каждого объекта коллекции. Если функция
     * возвращает false, то дальнейшая обработка прекращается. Если обработчик
     * не пригоден для вызова, то будет выброшено исключение
     * InvalidArgumentException. Функция обработки принимает 3 параметра:
     * значение, соответствующий ему индекс и коллекцию, обработка которой
     * выполняется.
     *
     * @param  callback $callback
     * @return void
     * @throws InvalidArgumentException
     */
    public function each($callback)
    {
        $this->_ensureCallable($callback);

        foreach ($this->_array as $index => $value) {
            $result = call_user_func_array($callback,
                                           array($value, $index, $this));

            if (false === $result) {
                break;
            }
        }
    }

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
    public function add($index, $value)
    {
        $count = $this->count();

        $this->_ensureIndex($index);
        $this->_ensureIndexRange($index, 0, $count);
        $this->_ensureValueType($value);

        if (0 === $index) {
            array_unshift($this->_array, $value);
        } elseif ($count === $index) {
            array_push($this->_array, $value);
        } else {
            $offset = array_slice($this->_array, $index);
            array_unshift($offset, $value);
            array_splice($this->_array, $index, $count, $offset);
        }

        return true;
    }

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
    public function addList($index, SequentialList $list)
    {
        $count = $this->count();

        $this->_ensureIndex($index);
        $this->_ensureIndexRange($index, 0, $count);
        $this->_ensureListType($list);


        $listArray = $list->toArray();
        $listCount = count($listArray);

        if (0 === $index) {
            for ($i = $listCount - 1; $i >= 0; $i--) {
                array_unshift($this->_array, $listArray[$i]);
            }
        } elseif ($count === $index) {
            for ($i = 0; $i < $listCount; $i++) {
                array_push($this->_array, $listArray[$i]);
            }
        } else {
            $offset = array_slice($this->_array, $index);

            for ($i = $listCount - 1; $i >= 0; $i--) {
                array_unshift($offset, $listArray[$i]);
            }
            array_splice($this->_array, $index, $count, $offset);
        }

        return true;
    }

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
    public function containsIndex($index)
    {
        $this->_ensureIndex($index);

        return array_key_exists($index, $this->_array);
    }

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
    public function containsRange($indexFrom, $indexTo)
    {
        $this->_ensureIndex($indexFrom);
        $this->_ensureIndex($indexTo);

        return array_key_exists($indexTo, $this->_array);
    }

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
    public function get($index)
    {
        $this->_ensureIndex($index);
        $this->_ensureIndexRange($index, 0, $this->count() - 1);

        return $this->_array[$index];
    }

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
    public function getRange($indexFrom, $indexTo)
    {
        $this->_ensureIndex($indexFrom);
        $this->_ensureIndex($indexTo);
        $this->_ensureIndexRange($indexFrom, 0, $this->count() - 1);
        $this->_ensureIndexRange($indexTo, 0, $this->count() - 1);

        $range = array_slice($this->_array, $indexFrom,
                             $indexTo - $indexFrom + 1);

        $list = new self($this->getValueType());

        $list->_array = array_merge($list->_array, $range);

        return $list;
    }

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
    public function indexOf($value)
    {
        $this->_ensureValueType($value);

        $index = array_search($value, $this->_array, true);

        if (false === $index) {
            return null;
        }

        return $index;
    }

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
    public function lastIndexOf($value)
    {
        $this->_ensureValueType($value);

        $indexes = array_keys($this->_array, $value, true);

        if (empty($indexes)) {
            return null;
        }

        return array_pop($indexes);
    }

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
    public function merge(SequentialList $list)
    {
        $this->_ensureListType($list);

        $listArray = $list->toArray();

        $this->_array = array_replace($this->_array, $listArray);
    }

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
    public function removeIndex($index)
    {
        $this->_ensureIndex($index);
        $this->_ensureIndexRange($index, 0, $this->count() - 1);

        unset($this->_array[$index]);
        $this->_array = array_values($this->_array);

        return true;
    }

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
    public function removeRange($indexFrom, $indexTo)
    {
        $this->_ensureIndex($indexFrom);
        $this->_ensureIndex($indexTo);
        $this->_ensureIndexRange($indexFrom, 0, $this->count() - 1);
        $this->_ensureIndexRange($indexTo, 0, $this->count() - 1);

        for ($i = $indexFrom; $i <= $indexTo; $i++) {
            unset($this->_array[$i]);
        }

        $this->_array = array_values($this->_array);

        return true;
    }

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
    public function reverseEach($callback)
    {
        $this->_ensureCallable($callback);

        for ($i = $this->count() - 1; $i >= 0; $i--) {
            $result = call_user_func_array($callback,
                                           array($this->_array[$i], $i, $this));
            if (false === $result) {
                break;
            }
        }
    }

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
    public function set($index, $value)
    {
        $this->_ensureIndex($index);
        $this->_ensureIndexRange($index, 0, $this->count() - 1);
        $this->_ensureValueType($value);

        $this->_array[$index] = $value;

        return true;
    }

    /**
     * Проверяет, является ли индекс целым числом.
     *
     * Проверяет, является ли индекс целым числом. Если индекс не будет являться
     * целым числом, то будет выброшено исключение InvalidArgumentException.
     *
     * @param  mixed $index
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureIndex($index)
    {
        if (!is_int($index)) {
            throw new InvalidArgumentException(
                    'Индекс не является целым числом.'
            );
        }
    }

    /**
     * Проверяет, входит ли индекс в диапазон.
     *
     * Проверяет, входит ли индекс в диапазон. Если индекс будет находится за
     * пределами диапазона, то будет выброшено исключение OutOfRangeException.
     *
     * @param  int $index
     * @param  int $indexFrom
     * @param  int $indexTo
     * @return void
     * @throws OutOfRangeException
     */
    protected function _ensureIndexRange($index, $indexFrom, $indexTo)
    {
        if ($index < $indexFrom || $index > $indexTo) {
            throw new OutOfRangeException(
                    "Индекс {$index} находится за пределами диапазона " .
                    "[{$indexFrom}, {$indexTo}]."
            );
        }
    }

    /**
     * Проверяет соответствие типов указанного и собственного списков.
     *
     * Проверяет соответствие типов указанного и собственного списков. Если типы
     * списков не соответствуют, то будет выброшено исключение
     * InvalidArgumentException.
     *
     * @param  SequentialList $list
     * @return void
     * @throws InvalidArgumentException
     */
    protected function _ensureListType(SequentialList $list)
    {
        if ($this->getValueType() !== $list->getValueType()) {
            throw new InvalidArgumentException(
                    'Типы списков не соответствуют.'
            );
        }
    }

}