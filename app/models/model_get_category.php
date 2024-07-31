<?php

namespace Projects\Cards\App\Models;

use Illuminate\Database\Eloquent\Model;


class Model_Get_Category extends Model {

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_category');
}

public function getCategory($option = false) {

	$result = $this->orderBy('default', 'desc')->get();
		
		foreach ($result as $value)
		{
			$category[] = [$value['id_category'], $value['category'], $value['default']];
		}
			$sendData = $category;

				   if($option)
				   {
				   		return $sendData;
				   }
				   else
				   {
				   		echo json_encode($sendData);
				   }	
}

}
