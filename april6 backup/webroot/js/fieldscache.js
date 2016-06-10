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
        delete_cookie('x');
    });
});

//On input text change saves the value in the cookie
$('input[type=text]').on('input', function () {
    document.cookie = $(this).attr('id') + "=" + $(this).val();
});

$('select').on('input', function () {
    document.cookie = $(this).attr('id') + "=" + $(this).val();
})
