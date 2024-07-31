<?php

use \Projects\Cards\App\Controllers\Controller_Cards;
use \Projects\Analytics\App\Models\Model_Analytics_Count;

Flight::route('GET /english-cards', function() {	

	// Analytics
	$objCount = new Model_Analytics_Count('cards', 'all');
		$objCount->count();
	
	$Controller_Cards = new Controller_Cards();
		$Controller_Cards->main();
});

Flight::route('POST /english-cards', function() {

	// Analytics
	$objCount = new Model_Analytics_Count('cards', 'all');
		$objCount->count();

	$Controller_Cards = new Controller_Cards();

		$key = Flight::request()->data->key;

			if($key == 'getWords')
			{
				$category = Flight::request()->data->category;
					$start = Flight::request()->data->start;
						$end = Flight::request()->data->end;
							$option = Flight::request()->data->option;
					
				$Controller_Cards->getWords($category, $start, $end, $option);
			
			}
			elseif ($key == 'addWords')
			{
				$category = Flight::request()->data->category;
					$native = Flight::request()->data->native;
						$translate = Flight::request()->data->translate;
							$sentence = Flight::request()->data->sentence;

				$Controller_Cards->addWords($category, $native, $translate, $sentence);

			}
			elseif ($key == 'editWords')
			{
				$id_words = Flight::request()->data->id_words;
					$category = Flight::request()->data->category;
						$native = Flight::request()->data->native;
							$translate = Flight::request()->data->translate;
								$sentence = Flight::request()->data->sentence;
								
				$Controller_Cards->editWords($id_words, $category, $native, $translate, $sentence);			
			}
			elseif ($key == 'getCategory')
			{
				$Controller_Cards->getCategory();
			}
			elseif ($key == 'delWords')
			{
				$id_words = Flight::request()->data->id_words;
					$Controller_Cards->delWords($id_words);
			}
			elseif ($key == 'addCategory')
			{
				$category = Flight::request()->data->category;
					$Controller_Cards->addCategory($category);
			
			}
			elseif ($key == 'delCategory')
			{
				$categoryId = Flight::request()->data->categoryId;
					$Controller_Cards->delCategory($categoryId);
			}

});
