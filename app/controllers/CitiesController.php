<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;

class CitiesController extends ViewsController
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
            ->from('Cities')
            ->orderBy('title_ru ASC');

        if($query = $this->request->get('q')){
            $builder->where("title_ru LIKE '%{$query}%'");
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

            $model = new Cities();

            $row = $model->query()->where('id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getTitleRu());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function editItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Cities();

            $row = $model->query()->where('city_id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getTitleRu());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function showRegionSelectorAction(){
        $async = new AsyncRequest();

        try{
            $regionId = $this->request->getPost('regionId');
            $cityId = $this->request->getPost('cityId');

            if(empty($regionId) && !empty($cityId)){
                $model = new Cities();
                $row = $model->query()->where('city_id='.$cityId)->limit(1)->execute()->getFirst();
                if(!$regionId = $row->getRegionId()) throw new \Exception;
            }

            $async->data['html'] = $async->getView('cities/regionSelector', array(
                'regionId'=>$regionId,
                'cityId'=>$cityId,
            ));

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

