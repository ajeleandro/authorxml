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
    if (window.categoryload == 1) {
        window.categoryload = 2;
        $("#categories select").val("<?php echo $selected; ?>");
    }
</script>