<?php
	$html = file_get_contents('/afs/csl.tjhsst.edu/students/2016/2016dzhao/web-docs/SideProjects/4Years/data/tmp.txt');
	$raw = array_filter(preg_split('/\n/', $html), 'isNewline');
//	print_r($raw);
	$classes = array();
	$subject = '';
	$class = array();
	foreach($raw as $line){
		if(preg_match('/---/', $line)){
			$subject = substr($line, 3);
		} else if(preg_match('/(\t)/', $line) && preg_match('/^\w/', $line)){
			$classes[$class['subject']][] = $class;
			$info = preg_split('/\t/', $line);
			$class = array(
				'title' => trim($info[0]),
				'id' => trim($info[1]),
				'credits' => trim($info[2]),
				'weighting' => trim($info[3]),
				'short title' => trim($info[4]),
				'grades' => trim($info[5]),
				'subject' => trim($subject)
			);
		} else {
			$class['info'] .= $line;
			echo $line;
			echo '                 ';
			echo (strpos('Description_TJHSST Description_Prerequisites_Textbook_Fees_Commets_TJHSST Comments', trim($line)));
			echo '                 ';
			
			if(strpos('Description_TJHSST Description_Prerequisites_Textbook_Fees_Commets_TJHSST Comments', trim($line)) !== ''){
//				echo $line;
				$class['info'] .= '===';
			}
		}
	}
	array_shift($classes);

	function isNewline($line){
		return strlen($line) != 1;
	}

//	print_r($classes);
	
	file_put_contents('/afs/csl.tjhsst.edu/students/2016/2016dzhao/web-docs/SideProjects/4Years/data/parsed-classes.txt', json_encode($classes));
?>