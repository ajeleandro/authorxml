$(document).ready(function () {$("#submit-297330410").bind("click", function (event) {$.ajax({beforeSend:function (XMLHttpRequest) {$("#sending").fadeIn();}, data:$("#submit-297330410").closest("form").serialize(), dataType:"html", success:function (data, textStatus) {$("#sending").fadeOut();$("#success").html(data);}, type:"post", url:"\/videos\/add"});
return false;});
$("#ParentCategoryId").bind("change", function (event) {$.ajax({async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {$("#success").html(data);}, type:"post", url:"\/videos\/getbycategory"});
return false;});});