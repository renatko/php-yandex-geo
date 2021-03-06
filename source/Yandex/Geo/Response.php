<?php
namespace Yandex\Geo;

/**
 * Class Response
 * @package Yandex\Geo
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 */
class Response
{
    /**
     * @var \Yandex\Geo\GeoObject[]
     */
    protected $_list = array();
    /**
     * @var array
     */
    protected $_data;

    public function __construct(array $data)
    {
        $this->_data = $data;
        if (isset($data['response']['GeoObjectCollection']['featureMember'])) {
            foreach ($data['response']['GeoObjectCollection']['featureMember'] as $entry) {
                $this->_list[] = new \Yandex\Geo\GeoObject($entry['GeoObject']);
            }
        }
    }

    /**
     * @return \Yandex\Geo\GeoObject[]
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * Возвращает исходный запрос
     * @return string|null
     */
    public function getQuery()
    {
        $result = null;
        if (isset($this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['request'])) {
            $result = $this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['request'];
        }
        return $result;
    }

    /**
     * Кол-во найденных результатов
     * @return int
     */
    public function getFoundCount()
    {
        $result = null;
        if (isset($this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'])) {
            $result = (int)$this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['found'];
        }
        return $result;
    }

    /**
     * Широта в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     * @return float|null
     */
    public function getLatitude()
    {
        $result = null;
        if (isset($this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['Point'])) {
            list($latitude,) = explode(' ', $this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['Point']);
            $result = (float)$latitude;
        }
        return $result;
    }

    /**
     * Долгота в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     * @return float|null
     */
    public function getLongitude()
    {
        $result = null;
        if (isset($this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['Point'])) {
            list(, $longitude) = explode(' ', $this->_data['response']['GeoObjectCollection']['metaDataProperty']['GeocoderResponseMetaData']['Point']);
            $result = (float)$longitude;
        }
        return $result;
    }
}