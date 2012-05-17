<?php
/**
 * @category Rmk
 * @package  Rmk_Util
 * @author   Roman rmk Mogilatov rmogilatov@gmail.com
 */

namespace Rmk\Util\Value\Type;

class Helper
{

    /**
     * Тип.
     *
     * @var string
     */
    private $_type;

    /**
     * Имя класса исключения.
     * 
     * @var string
     */
    private $_exceptionClass = 'InvalidArgumentException';

    /**
     * Текст сообщения исключения.
     * 
     * @var string
     */
    private $_exceptionMessage = 'Значение не подходит по типу.';

    /**
     * Код исключения.
     * 
     * @var int
     */
    private $_exceptionCode = 0;

    /**
     * Простые типы.
     *
     * @var array
     */
    private $_simpleTypes = array(
        'int'      => 'is_int',
        'float'    => 'is_float',
        'string'   => 'is_string',
        'boolean'  => 'is_bool',
        'array'    => 'is_array',
        'callable' => 'is_callable',
        'null'     => 'is_null'
    );

    /**
     * Флаг простого типа.
     *
     * @var boolean
     */
    private $_isSimpleType = false;

    /**
     * Функция проверки простого типа.
     *
     * @var callback
     */
    private $_simpleTypeFunction;

    /**
     * Конструктор.
     *
     * @param  string $type
     * @return void
     */
    public function __construct($type = null)
    {
        if (null !== $type) {
            $this->setType($type);
        }
    }

    /**
     * Возвращает класс исключения.
     * 
     * @return string
     */
    public function getExceptionClass()
    {
        return $this->_exceptionClass;
    }

    /**
     * Устанавливает класс исключения.
     * 
     * @param  string $exceptionClass
     * @return Helper 
     */
    public function setExceptionClass($exceptionClass)
    {
        $this->_exceptionClass = $exceptionClass;

        return $this;
    }

    /**
     * Возвращает текст сообщения исключения.
     * 
     * @return string
     */
    public function getExceptionMessage()
    {
        return $this->_exceptionMessage;
    }

    /**
     * Устанавливает текст сообщения исключения.
     *
     * @param  string $exceptionMessage
     * @return Helper 
     */
    public function setExceptionMessage($exceptionMessage)
    {
        $this->_exceptionMessage = $exceptionMessage;

        return $this;
    }

    /**
     * Возвращает код исключения.
     * 
     * @return int
     */
    public function getExceptionCode()
    {
        return $this->_exceptionCode;
    }

    /**
     * Устанавливает код исключения.
     *
     * @param  int $exceptionCode
     * @return Helper 
     */
    public function setExceptionCode($exceptionCode)
    {
        $this->_exceptionCode = $exceptionCode;

        return $this;
    }

    /**
     * Возвращает тип.
     *
     * Возвращает тип. Если тип не задан, то будет выброшено исключение
     * UnexpectedValueException.
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function getType()
    {
        if (null === $this->_type) {
            throw new UnexpectedValueException(
                    'Тип не задан.'
            );
        }

        return $this->_type;
    }

    /**
     * Устанавливает тип.
     *
     * @param  string $type
     * @return Helper
     */
    public function setType($type)
    {
        $this->_type = $type;

        $this->_isSimpleType = null;
        $this->_simpleTypeFunction = null;

        return $this;
    }

    /**
     * Проверяет, является ли значение простым.
     *
     * @param  string $type
     * @return boolean
     */
    public function isSimpleType()
    {
        if (null !== $this->_isSimpleType) {
            return $this->_isSimpleType;
        }

        if (array_key_exists($this->_type, $this->_simpleTypes)) {
            $this->_isSimpleType = true;
            $this->_simpleTypeFunction = $this->_simpleTypes[$this->_type];
        } else {
            $this->_isSimpleType = false;
        }

        return $this->_isSimpleType;
    }

    /**
     * Проверяет, является ли значение подходящим типом.
     *
     * @param  mixed $value
     * @return boolean
     */
    public function is($value)
    {
        if ($this->isSimpleType()) {
            return call_user_func($this->_simpleTypeFunction, $value);
        }

        $type = $this->getType();

        return $value instanceof $type;
    }

    /**
     * Проверяет, является ли значение подходящим по типу.
     * 
     * Проверяет, является ли значение подходящим по типу. Если значение не 
     * подходит по типу, то будет выброшено исключение <ExceptionClass> с 
     * сообщением <ExceptionMessage> и кодом <ExceptionCode.>
     * 
     * @param  mixed $value
     * @return void
     * @throws <ExceptionClass>
     */
    public function ensure($value)
    {
        if (!$this->is($value)) {
            throw new $this->_exceptionClass(
                    $this->_exceptionMessage, $this->_exceptionCode
            );
        }
    }

}