<?php

class Cities extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $city_id;

    /**
     *
     * @var integer
     */
    protected $country_id;

    /**
     *
     * @var integer
     */
    protected $important;

    /**
     *
     * @var integer
     */
    protected $region_id;

    /**
     *
     * @var string
     */
    protected $title_ru;

    /**
     *
     * @var string
     */
    protected $area_ru;

    /**
     *
     * @var string
     */
    protected $region_ru;

    /**
     *
     * @var string
     */
    protected $title_en;

    /**
     *
     * @var string
     */
    protected $area_en;

    /**
     *
     * @var string
     */
    protected $region_en;

    /**
     *
     * @var string
     */
    protected $json;

    /**
     *
     * @var string
     */
    protected $http_status;

    /**
     *
     * @var integer
     */
    protected $dest_id;

    /**
     *
     * @var integer
     */
    protected $hotels;

    /**
     *
     * @var integer
     */
    protected $shift;

    /**
     * Method to set the value of field city_id
     *
     * @param integer $city_id
     * @return $this
     */
    public function setCityId($city_id)
    {
        $this->city_id = $city_id;

        return $this;
    }

    /**
     * Method to set the value of field country_id
     *
     * @param integer $country_id
     * @return $this
     */
    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * Method to set the value of field important
     *
     * @param integer $important
     * @return $this
     */
    public function setImportant($important)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Method to set the value of field region_id
     *
     * @param integer $region_id
     * @return $this
     */
    public function setRegionId($region_id)
    {
        $this->region_id = $region_id;

        return $this;
    }

    /**
     * Method to set the value of field title_ru
     *
     * @param string $title_ru
     * @return $this
     */
    public function setTitleRu($title_ru)
    {
        $this->title_ru = $title_ru;

        return $this;
    }

    /**
     * Method to set the value of field area_ru
     *
     * @param string $area_ru
     * @return $this
     */
    public function setAreaRu($area_ru)
    {
        $this->area_ru = $area_ru;

        return $this;
    }

    /**
     * Method to set the value of field region_ru
     *
     * @param string $region_ru
     * @return $this
     */
    public function setRegionRu($region_ru)
    {
        $this->region_ru = $region_ru;

        return $this;
    }

    /**
     * Method to set the value of field title_en
     *
     * @param string $title_en
     * @return $this
     */
    public function setTitleEn($title_en)
    {
        $this->title_en = $title_en;

        return $this;
    }

    /**
     * Method to set the value of field area_en
     *
     * @param string $area_en
     * @return $this
     */
    public function setAreaEn($area_en)
    {
        $this->area_en = $area_en;

        return $this;
    }

    /**
     * Method to set the value of field region_en
     *
     * @param string $region_en
     * @return $this
     */
    public function setRegionEn($region_en)
    {
        $this->region_en = $region_en;

        return $this;
    }

    /**
     * Method to set the value of field json
     *
     * @param string $json
     * @return $this
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Method to set the value of field http_status
     *
     * @param string $http_status
     * @return $this
     */
    public function setHttpStatus($http_status)
    {
        $this->http_status = $http_status;

        return $this;
    }

    /**
     * Method to set the value of field dest_id
     *
     * @param integer $dest_id
     * @return $this
     */
    public function setDestId($dest_id)
    {
        $this->dest_id = $dest_id;

        return $this;
    }

    /**
     * Method to set the value of field hotels
     *
     * @param integer $hotels
     * @return $this
     */
    public function setHotels($hotels)
    {
        $this->hotels = $hotels;

        return $this;
    }

    /**
     * Method to set the value of field shift
     *
     * @param integer $shift
     * @return $this
     */
    public function setShift($shift)
    {
        $this->shift = $shift;

        return $this;
    }

    /**
     * Returns the value of field city_id
     *
     * @return integer
     */
    public function getCityId()
    {
        return $this->city_id;
    }

    /**
     * Returns the value of field country_id
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * Returns the value of field important
     *
     * @return integer
     */
    public function getImportant()
    {
        return $this->important;
    }

    /**
     * Returns the value of field region_id
     *
     * @return integer
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * Returns the value of field title_ru
     *
     * @return string
     */
    public function getTitleRu()
    {
        return $this->title_ru;
    }

    /**
     * Returns the value of field area_ru
     *
     * @return string
     */
    public function getAreaRu()
    {
        return $this->area_ru;
    }

    /**
     * Returns the value of field region_ru
     *
     * @return string
     */
    public function getRegionRu()
    {
        return $this->region_ru;
    }

    /**
     * Returns the value of field title_en
     *
     * @return string
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }

    /**
     * Returns the value of field area_en
     *
     * @return string
     */
    public function getAreaEn()
    {
        return $this->area_en;
    }

    /**
     * Returns the value of field region_en
     *
     * @return string
     */
    public function getRegionEn()
    {
        return $this->region_en;
    }

    /**
     * Returns the value of field json
     *
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * Returns the value of field http_status
     *
     * @return string
     */
    public function getHttpStatus()
    {
        return $this->http_status;
    }

    /**
     * Returns the value of field dest_id
     *
     * @return integer
     */
    public function getDestId()
    {
        return $this->dest_id;
    }

    /**
     * Returns the value of field hotels
     *
     * @return integer
     */
    public function getHotels()
    {
        return $this->hotels;
    }

    /**
     * Returns the value of field shift
     *
     * @return integer
     */
    public function getShift()
    {
        return $this->shift;
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'city_id' => 'city_id', 
            'country_id' => 'country_id', 
            'important' => 'important', 
            'region_id' => 'region_id', 
            'title_ru' => 'title_ru', 
            'area_ru' => 'area_ru', 
            'region_ru' => 'region_ru', 
            'title_en' => 'title_en', 
            'area_en' => 'area_en', 
            'region_en' => 'region_en', 
            'json' => 'json', 
            'http_status' => 'http_status', 
            'dest_id' => 'dest_id', 
            'hotels' => 'hotels', 
            'shift' => 'shift'
        );
    }

    /**
     * Get count of items
     * @return int
     */
    public function getCount(){
        try{

            $query = $this->query()->columns('COUNT(*) AS total');
            $result = $query->execute();

            if(!$row = $result->getFirst()) throw new \Exception;

            return $row->total;
        }catch (\Exception $e){
            return 0;
        }
    }

}
