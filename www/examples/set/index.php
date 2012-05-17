<?php

namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;
use \InvalidArgumentException as InvalidArgumentException;
use \stdClass as stdClass;

include '../../bootstrap.php';

$set = new UniqueStore('stdClass');

$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = new stdClass();

// Добавление объектов в хранилище.
$set->add($obj1);
$set->add($obj2);
$set->add($obj3);

// Повторно объекты в хранилище добавлены не будут.
$set->add($obj3);

try {
    $set->add(new UnexpectedValueException);
} catch (InvalidArgumentException $exc) {
    echo 'Значение не подходит по типу.';
}

// Обход хранилища.
$set->each(function($value, $thisSet) {
            /**
             * @TODO: Обработка хранилища.
             */
        }
);

// Удаление объектов из хранилища.
$set->remove($obj1);
$set->remove($obj2);
$set->remove($obj3);

// Преобразование в массив.
$array = $set->toArray();