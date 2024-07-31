<?php

namespace Projects\Cards\App\Models;

use \Illuminate\Database\Eloquent\Model;

class Model_Del_Words extends Model {

protected $table;

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_words');
}

public function delWords($id_words) {
	
	$this->where('id_words', $id_words)
			->delete();	
}

public function delAllWords($id_category) {

	$this->where('id_category', $id_category)->delete();
}

}
