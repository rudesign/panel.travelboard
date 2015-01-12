<?php

use Phalcon\Paginator\Adapter\QueryBuilder as PAdapter;


class CountriesController extends ViewsController
{
    public function indexAction(){}

    public function showGridAction()
    {
        $this->notify('Another message here');

        $builder = $this->modelsManager->createBuilder()
            ->from('Countries')
            ->orderBy('country_id DESC');

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

            $marketplace = new Countries();

            $row = $marketplace->query()->where('id='.$id)->limit(1)->execute()->getFirst();

            if(!count($row)) throw new \Exception;

            $this->setTitle($row->getTitleRu());

            $this->view->setVar('row', $row);

        } catch (\Exception $e){
            $this->e404();
        }
    }
}

