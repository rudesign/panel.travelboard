<?php

$group = new \Phalcon\Mvc\Router\Group(array(
    'controller' => 'countries'
));

// Grid
$group->add(
    '/countries',
    array(
        'action' => 'showGrid'
    )
)->setName('countries');

// Item
$group->add(
    '/countries/:int',
    array(
        'action' => 'showItem',
        'id'     => 1,
    )
)->setName("countriesItem");

$router->mount($group);