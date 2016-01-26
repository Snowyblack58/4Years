<?php
	$array = json_decode(file_get_contents('../data/parsed-classes.txt'), true);
	foreach($array as $subject){
		foreach($subject as $class){
			if($class['title'] == $_POST['title']){
				$tmp = preg_split('/===/', $class['info']);
				$html = '<div id="info">';
				$html .= '<h2>' . $class['title'] . '</h2>';
				for($cnt = 0; $cnt < count($tmp); $cnt++){
					if($cnt % 2 == 0){
						$html .= '<br><b>' . $tmp[$cnt] . '</b>';	
					} else {
						$html .= '<br>' . $tmp[$cnt];
					}
				}
				$html = substr($html, 0, strlen($html) - 4) . '</div>';
				echo $html;
				break 2;
			}
		}
	}
?>