<?php

namespace Projects\Cards\App\Models;

use \Illuminate\Database\Eloquent\Model;


class Model_Edit_Words extends Model {

protected $table;
public $timestamps = false;

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_words');
}

public function editWords($id_words, $category, $native, $translate, $sentance) {
		// Words checking for future features 
		// if($this->checkWords($category, $native, $translate))
		if(true)
		{
			$this->where('id_words', $id_words)
				->update([
							'native' => ucfirst($native),
							'translate' => ucfirst($translate),
							'sentence' => ucfirst($sentance),
							'id_category' => $category,
							'created_at' => date('Y.m.d H:m:s')
						]);

			$sendData = ['status' => true];

				echo json_encode($sendData);	
		}
		else
		{
		$sendData = [
					 'status' => false,
					 'native' => $native,
					 'translate' => $translate
					];

		echo json_encode($sendData);
	}
}

public function checkWords($category, $native, $translate) {

	$result = $this->where('id_category', $category)
				   ->where('native', $native)
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
