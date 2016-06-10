<?php
    echo $this->Form->input('category_id', 
            array(
                'label' => 'Sub Categories',
                'id' => 'subcategory',
                'type' => 'select',
                'required' => FALSE,
                'options' => $subcategories,
                'empty' => array(NULL => '')
            ));
?>