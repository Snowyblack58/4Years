/*jslint browser: true*/
/*global $, jQuery, alert, console*/
//declares variables
var selected;
var page = 0;
var classes = {};
var draggingClassFromChosen = false;
var draggingClassToChosen = false;
var draggedChosen;
var selectcolor = '#2FCC71';

//--------------------------------------------------GETters
function getShortTitle(title) {
	for(subject in classes) {
		for(c = 0; c < classes[subject].length; c++) {
			if(classes[subject][c]['title'] == title) {
				return classes[subject][c]['short title'];
			}
		}
	}
	return title;
}

function getCredits(title) {
	for(subject in classes) {
		for(var c = 0; c < classes[subject].length; c++) {
			if(classes[subject][c]['title'] == title) {
				return classes[subject][c]['credits'];
			}
		}
	}
	return title;
}

function getInfoHTML(title) {
	for(subject in classes) {
		for(var c = 0; c < classes[subject].length; c++) {
			if(classes[subject][c]['title'] == title) {
				tmp = classes[subject][c]['info'].split('===');
				html = '<div id="info">';
				html += '<h2>' + classes[subject][c]['title'] + ' (' + classes[
					subject][c]['credits'] + ')</h2>';
				for(var cnt = 0; cnt < tmp.length - 2; cnt++) {
					if(cnt % 2 == 0) {
						html += '<br><b>' + tmp[cnt] + '</b>';
					} else {
						html += '<br>' + tmp[cnt];
					}
				}
				html = html.substring(0, html.length) + '</div>';
				return html;
			}
		}
	}
	return title;
}

//--------------------------------------------------Navigation
function gotoPage(p) {
	$('#page-' + p).siblings().hide();
	$('#page-' + p).show();
	selected = '';
}	

//--------------------------------------------------Interaction
function createSchedulePDF() {
	//create jspdf
	var doc = jsPDF('landscape');
	//set font defaults
	doc.setFont("times");
	//write title
	doc.setFontType("bold");
	doc.setFontSize(18);
	doc.text(120, 20, 'CLASS OF ' + $('#info-class').val());
	//write bolded texts
	doc.setFontSize(12);
	doc.text(30, 20, 'Name: ' + $('#info-name').val());
	doc.text(210, 20, 'Counselor: ' + $('#info-counselor').val());
	doc.text(30, 40, 'NINTH GRADE');
	doc.text(90, 40, 'TENTH GRADE');
	doc.text(150, 40, 'ELEVENTH GRADE');
	doc.text(210, 40, 'TWELFTH GRADE');
	//write classes
	doc.setFontType("normal");
	for(var g = 9; g <= 12; g++) {
		var x = 60 * (g - 9) + 30;
		for(var c = 1; c <= 8; c++) {
			var y = 12 * c + 50;
			var classname = getShortTitle(localStorage.getItem(g + '-' + c) ||
				'');
			doc.text(x, y, classname);
		}
	}
	//download PDF
	doc.save('schedule.pdf');
}

