<?php
    $chosenClasses = json_decode($_POST['chosenClasses'], true);
	$parsed_classes = json_decode(file_get_contents('../data/parsed-classes.txt'), true);


    function find($attr, $value){
        global $parsed_classes;
        foreach($parsed_classes as $s){
            foreach($s as $c){
                if($c[$attr] == $value){
                    return $c;   
                }
            }
        }
        return 'ERROR';
    }


    //==================================================================================================== ERROR DEFINITIONS
    /*
    A. Class Slots 1-7 not filled for any grade
    B. 
    */
    //==================================================================================================== 
    $errorA = [];
    $errorB = [];

    $graduationRequirements = [
        'English' => 4,
        'Mathematics' => 4,
        'Laboratory Science' => 4,
        'History and Social Sciences' => 4,
        'Foreign Languages' => 3,
        'Health and Physical Education' => 2,
        'Economics and Personal Finance' => 1,
        'Fine Arts or Career and Technical Ed' => 1,
        'Electives' => 3,
        'Other' => 0,
        'total' => 26
    ];
    $credits = [
        'English' => 0,
        'Mathematics' => 0,
        'Laboratory Science' => 0,
        'History and Social Sciences' => 0,
        'Foreign Languages' => 0,
        'Health and Physical Education' => 0,
        'Economics and Personal Finance' => 0,
        'Fine Arts or Career and Technical Ed' => 0,
        'Electives' => 0,
        'Other' => 0,
        'total' => 0
    ];
	for($g = 9; $g <= 12; $g++){
		for($c = 1; $c <= 8; $c++){
            $class = find('title', $chosenClasses[$g . '-' . $c]);
            //    1  2
            //    N  N  F
            //    N  S  F
            //    S  N  T (unless S credits 0.5)
            //    S  S  T
            if($class == 'ERROR'){
                $errorA[] = 'No class selected for class slot ' . $c . ' for ' . $g . 'th grade';
                continue;
            }
            if($c != 8){
                if($chosenClasses[$g . '-' . $c] == null){
                    $errorA[] = 'No class selected for class slot ' . $c . ' for ' . $g . 'th grade';
                } else if($chosenClasses[$g . '-' . $c . '-2'] == null && $class['credits'] == '0.5'){
                    $errorA[] = 'No class selected for class slot ' . $c . '-2 for ' . $g . 'th grade';
                }
            }
            
//            print_r($parsed_classes);
//            echo $parsed_classes[$chosenClasses[$g . '-' . $c]];
//            foreach($parsed_classes as $subject){
//                foreach($subject as $class){
//                    if($class['title'] == $chosenClasses[$g . '-' . $c]){
//            echo '|' . $class['subject'] . '|';
            $credits['total'] += 1;
            switch($class['subject']){
                case 'Computer Science':
                    $credits['Electives'] += 1;
                    break;
                case 'English':
                    $credits['English'] += 1;
                    break;
                case 'Health and PE':
                    $credits['Health and Physical Education'] += 1;
                    break;
                case 'Math':
                    $credits['Mathematics'] += 1;
                    break;
                case 'Performing Arts':
                    $credits['Electives'] += 1;
                    break;
                case 'Science':
                    $credits['Laboratory Science'] += 1;
                    break;
                case 'Senior Research':
                    $credits['Electives'] += 1;
                    break;
                case 'Social Studies':
                    $credits['History and Social Sciences'] += 1;
                    break;
                case 'Technology':
                    if($class['title'] == 'Design and Technology'){
                        $credits['Fine Arts or Career and Technical Ed'] += 1;
                    } else {
                        $credits['Electives'] += 1;
                    }
                    break;
                case 'Visual Arts':
                    $credits['Electives'] += 1;
                    break;
                case 'World Languages':
                    $credits['Foreign Languages'] += 1;
                    break;
                default:
                    $credits['total'] -= 1;
                    break;
            }
//                    }
//                }
//            }
		}
	}
    
    print_r($credits);
    foreach($credits as $subjectarea){
        if($credits[$subjectarea] < $graduationRequirements[$subjectarea]){
            $errorB[] = 'You have ' . $credits[$subjectarea] . ' credits in ' . $subjectarea . ', but you need ' . $graduationRequirements[$subjectarea] . ' credits';
            print($errorB);
        }
    }

    print_r($errorA);
    echo '-===-';
    print_r($errorB);
?>