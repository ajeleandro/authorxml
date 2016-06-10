<script>

    function resetinputs(form) {
         document.getElementById(form).reset();
         var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
    	        var cookie = cookies[i];
    	        var eqPos = cookie.indexOf("=");
    	        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    $("document").ready(function () {

        //Gets all the text inputs and dropdowns selects and then puts the cookie values
        var inputs3 = $('#VideoChaptersAndCueFrames');
        for (var i = 0; i < inputs3.length; i++) {
            inputs3[i].value = readCookie(inputs3[i].id);
        }

        var inputs4 = $('#VideoOtherInstructions');
        for (var i = 0; i < inputs4.length; i++) {
            inputs4[i].value = readCookie(inputs4[i].id);
        }

        var inputs = $('input[type=text]');
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = readCookie(inputs[i].id);
        }

        var inputs2 = $('select');
        for (var i = 0; i < inputs2.length; i++) {
            inputs2[i].value = readCookie(inputs2[i].id);
        }

        //on submit delete the cookie
        $(".submit").click(function (event) {
            var cookies = document.cookie.split(";");

            for (var i = 0; i < cookies.length; i++) {
    	        var cookie = cookies[i];
    	        var eqPos = cookie.indexOf("=");
    	        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    	        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
            }
        });
    });

    //On input text change saves the value in the cookie
    $('#VideoChaptersAndCueFrames').on('input', function () {
        document.cookie = $(this).attr('id') + "=" + $(this).val();
    });

    $("#VideoChaptersAndCueFrames").bind("paste", function(e){
        $('<p style="color: red;font-size: 11px;margin-left: 7px;margin-top: -19px;">Warning with pasting text in the field Video Chapters And CueFrames, it might be gone if the page is reloaded</p>').insertAfter( "#VideoChaptersAndCueFrames" );       
    });

    $('#VideoOtherInstructions').on('input', function () {
        document.cookie = $(this).attr('id') + "=" + $(this).val();
    });

    $('input[type=text]').on('input', function () {
        document.cookie = $(this).attr('id') + "=" + $(this).val();
    });

    $('select').on('input', function () {
        document.cookie = $(this).attr('id') + "=" + $(this).val();
    })

    function unselect(textarea){
        $(textarea).find("option").attr("selected", false);
    }
</script>