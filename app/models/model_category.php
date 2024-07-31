<?php

namespace Projects\Cards\App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Projects\Cards\App\Models\Model_Del_Words;


class Model_Category extends Model {

protected $table;

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_category');
}

public function addCategory($category) {

	if($this->checkCategory($category))
	{
		$id_category = $this->insertGetId([
											'category' => $category,
											'default' => 0	  
										  ]);
		$sendData = [
					'status' => true,
					'id_category' => $id_category
					];

		echo json_encode($sendData);
	}
	else
	{
		$sendData = [
					'status' => false,
					];

		echo json_encode($sendData);
	}
}


public function checkCategory($category) {

	$result = $this->where('category', $category)
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

public function delCategory($id_category) {

	// Delete all words in category
	$model_Del_Words = new Model_Del_Words();
		$model_Del_Words->delAllWords($id_category);

	// Delete  category
	$this->where('id_category', $id_category)->delete();

	// Send result	
	$sendData = ['status' => true];
		echo json_encode($sendData);
}

//Fun not used
public function checkExistCategory() {

	$result = $this->where('category', 'Deleted words')->get();

	if($result->isNotEmpty())
	{
		return $result[0]['id_category'];
	}
	else
	{
		$result2 = $this->insert([
			'category' => 'Deleted words'
		]);

		return $result2;
	}
}

}
