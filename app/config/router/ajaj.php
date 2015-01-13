<?php

$group = new \Phalcon\Mvc\Router\Group();

// Grid
$group->add(
    '/ajaj/:controller/:action',
    array(
        'controller' => 1,
        'action' => 2
    )
);

$router->mount($group);