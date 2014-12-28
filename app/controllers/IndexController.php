<?php

class IndexController extends ViewsController
{
    public function indexAction()
    {
        $this->view->setVar('totalCountries', 9001);
        $this->view->setVar('totalCities', 9002);
        $this->view->setVar('totalHotels', 9003);
    }
}