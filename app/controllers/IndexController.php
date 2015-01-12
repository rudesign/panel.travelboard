<?php

class IndexController extends ViewsController
{
    public function indexAction()
    {
        $users = new Users();

        if(!$users->isAuthorised()) {
            $this->redirect('login');
        }

        $countries = new Countries();
        $cities = new Cities();
        $hotels = new Hotels();

        $this->view->setVar('totalCountries', $countries->getCount());
        $this->view->setVar('totalCities', $cities->getCount());
        $this->view->setVar('totalHotels', $hotels->getCount());
    }
}