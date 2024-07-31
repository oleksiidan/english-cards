<?php

namespace Projects\Cards\App\Models;

use Illuminate\Database\Eloquent\Model;
use Projects\Cards\App\Models\Model_Get_Category;


class Model_Get_Words extends Model {

public function __construct() {

	$this->setTable('cards_'.$_SESSION['user']['id_user'].'_words');
}

public function getWords($category, $start = null, $end = null, $option = null) {
		
		$startKey = 'start';
			$endKey = 'end';

		if($option === 'end')
		{
			$result = $this->where('id_category', $category)
						   ->orderBy('id_words', 'desc')
						   ->limit(10)
						   ->get();
		}
		elseif ($option === 'start')
		{
			$result = $this->where('id_category', $category)
						   ->limit(10)
						   ->get();		
		}
		else
		{
			if($start === null && $end > 0)
			{
				$result = $this->where('id_category', $category)
						->where('id_words', '<', $end)
						->orderBy('id_words', 'desc')
						->limit(10)
						->get();
			}

			if($start >= 0 && $end === null)
			{
				$result = $this->where('id_category', $category)
								->where('id_words', '>', $start)
								->limit(10)
								->get();
				$startKey = 'end';
					$endKey = 'start';
			}
				
		}
			// Query for card_number()
			$all_in_category = $this->where('id_category', $category)
									->orderBy('id_words', 'asc')
									->get();

			// Check result				
			if(count($result->all()) >= 1)
			{
				foreach($result as $key => $value)
				{
					$key = $value->id_words;
						$words[$key] = $value;

					// Add card number
					$words[$key]['card_number'] = $this->card_number($all_in_category, $value->translate);
				}

				// Aggregator			
				$sendData = [				
								$startKey => array_key_first($words),
								$endKey => array_key_last($words),
								'words' => $words
							];
				
				// pages
				$pages = $this->getPages($category, $sendData['start']);
					$sendData['pages'] = $pages;
				
				// word count
				$sendData['count'] = $this->wordCount();

				// Add status true
				$sendData['status'] = true;

						echo json_encode($sendData);
			}
			else
			{
				$sendData['status'] = false;
					$sendData['count'] = $this->wordCount();
				
				echo json_encode($sendData);
			}
}

public function getPages($id_category, $id_word): array {

	// get total
	$result_total = $this->where('id_category', $id_category)->count();

	// get current page
	$result_all_words = $this->where('id_category', $id_category)->get();

		foreach($result_all_words as $key => $value)
		{
			if($value['id_words'] == $id_word)
			{
				$num_words = $key + 1;
			}
		};

		$page = 1;

			for($i = 10; $num_words > $i; $i += 10)
			{
				$page++;	
			};
	
	// return
	return ['current' => $page, 'total' => ceil($result_total / 10)];
}

public function wordCount(): array {

	// total words count
	$total = $this->count();

	// get id category
	$model_get_category = new Model_Get_Category();
		$result = $model_get_category->getCategory(true);
			
			foreach ($result as $value)
			{		
				$word_count_in_category = $this->where('id_category', $value[0])->count();
					$count_in_category[] = [
						
						$value[0], $value[1], $word_count_in_category
					];
			}
	
	//return
	return [
			'total' => $total,
			'category' => $count_in_category
	];
}

public function card_number($all_in_category, $eng_word) {
	
	$i = 0;
		$card_number = null;
			foreach($all_in_category as $value)
			{
				$i++;
					if($value->translate == $eng_word)
					{	
						$card_number = $i;
					}	
			}
	return $card_number;
}

}
