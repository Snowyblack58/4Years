<?php
	$parsed_classes = array();

	function init(){
		global $parsed_classes;
		$classes_file = file_get_contents("https://www.tjhsst.edu/~2016dzhao/SideProjects/GPA/data/classes.txt"); 
		$raw = preg_split("/(\t|\n)/", $classes_file);
		$index = 0;
		$cur_subject = "";
		while($index < count($raw)){
			if($raw[$index][0] == "-"){
				$cur_subject = trim(substr($raw[$index], 1));
				$parsed_classes[$cur_subject] = array();
				$index += 1;
			} else {
				$parsed_classes[$cur_subject][] = array(
					"class" => trim($raw[$index]),
					"id" => trim($raw[$index+1]),
					"credits" => trim($raw[$index+2]),
					"weighting" => trim($raw[$index+3]),
					"short title" => trim($raw[$index+4]),
					"grades" => trim($raw[$index+5])
				);
				$index += 6;
			}
		}
		$parsed_classes_file = fopen("/afs/csl.tjhsst.edu/web/user/2016dzhao/web-docs/SideProjects/GPA/data/parsed-classes.txt","w");
		fwrite($parsed_classes_file, json_encode($parsed_classes));
		fclose($parsed_classes_file);
	}
	
	function createSelectHTML($grade, $name){
		global $parsed_classes;
		$class_select_html = "<select name=\"" . $name . "\"><option></option><optgroup label=\"".$grade."\"></optgroup>";
		foreach($parsed_classes as $subject => $arr){
			$class_select_html .= "<option></option><optgroup label=\"" . $subject . "\">";
			foreach($arr as $class){
				if(strpos($class["grades"],$grade) !== false){
					$class_select_html .= "<option value=\"" . $class['id'] . "\">" . $class["short title"] . "</option>";
				}
			}
			$class_select_html .= "</optgroup>";
		}
		$class_select_html .= "</select>";
		return $class_select_html;
	}

	function createSelectHTMLSummer($grade, $name){
		global $parsed_classes;
		$class_select_html = "<select name=\"" . $name . "\"><option></option><optgroup label=\"" . $grade . "\"></optgroup><option></option><optgroup label=\"Summer School\">";
			foreach($parsed_classes["Summer School"] as $class){
				if(strpos($class["grades"], $grade) !== false){
					$class_select_html .= "<option value=\"" . $class['id'] . "\">" . $class["short title"] . "</option>";
				}
			}
		$class_select_html .= "</optgroup></select>";
		return $class_select_html;
	}

	function createCalculatorHTML(){
		global $parsed_classes;
//		echo count($parsed_classes);
		$select .= '<table id="school-year">';
		for($c = 1; $c <= 7; $c++){
			$select .= '<tr>';
			for($g = 9; $g <= 12; $g++){
				$select .= '<td>' . createSelectHTML(strval($g), $g . '-' . $c) . '</td>';
			}
			$select .= '</tr>';
		}
		$select .= '</table>';
		$select .= '<table id="summer">';
		$select .= '<tr>';
		for($g = 9; $g <= 12; $g++){
				$select .= '<td>' . createSelectHTMLSummer(strval($g), $g . '-s') . '</td>';
		}
		$select .= '</tr>';
		$select .= '</table>';
		return $select;
	}

	 init();
	 $action = $_POST['action'];
	 $data = $action();
	 echo $data;
//	print_r(SQLite3::version());
?>