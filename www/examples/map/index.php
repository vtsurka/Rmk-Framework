<?php
namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;

include '../../bootstrap.php';

$map = new HashMap('stdClass', 'string');

$obj1 = new \stdClass();
$obj2 = new \stdClass();
$obj3 = new \stdClass();

// Установка ассоциаций ключ / значение.
$map->set('k1', $obj1);
$map->set('k2', $obj2);
$map->set('k3', $obj3);

// Обход карты.
$map->each(function($value, $key, $thisMap) {
            /**
             * @TODO: Обработка карты.
             */
        }
);

// Удаление по значению.
$map->remove($obj1);
$map->remove($obj2);

// Удаление по ключу.
$map->removeKey('k3');

if ($map->isEmpty()) {
    /**
     * @TODO: Что делать, если карта пуста? 
     */
}

// Преобразование в массив.
$array = $map->toArray();

// Внимание! Невозможно преобразовать в массив карту, у которой ключами 
// являются объекты.
$objectMap = new HashMap('stdClass', 'stdClass');

try {
    $objectArray = $objectMap->toArray();
} catch (UnexpectedValueException $exc) {
    echo 'Объекты не могут являться ключами массива.';
}
