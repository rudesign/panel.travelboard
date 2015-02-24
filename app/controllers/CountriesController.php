<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;

class CountriesController extends ViewsController
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
            ->from('Countries')
            ->orderBy('country_id DESC');

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

    public function createItemAction()
    {
        try{
            $model = new Countries();

            $this->view->setVar('row', $model);

            $this->view->pick("countries/editItem");

        } catch (\Exception $e){
            $this->e404();
        }
    }


    public function showItemAction($id)
    {
        try{
            if(empty($id)) throw new \Exception;

            $model = new Countries();

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

            $model = new Countries();

            $row = $model->query()->where('country_id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getTitleRu());

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

            $model = new Countries();

            if(!empty($id)) {
                if (!$row = $model->query()->where('country_id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');
            }else $row = $model;

            $row->setTitleRu($this->request->getPost('title_ru'));
            $row->setTitleEn($this->request->getPost('title_en'));

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

    public function deleteAction($id = 0)
    {
        $async = new AsyncRequest();

        try{
            if(empty($id)) throw new \Exception('No id');

            $model = new Countries();

            if(!empty($id)) {
                if (!$row = $model->query()->where('country_id=' . $id)->limit(1)->execute()->getFirst()) throw new \Exception('Запись не найдена');
            }

            if($row->delete()){ $async->setOKMessage('Удалено'); }else throw new \Exception('Ошибка при удалении');

        } catch (\Exception $e){
            $async->setMessage($e->getMessage());
        }

        $async->submitJSON();
    }
}

