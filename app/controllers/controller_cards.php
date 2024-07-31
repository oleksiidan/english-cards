<?php

namespace Projects\Cards\App\Controllers;

use \Projects\Auth\App\Models\Model_Auth;
use \Projects\Cards\App\Models\Model_Get_Words;
use \Projects\Cards\App\Models\Model_Add_Words;
use \Projects\Cards\App\Models\Model_Edit_Words;
use \Projects\Cards\App\Models\Model_Del_Words;
use \Projects\Cards\App\Models\Model_Get_Category;
use \Projects\Cards\App\Models\Model_Category;
use \Repo\View;
use \Projects\Cards\App\Models\Model_Create_Tables;


class Controller_Cards extends View {

public function main() {

	$objModelAuth = new Model_Auth();
		$check = $objModelAuth->check();
			
		if($check)
		{			
			// Check tables exist
			if($_SESSION['user']['analytics'] == 0)
			{
				$model_Create_Tables = new Model_Create_Tables();
					$model_Create_Tables->createTables();	
			}				
				$this->view('cards', 'auth.php', ['email' => $_SESSION['user']['email']]);				
		}
		else
		{
			$this->view('cards', 'notauth.php', []);

		}
}

public function getWords($category, $start, $end, $option) {

	$Model_Get_Words = new Model_Get_Words();
		$Model_Get_Words->getWords($category, $start, $end, $option);
}

public function addWords($category, $native, $translate, $sentance) {

	$Model_Add_Words = new Model_Add_Words;
		$Model_Add_Words->addWords($category, $native, $translate, $sentance);
}

public function editWords($id_words, $category, $native, $translate, $sentance) {
	$Model_Edit_Words = new Model_Edit_Words;
		$Model_Edit_Words->editWords($id_words, $category, $native, $translate, $sentance);
}

public function delWords($id_words) {
	$Model_Del_Words = new Model_Del_Words();
		$Model_Del_Words->delWords($id_words);
}

public function getCategory() {
	$Model_Get_Category = new Model_Get_Category();
		$Model_Get_Category->getCategory();
}

public function addCategory($category) {
	$Model_Category = new Model_Category();
		$Model_Category->AddCategory($category);
}

public function delCategory($categoryId) {
	$Model_Category = new Model_Category();
		$Model_Category->delCategory($categoryId);
}

}
