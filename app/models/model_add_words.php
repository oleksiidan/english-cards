<?php

namespace Projects\Cards\App\Models;

use \Illuminate\Database\Eloquent\Model;
use DateTime;


class Model_Add_Words extends Model {

protected $table;

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_words');
}

public function addWords($category, $native, $translate, $sentance) {

	$date = new DateTime();
		$dateNow = $date->format("Y-m-d");

	if($this->checkWords($category, $translate))
	{
		$this->insert([
			    'native' => ucfirst($native),
			    'translate' => ucfirst($translate),
			    'sentence' => ucfirst($sentance),
			    'id_category' => $category,
			    'created_at' => $dateNow
		]);
			$sendData = ['status' => true];
	}
	else
	{
		$sendData = [
					 'status' => false,
					 'native' => $native,
					 'translate' => $translate
					];
	}

	echo json_encode($sendData);
}

public function checkWords($category, $translate) {

	if (strlen($translate) == 0)
	{
		return true;
	}
	else
	{
		$result = $this->where('id_category', $category)
						->where('translate', $translate)
						->get();

		if($result->isNotEmpty())
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

}
