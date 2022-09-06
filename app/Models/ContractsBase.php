<?php

namespace App\Models;

use App\Models\Contracts;
use App\Models\AllBlack;
use App\Models\NBA;

class ContractsBase
{

	protected $model;

	public function __construct($type,$data){
		  $obj = new \ReflectionClass($this->getModelList()[$type]);
      $this->model = $obj->newInstanceArgs([$data]);
	}

	protected function getModelList(){
		return [
			'allblacks'   => AllBlack::class,
			'nba.players' => NBA::class
		];
	}

	public function model(){
		return $this->model;
	}
	
}