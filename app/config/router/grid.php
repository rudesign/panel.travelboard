<?php

$group = new \Phalcon\Mvc\Router\Group();

// create a new item
$group->add(
    '/([a-zA-Z0-9]+)/create',
    array(
        'controller' => 1,
        'action' => 'createItem',
    )
)->setName('gridItemCreateForm');

// save new item
$group->add(
    '/([a-zA-Z0-9]+)/create/save',
    array(
        'controller' => 1,
        'action' => 'saveItem',
    )
);

// show grid
$group->add(
    '/([a-zA-Z0-9]+)/show',
    array(
        'controller' => 1,
        'action' => 'showGrid'
    )
);

// show an item
$group->add(
    '/([a-zA-Z0-9]+)/show/([0-9]+)',
    array(
        'controller' => 1,
        'action' => 'showItem',
        'id'     => 2,
    )
)->setName('gridItem');

// edit item
$group->add(
    '/([a-zA-Z0-9]+)/edit/([0-9]+)',
    array(
        'controller' => 1,
        'action' => 'editItem',
        'id'     => 2,
    )
)->setName('gridItemForm');

// update item
$group->add(
    '/([a-zA-Z0-9]+)/edit/([0-9]+)/save',
    array(
        'controller' => 1,
        'action' => 'saveItem',
        'id'     => 2,
    )
);

// delete item
$group->add(
    '/([a-zA-Z0-9]+)/delete/([0-9]+)',
    array(
        'controller' => 1,
        'action' => 'delete',
        'id'     => 2,
    )
);

$router->mount($group);