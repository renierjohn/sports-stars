<?php

namespace App\Models;

use App\Models\Contracts;
use Tightenco\Collect\Support\Collection;

class NBA implements Contracts{
	
	protected $data;

	const BANNER_IMG = [
		'MEM' => 'mem.png',
		'GSW' => 'gsw.png'
	];

	const MAX_NUM_NBA = 7;

	public function __construct($data){
		$this->data = $data;
	}

	public function getID(){
		return $this->data->get('id');
	}

	public function getFullName(){
		return $this->data->get('first_name').' '.$this->data->get('last_name');
	}

	public function getFirstName(){
		return $this->data->get('first_name');
	}

	public function getLastName(){
		return $this->data->get('last_name');
	}

	public function getBannerTitle(){
		return 'NBA BASKETBALL';
	}

	public function getBannerImage(){
		return self::BANNER_IMG[$this->data->get('current_team')];
	}

	public function getImage(){
		return $this->image($this->getFullName());
	}

	public function getPlayerNumber(){
		return $this->data->get('number');
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

      if($id >= self::MAX_NUM_NBA){
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

	/**
   * Build stats to feature for this player
   *
   * @param \Illuminate\Support\Collection $player
   * @return \Illuminate\Support\Collection features
   */
	public function getBio(): Collection
	{
		return collect([
            ['label' => 'Position', 'value' => $this->data->get('position')],
            ['label' => 'Weight', 'value' => $this->data->get('weight')],
            ['label' => 'Hieght', 'value' => $this->getHieght()],
            ['label' => 'Age', 'value' => $this->getAge().' Years'],
     ]);
	}

	/**
     * Build stats to feature for this player
     *
     * @param \Illuminate\Support\Collection $player
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

	protected function getAge(){
		$today = date_create(date("Y-m-d"));
	  $old = date_create($this->data->get('birthday'));
		return date_diff($old,$today)->y;
	}

	protected function getHieght(){
		$inches = $this->data->get('inches');
		$feet   = $this->data->get('feet');
		return ($feet * 30.48) + ($inches * 2.54);

	}

		protected function image(string $name): string
  {
      return 'nba/'.preg_replace('/\W+/', '-', strtolower($name)) . '.png';
  }

}