<?php

class IndexController extends ViewsController
{

    public function initialize(){
        parent::initialize();

        // redirect all unauthorised users to the login area
        $users = new Users();
        if(!$users->isAuthorised()) $this->redirect('login');
    }

    public function indexAction()
    {
        $countries = new Countries();
        $cities = new Cities();
        $hotels = new Hotels();

        $this->view->setVar('totalCountries', $countries->getCount());
        $this->view->setVar('totalCities', $cities->getCount());
        $this->view->setVar('totalHotels', $hotels->getCount());
    }
}