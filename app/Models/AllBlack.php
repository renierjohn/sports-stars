<?php

namespace App\Models;

use App\Models\Contracts;
use Tightenco\Collect\Support\Collection;

class AllBlack implements Contracts{

	protected $data;

	const MAX_NUM_ALL_BLACK = 8;

	public function __construct($data){
		$this->data = $data;
	}

	public function getID(){
		return $this->data->get('id');
	}

	public function getFullName(){
		return $this->data->get('name');
	}

	public function getFirstName(){
		return explode(' ',$this->data->get('name'))[0];
	}

	public function getLastName(){
		return explode(' ',$this->data->get('name'))[1];
	}

	public function getBannerTitle(){
		return 'ALL BLACKS RUGBY';
	}

	public function getPlayerNumber(){
		return $this->data->get('number');
	}

	public function getBannerImage(){
		return 'allblacks.png';
	}

	public function getImage(){
		return $this->image($this->data->get('name'));
	}

	public function getTabs(){
      $tabs = [];
      $id = $this->data->get('id');
      if($id == 1){
          return [
              'prev' => false,
              'current' => $id,
              'next' => $id + 1
          ];
      }

      if($id >= self::MAX_NUM_ALL_BLACK){
          return [
              'prev' => $id - 1,
              'current' => $id,
              'next' => false
          ];   
      }

      return [
      	  'prev' => $id - 1,
          'current' => $id,
          'next' => $id + 1
      ];

  }

	public function getBio(): Collection
	{
		return collect([
            ['label' => 'Position', 'value' => $this->data->get('position')],
            ['label' => 'Weight', 'value' => $this->data->get('weight')],
            ['label' => 'Hieght', 'value' => $this->data->get('height')],
            ['label' => 'Age', 'value' => $this->data->get('age').' Years'],
     ]);
	}

 	/**
   * 
   * @return \Illuminate\Support\Collection features
   */
	public function feature(): Collection
	{
		return collect([
            ['label' => 'Points', 'value' => $this->data->get('points')],
            ['label' => 'Games', 'value' => $this->data->get('games')],
            ['label' => 'Tries', 'value' => $this->data->get('tries')],
     ]);
	}

	protected function image(string $name): string
  {
      return 'allblacks/'.preg_replace('/\W+/', '-', strtolower($name)) . '.png';
  }
	
}