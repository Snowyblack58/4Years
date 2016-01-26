function getChosenClasses(){
    var chosenClasses = {};
    for(var g = 9; g <= 12; g++){
        for(var c = 1; c <= 8; c++){
            chosenClasses[g + '-' + c] = localStorage.getItem(g + '-' + c);
            chosenClasses[g + '-' + c + '-2'] = localStorage.getItem(g + '-' + c + '-2');
        }
    }
    return chosenClasses;
}


$(window).on('hashchange', function(e){
	if(parseInt(window.location.hash.substring(1)) == 5){
        $.ajax({
            url: 'https://www.tjhsst.edu/~2016dzhao/SideProjects/4Years/php/verify.php',
            type: 'POST',
            data: {
                chosenClasses: JSON.stringify(getChosenClasses())
            },
            success: function(result){
                $('#verify').html(result);
                console.log('boo');
            }
        });
    }
});