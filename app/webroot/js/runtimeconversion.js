$('#VideoDuration').on('focusout', function () {
    var original = $(this).val();
    var splited = original.split(":");
    if (splited.length == 3) {
        var myregex = /(\d+):(\d+):(\d+)/g;
        var matches = myregex.exec(original);
        var hours = parseInt(matches[1]);
        var mins = parseInt(matches[2]);
        var secs = parseInt(matches[3]);
        if (hours == 1) {
            var hourstext = "1 hour";
        } else {
            var hourstext = hours + " hours";
        }
        if (mins == 1) {
            var minstext = "1 min";
        } else {
            if (mins == 0) {
                var minstext = "";
            } else {
                var minstext = mins + " mins";
            }
        }
        if (secs > 29) {
            if (mins == 0) {
                minstext = "1 min";
            } else {
                if ((mins + 1) == 60) {
                    minstext = "";
                    hourstext = (hours + 1) + " hours";
                } else {
                    minstext = (mins + 1) + " mins";
                }
            }
        }
        if (minstext == "") {
            var final = hourstext;
        }
        else{
            var final = hourstext + ", " + minstext;            
        }
        $(this).val(final);
        document.cookie = $("#VideoDuration").attr('id') + "=" + $("#VideoDuration").val();
    } else {
        if (splited.length == 2) {
            var myregex = /(\d+):(\d+)/g;
            var matches = myregex.exec(original);
            var mins = parseInt(matches[1]);
            var secs = parseInt(matches[2]);
            if (mins == 1) {
                var minstext = "1 min";
            } else {
                var minstext = mins + " mins";
            }
            if (secs == 1) {
                var sectext = "1 sec";
            } else {
                if (secs == 0) {
                    var sectext = "";
                } else {
                    var sectext = secs + " secs";
                }
            }
            if (mins == 0) {
                var final = sectext;
            } else {
                if (secs == 0) {
                    var final = minstext;
                } else {
                    var final = minstext + ", " + sectext;
                }
            }
            $(this).val(final);
            document.cookie = $("#VideoDuration").attr('id') + "=" + $("#VideoDuration").val();
        }
    }
});