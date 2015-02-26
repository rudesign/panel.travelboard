<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;

class UsersController extends ViewsController
{
    public function initialize(){
        parent::initialize();

        // redirect all unauthorised users to the login area
        $users = new Users();
        if(!$users->isAuthorised()) $this->redirect('login');
    }


    public function showGridAction()
    {
        //$this->notify('Another message here');

        $builder = $this->modelsManager->createBuilder()
            ->from('Users')
            ->orderBy('id DESC');

        if($query = $this->request->get('q')){
            $builder->where("name LIKE '%{$query}%' OR login LIKE '%{$query}%'");
        }

        $paginator = new PAdapter(
            array(
                "builder" => $builder,
                "limit"=> 20,
                "page" => $this->request->get('page')
            )
        );

//        echo $builder->getPhql();
//        die;

        $grid = $paginator->getPaginate();

        $this->view->setVar('grid', $grid);
    }

    public function createItemAction()
    {
        try{
            $model = new Users();

            $this->view->setVar('row', $model);

            $this->view->pick("users/editItem");

        } catch (\Exception $e){
            $this->e404();
        }
    }


    public function showItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Users();

            $row = $model->query()->where('id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getName());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function editItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Users();

            $row = $model->query()->where('id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getName());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function saveItemAction($id = 0)
    {
        $async = new AsyncRequest();

        try{
            $model = new Users();

            if(!empty($id)) {
                if (!$row = $model->query()->where('id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');
            }else $row = $model;

            // Validate if update
            if(!empty($id)) {

                $validation = new UserValidation();
                $messages = $validation->validate($_POST);
                if($message = $validation->getMessage($messages)) throw new \Exception($message);

                // Check if login exists if changed
                if($row->getLogin() != $this->request->getPost('email')){
                    if($row->checkIfLoginExists($this->request->getPost('email'))){
                        throw new \Exception('Login уже используется');
                    }
                }

            // Validate if create
            }else{

                $validation = new NewUserValidation();
                $messages = $validation->validate($_POST);
                if($message = $validation->getMessage($messages)) throw new \Exception($message);

                // Check if login exists
                if($row->checkIfLoginExists($this->request->getPost('email'))) throw new \Exception('Login уже используется');
            }

            // update User model data
            $row->setName($this->request->getPost('name'));
            $row->setCity($this->request->getPost('city'));
            $row->setLogin($this->request->getPost('email'));
            if($this->request->getPost('password')){
                $row->setPassword($this->security->hash($this->request->getPost('password')));
            }

            // Update
            if(!empty($id)) {
                if($row->update()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Ошибка при редактировании записи');
            // Create
            }else{
                if($row->create()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Ошибка при создании записи');

                $async->setLocation($this->router->constructUrl('/users/edit/'.$row->getId()));
            }


        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }

    public function deleteAction($id = 0){

        $async = new AsyncRequest();

        try{
            if(empty($id)) throw new \Exception('No id');

            $model = new Users();

            if(!empty($id)) {
                if (!$row = $model->query()->where('id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');
            }

            if($row->delete()){ $async->setOKMessage('Удалено'); }else throw new \Exception('Ошибка при удалении');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

