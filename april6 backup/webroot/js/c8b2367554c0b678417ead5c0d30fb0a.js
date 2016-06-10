$(document).ready(function () {$("#ParentCategoryId").bind("change", function (event) {$.ajax({async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {$("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
return false;});

     
     
     ->alert( 'Page loaded!2' );
     ->get('#ParentCategoryId')->event('change', 
     ->request(array(
        'controller'=>'videos',
        'action'=>'getbycategory'
        ), array(
            'update'=>'#categories',
            'async' => true,
            'method' => 'post',
            'dataExpression'=>true,
            'data'=> ->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
    );

     
     
     
     
     });