<?php
    echo $this->Form->input('category_id', 
            array(
                'label' => 'SubCategory',
                'id' => 'subcategory',
                'type' => 'select',
                'required' => FALSE,
                'options' => $subcategories,
                'empty' => array(NULL => '')
            ));

?>

<script>

$('select').on('input', function () {
		document.cookie = $(this).attr('id') + "=" + $(this).val();
})

var inputs5 = $('select');
for (var i = 0; i < inputs5.length; i++) {
		inputs5[i].value = readCookie(inputs5[i].id);
}

</script>

