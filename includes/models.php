<?php
class CityDto {
    public $id;
    public $name;
    public $description;
    public $image_city;
    public $voivodeship;
    public $deleted;
    public $created_at;
    public $spots;

    public function __construct($city) {
        $this->id = $city->id;
        $this->name = $city->name;
        $this->description = $city->description ? $city->description : '<i>brak opisu miasta</i>';
        $this->image_city = $city->image_city;
        $this->deleted = $city->deleted;
        $this->created_at = $city->created_at;

        $this->voivodeship = $city->voivodeship;

        $this->spots = array();
    }

    public function addSpot($spot) {
        $this->spots[] = $spot;
    }
}
