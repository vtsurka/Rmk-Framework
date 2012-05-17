<?php

namespace Rmk\Collection;

include '../../bootstrap.php';

$map = new HashMap('stdClass', 'string');

$obj1 = new \stdClass();
$obj2 = new \stdClass();
$obj3 = new \stdClass();

$map->set('k1', $obj1);
$map->set('k2', $obj2);
$map->set('k3', $obj3);

$map->each(function($value, $key, $thisMap) {
            /**
             * @TODO: Обработка карты.
             */
        }
);

$map->remove($obj1);
$map->remove($obj2);
var_dump($map);exit;
$map->removeKey('k3');

if ($map->isEmpty()) {
    /**
     * @TODO: Что делать, если карта пуста? 
     */
}

try {
    $array = $map->toArray();
} catch (UnexpectedValueException $e) {
    //
}

var_dump($map);
