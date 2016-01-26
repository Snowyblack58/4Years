<?php
	$parsed_classes = json_decode(file_get_contents('../data/parsed-classes.txt'), true);
	$grade = $_POST['grade'];
	$html = '';
//	print_r($parsed_classes);
	foreach($parsed_classes as $subject => $arr){
		$new_subject = true;
		for($cnt = 0; $cnt < count($parsed_classes[$subject]); $cnt++){
			if(strpos($parsed_classes[$subject][$cnt]['grades'],$grade) !== false){
				if($new_subject){
					$html .= '<label class="_subject"><span>' .
						$subject .
						'</span></label>';	
					$new_subject = false;
				}
				$html .= '<label class="_class' .
//					str_replace(' ', '-', strtolower($subject)) .
					'" id="' .
					$parsed_classes[$subject][$cnt]['id'] . 
					'"><span>' . 
					$parsed_classes[$subject][$cnt]['title'] . 
					'</span></label>';
			}
		}
	}
	echo $html;
?>