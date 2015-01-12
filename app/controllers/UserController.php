<?php

use Phalcon\Exception,
    Phalcon\Security;

class UserController extends ViewsController
{
    public function initialize(){
        parent::initialize();
    }

    /**
     * Display signup view
     */
    public function signupAction()
    {
        // Move authorised user to the index page
        $this->redirectAuthorised();

        $this->setTitle('Регистрация');
    }

    /**
     * Check login form & login
     */
    public function doSignupAction()
    {
        // Increase attempts counter
        //$this->session->set('attempts', ($this->session->get('attempts')+1));

        // Get async request helper
        $async = new AsyncRequest();

        if($this->session->get('attempts') < 30){

            // Validate data
            $validation = new SignupValidation();

            $messages = $validation->validate($_POST);

            if (count($messages)) {
                // Get first message
                $messages->rewind();

                $async->setMessage($messages->current()->getMessage());
            }else{
                try {
                    // Get User model
                    $user = new Users();

                    // Change User model data
                    $user->setName($this->request->getPost('name'));
                    $user->setLogin($this->request->getPost('email'));
                    $user->setPassword($this->security->hash($this->request->getPost('password')));

                    // Store
                    if(!$user->signup()) throw new Exception('Ошибка при создании пользователя');

                    // Clean login attempts counter
                    $this->session->remove('attempts');

                    // Move to the login page
                    $async->setLocation($this->url->get('login'));

                }catch (\Exception $e){
                    // Alert message
                    $async->setMessage($e->getMessage());
                }
            }

        }else{
            $async->setLocation();
        }

        $async->submitJSON();
    }

    /**
     * Display login view
     */
    public function loginAction()
    {
        // Move authorised user to the index page
        $this->redirectAuthorised();

        $this->setTitle('Авторизация');
    }

    /**
     * Check login form & login
     */
    public function doLoginAction()
    {
        // Increase login attempts counter
        $this->session->set('attempts', ($this->session->get('attempts')+1));

        // Get async request helper
        $async = new AsyncRequest();

        if($this->session->get('attempts') < 30){
            // Get user model
            $user = new Users();

            // Change user model data
            $user->setLogin($this->request->getPost('email'));
            $user->setPassword($this->request->getPost('password'));

            // Validate data
            $validation = new LoginValidation();

            $messages = $validation->validate($_POST);

            if (count($messages)) {
                $messages->rewind();

                $async->setMessage($messages->current()->getMessage());
            }else{
                try {
                    // Perform login
                    $user->login();

                    // Clean login attempts counter
                    $this->session->remove('attempts');

                    // Move to the index page
                    $async->setLocation();

                }catch (\Exception $e){
                    // Alert message
                    $async->setMessage($e->getMessage());
                }
            }
        }else{
            $async->setLocation();
        }

        $async->submitJSON();
    }

    /**
     * Redirect authorised user to index page
     */
    protected function redirectAuthorised()
    {
        if($this->session->has('sid')) {
            $this->redirect();
        }
    }

    /**
     * Logout
     */
    public function logoutAction()
    {
        $user = new Users();
        $user->logout();
        $this->redirect();
    }
}

