<?php

class Regions extends \Phalcon\Mvc\Model
{
    protected $country_id;

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
    protected $title_en;

    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

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
     * Method to set the value of field title_ua
     *
     * @param string $title_ua
     * @return $this
     */
    public function setTitleUa($title_ua)
    {
        $this->title_ua = $title_ua;

        return $this;
    }

    /**
     * Method to set the value of field title_be
     *
     * @param string $title_be
     * @return $this
     */
    public function setTitleBe($title_be)
    {
        $this->title_be = $title_be;

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
     * Method to set the value of field title_es
     *
     * @param string $title_es
     * @return $this
     */
    public function setTitleEs($title_es)
    {
        $this->title_es = $title_es;

        return $this;
    }

    /**
     * Method to set the value of field title_pt
     *
     * @param string $title_pt
     * @return $this
     */
    public function setTitlePt($title_pt)
    {
        $this->title_pt = $title_pt;

        return $this;
    }

    /**
     * Method to set the value of field title_de
     *
     * @param string $title_de
     * @return $this
     */
    public function setTitleDe($title_de)
    {
        $this->title_de = $title_de;

        return $this;
    }

    /**
     * Method to set the value of field title_fr
     *
     * @param string $title_fr
     * @return $this
     */
    public function setTitleFr($title_fr)
    {
        $this->title_fr = $title_fr;

        return $this;
    }

    /**
     * Method to set the value of field title_it
     *
     * @param string $title_it
     * @return $this
     */
    public function setTitleIt($title_it)
    {
        $this->title_it = $title_it;

        return $this;
    }

    /**
     * Method to set the value of field title_pl
     *
     * @param string $title_pl
     * @return $this
     */
    public function setTitlePl($title_pl)
    {
        $this->title_pl = $title_pl;

        return $this;
    }

    /**
     * Method to set the value of field title_ja
     *
     * @param string $title_ja
     * @return $this
     */
    public function setTitleJa($title_ja)
    {
        $this->title_ja = $title_ja;

        return $this;
    }

    /**
     * Method to set the value of field title_lt
     *
     * @param string $title_lt
     * @return $this
     */
    public function setTitleLt($title_lt)
    {
        $this->title_lt = $title_lt;

        return $this;
    }

    /**
     * Method to set the value of field title_lv
     *
     * @param string $title_lv
     * @return $this
     */
    public function setTitleLv($title_lv)
    {
        $this->title_lv = $title_lv;

        return $this;
    }

    /**
     * Method to set the value of field title_cz
     *
     * @param string $title_cz
     * @return $this
     */
    public function setTitleCz($title_cz)
    {
        $this->title_cz = $title_cz;

        return $this;
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
     * Returns the value of field country_id
     *
     * @return integer
     */
    public function getCountryId()
    {
        return $this->country_id;
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
     * Returns the value of field title_en
     *
     * @return string
     */
    public function getTitleEn()
    {
        return $this->title_en;
    }


    /**
     * Returns the value of field title_lt
     *
     * @return string
     */
    public function getTitleLt()
    {
        return $this->title_lt;
    }


    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'country_id' => 'country_id',
            'region_id' => 'region_id',
            'title_ru' => 'title_ru',
            'title_en' => 'title_en',
        );
    }

}
