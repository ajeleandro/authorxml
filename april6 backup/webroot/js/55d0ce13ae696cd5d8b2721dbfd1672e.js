$(document).ready(function () {$("#ParentCategoryId").bind("change", function (event) {$.ajax({async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
return false;});
$("#ParentCategoryId").bind("load", function (event) {$.ajax({async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
return false;});});