function updateClickHandlers() {
	//---creates the drag and drop effect for classes
	//--clicking on a class === selects class/displays info, and makes it the subject of the drag and drop
	$('._class span').mousedown(function() {
		draggingClassToChosen = true;
		$('html *').css('cursor', 'move');
		$('.class-info-box').html(getInfoHTML($(this).text()));
		$('._class').css('background', '').css('color', '');
		$(this).parent().css('background', selectcolor).css('color',
			'#FFF');
		selected = $(this);
		$('.class-info-box').addClass('noselect');
	});
	//--mousing up
	//==============
	//-if dropped over class slot
	//--if full year class
	//---join and replace
	//--if semester class
	//---split and replace
	//-remove drag and drop effect
	$(document).mouseup(function(e) {
		console.log('mouseup');
		if(draggingClassToChosen) {
			console.log('draggingClassToChosen:' + draggingClassToChosen);
			if($(e.target).is('.chosen_class span')) {
				console.log(e);
				//if is original class slot or is semester course, then allow
				if($(e.target).parent().attr('id').match('^[0-9]*-[0-9]$') !=
					null || getCredits(selected.text()) == '0.5') {
					console.log('ORIGINAL or SEM')
					$(e.target).text(selected.text());
					localStorage.setItem($(e.target).parent().attr('id'), $(e.target)
						.text());
				}
				//if is original class slot and dropped class is a semester class and not already split, then split
				//else if is original class slot and dropped class is a full year class, then join
				if($(e.target).parent().attr('id').match('^[0-9]*-[0-9]$') !=
					null && getCredits(selected.text()) == '0.5' && $('#' + $(e.target)
						.parent().attr('id') + '-2').text() == '') {
					console.log('ORIGINAL + SEM')
					splitClassLabel($(e.target).parent().attr('id'));
				} else if($(e.target).parent().attr('id').match(
						'^[0-9]*-[0-9]$') != null && getCredits(selected.text()) ==
					'1.0') {
					console.log('ORIGINAL + FULL')
					joinClassLabel($(e.target).parent().attr('id'));
				}
			}
			$('.chosen_class span').css('background', '');
			$('.chosen_class span').css('color', '');
		} else if(draggingClassFromChosen) {
			if(!$(e.target).is('.chosen_class span')) {
				draggedChosen.children().text(draggedChosen.attr('id').substring(
					draggedChosen.attr('id').indexOf('-') + 1));
				localStorage.removeItem(draggedChosen.attr('id'));
			}
		}
		$('.class-info-box').removeClass('noselect');
		$('html *').css('cursor', 'default');
		$('a').css('cursor', 'pointer');
		draggingClassFromChosen = false;
		draggingClassToChosen = false;
	});
	//while drag and drop, hover chosen_class label
	$('.chosen_class span').mouseover(function() {
		if(draggingClassToChosen) {
			$(this).css('background', selectcolor).css('color', '#FFF');
		}
	}).mouseout(function() {
		if(draggingClassToChosen) {
			$(this).css('background', '').css('color', '');
		}
	});
	//escape from drag and drop if escape pressed
	$(document).keydown(function(e) {
		if(e.keyCode == 27 || e.which == 27) {
			if(draggingClassFromChosen || draggingClassToChosen) {
				$(document).trigger('mouseup');
			}
		}
		draggingClassFromChosen = false;
		draggingClassToChosen = false;
	});

	//    //alternative to drag and drop, just double click
	//	$('.chosen_class span').dblclick(function(){
	//        $(this).text(selected.text());
	//        localStorage.setItem($(this).parent().attr('id'), $(this).text());
	//	});


	//creates the drag and drop effect for classes
	$('.chosen_class').mousedown(function() {
		draggingClassFromChosen = true;
		draggedChosen = $(this);
		$('html *').css('cursor', 'move');
		$('.class-info-box').addClass('noselect');
	});
}

//give 9-1 id not 9-1-2
function joinClassLabel(id) {
	// var html = '<label class="chosen_class" id="' + id + '" style="width: 50%;">' + $('#' + id).html() + '</label>';
	$('#' + id).css('width', '100%');
	$('#' + id + '-2').remove();
	localStorage.removeItem(id + '-2');
	//	var html = '<label class="chosen_class" id="' + id + '-2" style="width: 50%;"><span>' + id.substring(id.indexOf('-') + 1) + '-2</span></label>';
	//	$('#' + id).after(html);
	updateClickHandlers();
}

function splitClassLabel(id) {
	// var html = '<label class="chosen_class" id="' + id + '" style="width: 50%;">' + $('#' + id).html() + '</label>';
	$('#' + id).css('width', '50%');
	var html = '<label class="chosen_class" id="' + id +
		'-2" style="width: 50%;"><span>' + id.substring(id.indexOf('-') + 1) +
		'-2</span></label>';
	$('#' + id).after(html);
	updateClickHandlers();
}

//--------------------------------------------------Initialization
function loadChoices() {
	for(var g = 9; g <= 12; g++) {
		for(var c = 1; c <= 8; c++) {
			$('#' + g + '-' + c + ' span').text(localStorage.getItem(g + '-' +
				c) || c);
			//			$('#' + g + '-' + c + ' span').attr('id', localStorage.getItem(g + '-' + c) || c);
			if(localStorage.getItem(g + '-' + c + '-2') != null) {
				splitClassLabel(g + '-' + c);
				$('#' + g + '-' + c + '-2 span').text(localStorage.getItem(g +
					'-' + c + '-2'));
			}
		}
	}
}

function init() {
	//initializes local CLASSES variable
	$.ajax({
		type: 'POST',
		url: 'https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/php/get-classes.php',
		success: function(result) {
			classes = JSON.parse(result);
			console.log(classes);
		},
		error: function(result) {
			console.error('GET CLASSES SCRIPT error: ' + result);
		}
	});

	//inserts courses into the HTML page
	$.ajax({
		type: 'GET',
		url: 'https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/php/create-course-json.php',
		success: function(result) {
			updateClickHandlers();
			//default the first info box to foundations of comp sci
			$('#3184T1 span').trigger('mousedown');
			$('#3184T1 span').trigger('mouseup');
		},
		error: function(result) {
			console.error('COURSE JSON SCRIPT error: ' + result);
		}
	});
}

//--------------------------------------------------Handlers
$(window).on('hashchange', function(e) {
	gotoPage(parseInt(window.location.hash.substring(1)));
});

$('#start-button').click(function() {
	gotoPage(1);
});

//stick to page that hash is
gotoPage(parseInt(window.location.hash.substring(1)));

//load stored choices
loadChoices();

//footer file select
$('#file-select').change(function() {
	if($('#file-select').val() != 'FILES') {
		window.location.href =
			'https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/' + $(
				'#file-select').val();
	}
});