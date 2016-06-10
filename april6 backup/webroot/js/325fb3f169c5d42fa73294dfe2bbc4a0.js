$(document).ready(function () {$("#ParentCategoryId").bind("change", function (event) {$.ajax({async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
return false;});
$("#refreshcategories2").bind("click", function (event) {$.ajax({async:true, data:$("#refreshcategories2").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory\/data:something"});
return false;});});