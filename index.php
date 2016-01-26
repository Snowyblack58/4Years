<?php
	function createSelector($grade){
		$parsed_classes = json_decode(file_get_contents('/afs/csl.tjhsst.edu/web/user/2016dzhao/web-docs/SideProjects/4Years/data/parsed-classes.txt'), true);
		$html = '';
		foreach($parsed_classes as $subject => $arr){
			$new_subject = true;
			for($cnt = 0; $cnt < count($parsed_classes[$subject]); $cnt++){
				if(strpos($parsed_classes[$subject][$cnt]['grades'], $grade) !== false){
					if($new_subject){
						$html .= '<label class="_subject"><span>' .	$subject . '</span></label>';
						$new_subject = false;
					}
					$html .= '<label class="_class' .
						'" id="' .
						$parsed_classes[$subject][$cnt]['id'] . 
						'"><span>' . 
						$parsed_classes[$subject][$cnt]['title'] . 
						'</span></label>';
				}
			}
		}
		return $html;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>TJ Schedule Planner</title>
		<meta charset='UTF-8'>
		<link rel='stylesheet' type='text/css' href='css/styles.css'>
		<link href='https://fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css'>
	</head>
	<body onload='init()'>
		<div id='page-0'>
			<a class='noselect' id='start-button' href='#1'>Create Schedule</a>
		</div>
		<div id='page-1' hidden>
			<!-- <div class='header noselect' id='header-9'>
				<p>Grade 9</p>
			</div> -->
			<div class='header noselect' id='header-9'>
				<div><a class='grade-9-anchor selected-anchor' href='#1'>Grade 9</a></div>
				<div><a class='grade-10-anchor' href='#2'>Grade 10</a></div>
				<div><a class='grade-11-anchor' href='#3'>Grade 11</a></div>
				<div><a class='grade-12-anchor' href='#4'>Grade 12</a></div>
				<div><a class='submit-anchor' href='#5'>Submit</a></div>
			</div>
			<div class='class-schedule noselect' id='classes-9'>
                <h3 class='subtitle'>Your Schedule</h3>
				<label class='chosen_class' id='9-1'><span>1</span></label>
				<label class='chosen_class' id='9-2'><span>2</span></label>
				<label class='chosen_class' id='9-3'><span>3</span></label>
				<label class='chosen_class' id='9-4'><span>4</span></label>
				<label class='chosen_class' id='9-5'><span>5</span></label>
				<label class='chosen_class' id='9-6'><span>6</span></label>
				<label class='chosen_class' id='9-7'><span>7</span></label>
				<label class='chosen_class' id='9-8'><span>8</span></label>
			</div>
            <h3 class='subtitle noselect'>Possible Classes for Freshmen</h3>
			<div class='class-selector noselect' id='possible-classes-9'>
				<?php print_r(createSelector('9')) ?>
			</div>
			<div class='class-info-box' id='class-info-box-9'>
			</div>
		</div>
		<div id='page-2' hidden>
			<!-- <div class='header noselect' id='header-10'>
				<p>Grade 10</p>
			</div> -->
			<div class='header noselect' id='header-10'>
				<div><a class='grade-9-anchor' href='#1'>Grade 9</a></div>
				<div><a class='grade-10-anchor selected-anchor' href='#2'>Grade 10</a></div>
				<div><a class='grade-11-anchor' href='#3'>Grade 11</a></div>
				<div><a class='grade-12-anchor' href='#4'>Grade 12</a></div>
				<div><a class='submit-anchor' href='#5'>Submit</a></div>
			</div>
			<div class='class-schedule noselect' id='classes-10'>
                <h3 class='subtitle'>Your Schedule</h3>
				<label class='chosen_class' id='10-1'><span>1</span></label>
				<label class='chosen_class' id='10-2'><span>2</span></label>
				<label class='chosen_class' id='10-3'><span>3</span></label>
				<label class='chosen_class' id='10-4'><span>4</span></label>
				<label class='chosen_class' id='10-5'><span>5</span></label>
				<label class='chosen_class' id='10-6'><span>6</span></label>
				<label class='chosen_class' id='10-7'><span>7</span></label>
				<label class='chosen_class' id='10-8'><span>8</span></label>
			</div>
            <h3 class='subtitle'>Possible Classes for Sophomores</h3>
			<div class='class-selector noselect' id='possible-classes-10'>
				<?php echo createSelector('10') ?>
			</div>
			<div class='class-info-box' id='class-info-box-10'>
			</div>
		</div>
		<div id='page-3' hidden>
			<!-- <div class='header noselect' id='header-11'>
				<p>Grade 11</p>
			</div> -->
			<div class='header noselect' id='header-11'>
				<div><a class='grade-9-anchor' href='#1'>Grade 9</a></div>
				<div><a class='grade-10-anchor' href='#2'>Grade 10</a></div>
				<div><a class='grade-11-anchor selected-anchor' href='#3'>Grade 11</a></div>
				<div><a class='grade-12-anchor' href='#4'>Grade 12</a></div>
				<div><a class='submit-anchor' href='#5'>Submit</a></div>
			</div>
			<div class='class-schedule noselect' id='classes-11'>
                <h3 class='subtitle'>Your Schedule</h3>
				<label class='chosen_class' id='11-1'><span>1</span></label>
				<label class='chosen_class' id='11-2'><span>2</span></label>
				<label class='chosen_class' id='11-3'><span>3</span></label>
				<label class='chosen_class' id='11-4'><span>4</span></label>
				<label class='chosen_class' id='11-5'><span>5</span></label>
				<label class='chosen_class' id='11-6'><span>6</span></label>
				<label class='chosen_class' id='11-7'><span>7</span></label>
				<label class='chosen_class' id='11-8'><span>8</span></label>
			</div>
            <h3 class='subtitle'>Possible Classes for Juniors</h3>
			<div class='class-selector noselect' id='possible-classes-11'>
				<?php echo createSelector('11') ?>
			</div>
			<div class='class-info-box' id='class-info-box-11'>
			</div>
		</div>
		<div id='page-4' hidden>
			<div class='header noselect' id='header-12'>
				<div><a class='grade-9-anchor' href='#1'>Grade 9</a></div>
				<div><a class='grade-10-anchor' href='#2'>Grade 10</a></div>
				<div><a class='grade-11-anchor' href='#3'>Grade 11</a></div>
				<div><a class='grade-12-anchor selected-anchor' href='#4'>Grade 12</a></div>
				<div><a class='submit-anchor' href='#5'>Submit</a></div>
			</div>
			<div class='class-schedule noselect' id='classes-12'>
                <h3 class='subtitle'>Your Schedule</h3>
				<label class='chosen_class' id='12-1'><span>1</span></label>
				<label class='chosen_class' id='12-2'><span>2</span></label>
				<label class='chosen_class' id='12-3'><span>3</span></label>
				<label class='chosen_class' id='12-4'><span>4</span></label>
				<label class='chosen_class' id='12-5'><span>5</span></label>
				<label class='chosen_class' id='12-6'><span>6</span></label>
				<label class='chosen_class' id='12-7'><span>7</span></label>
				<label class='chosen_class' id='12-8'><span>8</span></label>
			</div>
            <h3 class='subtitle'>Possible Classes for Seniors</h3>
			<div class='class-selector noselect' id='possible-classes-12'>
				<?php echo createSelector('12') ?>
			</div>
			<div class='class-info-box' id='class-info-box-12'>
			</div>
		</div>
		<div id='page-5' hidden>
			<div class='header noselect' id='header-submit'>
				<div><a class='grade-9-anchor' href='#1'>Grade 9</a></div>
				<div><a class='grade-10-anchor' href='#2'>Grade 10</a></div>
				<div><a class='grade-11-anchor' href='#3'>Grade 11</a></div>
				<div><a class='grade-12-anchor' href='#4'>Grade 12</a></div>
				<div><a class='submit-anchor selected-anchor' href='#5'>Submit</a></div>
			</div>
			<div>
				<div class='info-input'>
					<p>Name:</p>
					<input id='info-name' type='text'></input>
				</div>
				<div class='info-input'>
					<p>Counselor:</p>
					<!-- <input id='info-counselor' type='text'></input> -->
					<select id='info-counselor'>
						<option></option>
						<option>Burke</option>
						<option>Hamblin</option>
						<option>Ketchem</option>
						<option>McAleer</option>
						<option>McNichol</option>
						<option>Palmer</option>
						<option>Scott</option>
						<option>Smith</option>
					</select>
				</div>
				<div class='info-input'>
					<p>Class of :</p>
					<!-- <input id='info-class' type='text'></input> -->
					<select id='info-class'>
						<option></option>
						<option>2015</option>
						<option>2016</option>
						<option>2017</option>
						<option>2018</option>
						<option>2019</option>
						<option>2020</option>
					</select>
				</div>
				<div class='info-input'>
					<input type='button' class='noselect' id='complete-button' onclick='createSchedulePDF()' value='Create PDF'></input>
				</div>
                <div id='verify'>
                    
                </div>
        
                <div id='todolist' style='width: initial; height: initial; position: absolute; bottom: 5px; right: 5px;'>
                    Todo List
                    <ul>
                        <li>Verification</li>
                        <li>Restructure to use IDs + names</li>
                        <li>Print Semester Courses</li>
                        <li>Suggest Class Type Instead of 1-8</li>
                        <li>Support Online Classes</li>
                    </ul>
                </div>
			</div>
		</div>
		<div id='footer'>
			<select id='file-select'>
				<option>FILES</option>
                <optgroup label='CSS'></optgroup>
				<option>css/styles.css</option>
				<option>css/styles-old.css</option>
                <optgroup label='DATA'></optgroup>
				<option>data/classes.txt</option>
				<option>data/parsed-classes.txt</option>
				<option>data/tmp.txt</option>
                <optgroup label='JS'></optgroup>
				<option>js/script.js</option>
				<option>js/set-up-verify.js</option>
                <optgroup label='PHP'></optgroup>
                <option>index.phps</option>
				<option>php/class-selector.phps</option>
				<option>php/create-course-json.phps</option>
				<option>php/get-classes.phps</option>
				<option>php/get-info.phps</option>
				<option>php/verify.phps</option>
			</select>
		</div>
		<script src='//code.jquery.com/jquery-1.11.2.min.js'></script>
		<script type='text/javascript' src='js/script.js'></script>
		<script type='text/javascript' src='js/set-up-verify.js'></script>
		<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js'></script>
		<script type="text/javascript" src="https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/ext/jsPDF/jspdf.js"></script>
		<script type="text/javascript" src="https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/ext/jsPDF/jspdf.plugin.standard_fonts_metrics.js"></script> 
		<script type="text/javascript" src="https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/ext/jsPDF/jspdf.plugin.split_text_to_size.js"></script>               
		<script type="text/javascript" src="https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/ext/jsPDF/jspdf.plugin.from_html.js"></script>
		<script type="text/javascript" src="https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/ext/jsPDF/libs/FileSaver.js/FileSaver.js"></script>
	</body>
</html>