<?php

namespace App\Models;

interface Contracts{

	public function getID();

	public function getFullName();

	public function getFirstName();

	public function getLastName();

	public function getBio();

	public function getBannerTitle();

	public function getBannerImage();

	public function getPlayerNumber();

	public function feature();
	
}