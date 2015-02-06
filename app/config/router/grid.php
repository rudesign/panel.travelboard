<?php

$group = new \Phalcon\Mvc\Router\Group();

// Grid
$group->add(
    '/show/:controller',
    array(
        'controller' => 1,
        'action' => 'showGrid'
    )
);

// Item
$group->add(
    '/create/:controller',
    array(
        'controller' => 1,
        'action' => 'createItem',
    )
);
$group->add(
    '/create/:controller/save',
    array(
        'controller' => 1,
        'action' => 'saveItem',
    )
);

$group->add(
    '/show/:controller/:int',
    array(
        'controller' => 1,
        'action' => 'showItem',
        'id'     => 2,
    )
)->setName('gridItem');

$group->add(
    '/edit/:controller/:int',
    array(
        'controller' => 1,
        'action' => 'editItem',
        'id'     => 2,
    )
)->setName('gridItemForm');

$group->add(
    '/edit/:controller/:int/save',
    array(
        'controller' => 1,
        'action' => 'saveItem',
        'id'     => 2,
    )
);

$router->mount($group);