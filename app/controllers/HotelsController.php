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
            ->orderBy('hotel_id DESC');

        if($query = $this->request->get('q')) $builder->where("name LIKE '%{$query}%'");
        if($query = $this->request->get('co')) $builder->where("country_id = '{$query}'");
        if($query = $this->request->get('re')) $builder->where("region_id = '{$query}'");
        if($query = $this->request->get('ci')) $builder->where("city_id = '{$query}'");

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
            $model = new Hotels();

            $this->view->setVar('row', $model);

            $this->view->pick("hotels/editItem");

        } catch (\Exception $e){
            $this->e404();
        }
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

            if (!$row = $model->query()->where('hotel_id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');

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
            //if(empty($id)) throw new \Exception;

            $model = new Hotels();

            if(!empty($id)) {
                if (!$row = $model->query()->where('hotel_id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');
            }else $row = $model;

            $row->setName($this->request->getPost('name'));
            $row->setAddress($this->request->getPost('address'));
            $row->setAddressOrig($this->request->getPost('address_orig'));
            $row->setCountryId(($countryId = $this->request->getPost('country_id')) ? $countryId : 0);
            $row->setRegionId(($regionId = $this->request->getPost('region_id')) ? $regionId : 0);
            $row->setCityId(($cityId = $this->request->getPost('city_id')) ? $cityId : 0);
            $row->setLat($this->request->getPost('lat'));
            $row->setLng($this->request->getPost('lng'));
            $row->setRating($this->request->getPost('rating'));
            $row->setSummary($this->request->getPost('summary'));
            $row->setServices($this->request->getPost('services'));
            $row->setExtraServices($this->request->getPost('extra_services'));
            $row->setRooms($this->request->getPost('rooms'));
            $row->setRoomTypes(str_replace("\n", '# ', $this->request->getPost('room_types')));
            $row->setCheckIn($this->request->getPost('checkin'));
            $row->setCheckOut($this->request->getPost('checkout'));
            $row->setLanguages($this->request->getPost('languages'));
            $row->setChildrenPolicy($this->request->getPost('children_policy'));
            $row->setFood($this->request->getPost('food'));
            $row->setParking($this->request->getPost('parking'));
            $row->setWellness($this->request->getPost('wellness'));
            $row->setFreeInternet($this->request->getPost('free_internet'));
            $row->setInternet($this->request->getPost('internet'));
            $row->setPaymentTypes($this->request->getPost('payment_types'));
            $row->setUrlOrig($this->request->getPost('url_orig'));
            $row->setHotelIdOrig($this->request->getPost('hotel_id_orig'));
            // 500 - moderated
            $row->setStatus((($this->request->getPost('status') == 500) ? 500 : 202));
            $row->setGalleryDownloaded($this->request->getPost('gallery_downloaded'));

            if(!empty($id)) {
                if($row->update()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Ошибка при редактировании записи');
            }else{
                if($row->create()){ $async->setOKMessage('Сохранено'); }else throw new \Exception('Ошибка при создании записи');
            }

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

