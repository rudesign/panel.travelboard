<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;

class HotelsController extends ViewsController
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
            ->from('Hotels')
            ->orderBy('name ASC');

        if($query = $this->request->get('q')) $builder->where("name LIKE '%{$query}%'");
        if($query = $this->request->get('r')) $builder->where("region_id = '{$query}'");
        if($query = $this->request->get('c')) $builder->where("city_id = '{$query}'");

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

    public function showItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Hotels();

            $row = $model->query()->where('hotel_id='.$id)->limit(1)->execute()->getFirst();

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

            $model = new Hotels();

            if(!$row = $model->query()->where('hotel_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

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

            $model = new Hotels();

            if(!$row = $model->query()->where('hotel_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

            $row->setName($this->request->getPost('name'));
            $row->setAddress($this->request->getPost('address'));
            $row->setRegionId($this->request->getPost('region_id'));
            $row->setCityId($this->request->getPost('city_id'));
            $row->setStatus((($this->request->getPost('status') == 500) ? 500 : 202));

            if($row->update()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Возникла ошибка');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

