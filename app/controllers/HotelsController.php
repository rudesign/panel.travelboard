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

        if($query = $this->request->get('q')){
            $builder->where("name LIKE '%{$query}%'");
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

            $row = $model->query()->where('hotel_id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

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

            $row = $model->query()->where('hotel_id='.$id)->limit(1)->execute()->getFirst();

            $row->setName($this->request->getPost('name'));
            $row->setAddress($this->request->getPost('address'));
            $row->setCityId($this->request->getPost('city_id'));

            $row->update();

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}
