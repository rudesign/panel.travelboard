<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;

class DistrictsController extends ViewsController
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
            ->from('Districts')
            ->orderBy('district_id DESC');

        if($query = $this->request->get('q')){
            $builder->where("name LIKE '%{$query}%'");
        }

        $paginator = new PAdapter(
            array(
                "builder" => $builder,
                "limit"=> 25,
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
            $model = new Districts();

            $this->view->setVar('row', $model);

            $this->view->pick("districts/editItem");

        } catch (\Exception $e){
            $this->e404();
        }
    }


    public function showItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Districts();

            $row = $model->query()->where('district_id='.$id)->limit(1)->execute()->getFirst();

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

            $model = new Districts();

            if(!$row = $model->query()->where('district_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

            $this->setTitle($row->getName());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function saveItemAction($id)
    {
        $async = new AsyncRequest();

        try{
            if(empty($id)) throw new \Exception;

            $model = new Districts();

            if(!$row = $model->query()->where('district_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

            $row->setCityId($this->request->getPost('city_id'));
            $row->setName($this->request->getPost('name'));
            $row->setNameEn($this->request->getPost('name_en'));

            if($row->update()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Возникла ошибка');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

