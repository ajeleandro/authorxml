$('#BrightcovecsvBrightcovecsv').on('input', function () {
    var csvvalue = ($(this).val());
    var complete = regexFunction('#BrightcovecsvBrightcovecsv');
    $(this).val('');
    $('#BrightcovecsvCsvlist').find('option').remove().end();//delete the list
    $('#BrightcovecsvCsvlist').append($('<option>', {
        value: complete,
        text: complete
    }));
    $("#copy").attr("data-clipboard-text", complete);
    var all = $("#copyall").attr("data-clipboard-text");
    all = all + complete;
    $("#copyall").attr("data-clipboard-text", all);
});

$('#VideoBrightcovecsv').on('input', function () {
    var csvvalue = ($(this).val());
    var complete = regexFunction('#VideoBrightcovecsv');
    $(this).val('');
    var splited = complete.split("\t");
    $("#VideoVideoid").val(splited[0]);
    $("#VideoWidth").val(splited[1]);
    $("#VideoHeight").val(splited[2]);
    $("#VideoPlayer").val(splited[3]);
    $("#VideoPlayerkey").val(splited[4]);
    document.cookie = $("#VideoVideoid").attr('id') + "=" + $("#VideoVideoid").val();
    document.cookie = $("#VideoWidth").attr('id') + "=" + $("#VideoWidth").val();       
    document.cookie = $("#VideoHeight").attr('id') + "=" + $("#VideoHeight").val();
    document.cookie = $("#VideoPlayer").attr('id') + "=" + $("#VideoPlayer").val();
    document.cookie = $("#VideoPlayerkey").attr('id') + "=" + $("#VideoPlayerkey").val();
});

function regexFunction(id) {
    var str = $(id).val();
    var complete = '';
    var myregex = /(?:value=")(.*)"/g;
    var matches = myregex.exec(str);
    for (i = 0; i < 8; i++) {
        switch (i) {
            case 1:
                var width = matches[1];
                complete = matches[1];
                break;
            case 2:
                var height = matches[1];
                complete = complete + "\t" + matches[1];
                break;
            case 3:
                var playerid = matches[1];
                complete = complete + "\t" + matches[1];
                break;
            case 4:
                var playerkey = matches[1];
                complete = complete + "\t" + matches[1];
                break;
            case 7:
                var brightcoveid = matches[1];
                //complete =  matches[1] + "\t" + complete + "\n"; the \n will mess when adding at the end the duration without the conversion
                complete = matches[1] + "\t" + complete;
                break;
        }
        matches = myregex.exec(str);
    }
    return(complete);
}