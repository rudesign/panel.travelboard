<?php

class ViewsController extends BaseController
{
    // Notify message data
    public $notify = array(array('message', 'type'));

    // Document meta tags content
    public $metaTags = array(array('description', 'keywords'));

    public function initialize()
    {
        parent::initialize();

        // CSS in <head>
        $this->assets
            ->collection('cssBefore')

            ->addCss('css/font-awesome-4.2.0/css/font-awesome.min.css')
            ->addCss('css/ohsnap.css')
            ->addCss('css/style.css');

        // CSS at the end of <body>
        $this->assets
            ->collection('cssAfter');

            //->setPrefix('')

        // Javascript in <head>
        $this->assets
            ->collection('jsBefore')
            //->setPrefix('')

            ->addJs('js/jquery-1.11.1.min.js');

        // Javascript at the end of <body>
        $this->assets
            ->collection('jsAfter')
            //->setPrefix('')

            ->addJs('js/jquery.form.min.js')
            ->addJs('js/jquery.easing.1.3.min.js')
            ->addJs('js/jquery.cookie.js')
            ->addJs('js/respond.min.js')
            ->addJs('js/ohsnap.js')
            ->addJs('js/scripts.js');
    }

    protected function notify($message = '', $type = 'common')
    {
        $this->notify['message'] = $message;
        $this->notify['type'] = $type;
    }

    protected function setTitle($content = '')
    {
        $this->tag->setTitle($content);
    }

    protected function setMetaDescription($content = '')
    {
        $this->metaTags['description'] = $content;
    }

    protected function setMetaKeywords($content = '')
    {
        $this->metaTags['keywords'] = $content;
    }

    public function redirect($url = null){
        $this->response->redirect($this->url->get($url), true);
        $this->view->disable();
    }

    protected function afterExecuteRoute($dispatcher)
    {
        $this->view->setVar('notify', $this->notify);
        $this->view->setVar('metaTags', $this->metaTags);
        $this->view->setVar('pathSegments', $this->router->getPathSegments());
    }

    protected function e404(){
        $this->dispatcher->forward(
            array(
                'controller' => 'error',
                'action'     => 'e404',
            )
        );
    }
}