<?php

namespace Rmk\Collection;

use \UnexpectedValueException as UnexpectedValueException;
use \InvalidArgumentException as InvalidArgumentException;
use \OutOfRangeException as OutOfRangeException;
use \stdClass as stdClass;

include '../../bootstrap.php';

$list = new LinkedList('stdClass');

$obj1 = new stdClass();
$obj2 = new stdClass();
$obj3 = new stdClass();

// Добавление объектов в список.
$list->add(0, $obj1);
$list->add(1, $obj2);
$list->add(2, $obj3);

try {
    $list->add(4, $obj1);
} catch (OutOfRangeException $exc) {
    echo 'Индекс находится за пределами списка дальше, чем на единицу.';
}

// Обход списка.
$list->each(function($value, $index, $thisList) {
            /**
             * @TODO: Обработка списка.
             */
        }
);

// Обход списка в обратном порядке.
$list->reverseEach(function($value, $index, $thisList) {
            /**
             * @TODO: Обработка списка.
             */
        }
);

// Удаление из списка.
$list->remove($obj1);
$list->removeIndex(0);
$list->removeFirst();

if ($list->isEmpty()) {
    echo 'Список пуст.';
}
