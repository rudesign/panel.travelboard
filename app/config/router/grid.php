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

$router->mount($group);