

  <meta charset="utf-8">
  <title>jQuery UI Dialog - Modal form</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <style>
    /*body { font-size: 62.5%; }*/
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <script>
      $(function () {
          var dialog, form,

          // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
          emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
          name = $("#name"),
          allFields = $([]).add(name),
          tips = $(".validateTips");

          function updateTips(t) {
              tips
            .text(t)
            .addClass("ui-state-highlight");
              setTimeout(function () {
                  tips.removeClass("ui-state-highlight", 1500);
              }, 500);
          }

          function checkLength(o, n, min, max) {
              if (o.val().length > max || o.val().length < min) {
                  o.addClass("ui-state-error");
                  updateTips("Length of the " + n + " must be between " +
              min + " and " + max + ".");
                  return false;
              } else {
                  return true;
              }
          }

          function checkRegexp(o, regexp, n) {
              if (!(regexp.test(o.val()))) {
                  o.addClass("ui-state-error");
                  updateTips(n);
                  return false;
              } else {
                  return true;
              }
          }

          function addFolder() {
              var valid = true;
              allFields.removeClass("ui-state-error");

              valid = valid && checkLength(name, "folder name", 3, 16);
              if (valid) {
                  $("#users tbody").append("<tr>" + "<td>" + name.val() + "</td>" + "</tr>");
                  alert(name.val());
                  dialog.dialog("close");
              }
              console.log(name.val());
              return valid;
          }

          dialog = $("#dialog-form").dialog({
              autoOpen: false,
              height: 300,
              width: 350,
              modal: true,
              buttons: {
                  "Create Folder": addFolder,
                  Cancel: function () {
                      dialog.dialog("close");
                  }
              },
              close: function () {
                  form[0].reset();
                  allFields.removeClass("ui-state-error");
              }
          });

          form = dialog.find("form").on("submit", function (event) {
              event.preventDefault();
              addFolder();
          });

          $("#create-user").button().on("click", function () {
              dialog.dialog("open");
          });
      });
  </script>
</head>
<body>
 
<div id="dialog-form" title="Create New Folder">
 <p class="validateTips"></p>
  <form>
    <fieldset>
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
 
 
<div id="users-contain" class="ui-widget">
  <h1>Existing Users:</h1>
  <table id="users" class="ui-widget ui-widget-content">
    <thead>
      <tr class="ui-widget-header ">
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
<button id="create-user">Create New Folder</button>
 
 
</body>