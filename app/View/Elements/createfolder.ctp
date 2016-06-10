<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  <script>
      $(function () {
          var dialog, form,

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
                  createfolder(name.val());
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
<button style="padding: 2px !important;" class="createfolderbutton" id="create-user">Create New Folder</button> 
</body>
<?php 
 if(isset($this->params['pass'][0])) 
    $param = $this->params['pass'][0];
 else{
    $param = 0;
 }
?>

<script>
    function createfolder(name){
        window.location.href = "/Dirs/" + "<?php echo $listorgrid; ?>" + "/" + "<?php echo $param; ?>" + "/" + name + "/" + "<?php echo $Dir_name; ?>";
    }
</script>