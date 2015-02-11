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
            ->orderBy('city_id DESC');

        if($query = $this->request->get('q')){
            $builder->where("title_ru LIKE '%{$query}%'");
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
            $model = new Cities();

            $this->view->setVar('row', $model);

            $this->view->pick("cities/editItem");

        } catch (\Exception $e){
            $this->e404();
        }
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

            if(!$row = $model->query()->where('city_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

            $this->setTitle($row->getTitleRu());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }

    public function showRegionSelectorAction(){

        $async = new AsyncRequest();

        try{
            $countryId = $this->request->getPost('countryId');
            $regionId = $this->request->getPost('regionId');

            if(empty($countryId) && !empty($regionId)){
                $model = new Regions();
                $row = $model->query()->where('region_id='.$regionId)->limit(1)->execute()->getFirst();
                $countryId = $row->getCountryId();
            }
            if(empty($regionId) && !empty($cityId)){
                $model = new Cities();
                $row = $model->query()->where('city_id='.$cityId)->limit(1)->execute()->getFirst();
                $regionId = $row->getRegionId();
            }

            $async->data['html'] = $async->getView('cities/regionSelector', array(
                'countryId'=>$countryId,
                'regionId'=>$regionId,
            ));

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }

    public function showCitySelectorAction(){

        $async = new AsyncRequest();

        try{
            $countryId = $this->request->getPost('countryId');
            $regionId = $this->request->getPost('regionId');
            $cityId = $this->request->getPost('cityId');

            if(empty($countryId) && !empty($regionId)){
                $model = new Regions();
                if($row = $model->query()->where('region_id='.$regionId)->limit(1)->execute()->getFirst()) {
                    $countryId = $row->getCountryId();
                }
            }

            if(empty($regionId) && !empty($cityId)){
                $model = new Cities();
                if($row = $model->query()->where('city_id='.$cityId)->limit(1)->execute()->getFirst()) {
                    $countryId = $row->getCountryId();
                    $regionId = $row->getRegionId();
                }
            }

            $async->data['html'] = $async->getView('cities/citySelector', array(
                'countryId'=>$countryId,
                'regionId'=>$regionId,
                'cityId'=>$cityId,
            ));

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }

    public function showSearchFormCitySelectorAction(){

        $async = new AsyncRequest();

        try{
            $async->data['html'] = $async->getView('cities/searchFormCitySelector');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }

    public function saveItemAction($id)
    {
        $async = new AsyncRequest();

        try{
            if(empty($id)) throw new \Exception;

            $model = new Cities();

            if(!$row = $model->query()->where('city_id='.$id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

            $row->setCountryId($this->request->getPost('country_id'));
            $row->setRegionId($this->request->getPost('region_id'));
            $row->setTitleRu($this->request->getPost('title_ru'));
            $row->setTitleEn($this->request->getPost('title_en'));

            if($row->update()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Возникла ошибка');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

