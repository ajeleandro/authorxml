$(document).ready(function () {$("#loadingcategories").bind("change", function (event) {$.ajax({async:true, data:$("#loadingcategories").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory\/before:%24%28%22%23loadingcategories%22%29.fadeIn%28%29%3B\/success:%24%28%22%23loadingcategories%22%29.fadeOut%28%29%3B"});
return false;});});