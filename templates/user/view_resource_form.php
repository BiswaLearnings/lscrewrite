<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php
            require_once __SITE_PATH . '/libs/form_handler.php';

            $form = new lscform();
            //Form Start
            $form->openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewResource', 'name' => 'viewResource'));
            $form->addInline('<div class="jquery-table" >');
            $form->openTable(array('name' => 'view_resource_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
            $form->openTableHeader();
            $form->openTableRow();
            //$form->addTableHead($lang[shortid]);
            $form->addTableHead($lang[firstname] ." / ". $lang[lastname]);
            //$form->addTableHead($lang[lastname]);
            $form->addTableHead($lang[email]);
            $form->addTableHead($lang[city]);
            $form->addTableHead($lang[country]);
            $form->addTableHead($lang[isactive]);
            $form->addTableHead($lang[edit]);
            $form->closeTableRow();
            $form->closeTableHeader();
            $form->openTableBody();

            if (!empty($data)) {
                foreach ($data as $value) {
                    $form->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
                    //$form->addTableColumn($value[username]);
                    $form->addTableColumn('<a href="?load=resource/resourceProfile/'.$value[id].'">'.$value[first_name].' '.$value[last_name].'</a>');
                    //$form->addTableColumn($value[lastname]);
                    $form->addTableColumn($value[email_address ]);
                    $form->addTableColumn($value[city]);
                    $form->addTableColumn($value[country]);
                    if($value[is_active]==1){
                    $form->addTableColumn('Yes');
                    }else{
                        $form->addTableColumn('No');
                    }

                    $form->addTableColumn('<a href="?load=resource/editResource/'.$value[id].'">Edit</a>');
                    $form->closeTableRow();
                }
            }

            $form->closeTableBody();
            $form->closeTable();
            $form->addInline('</div>');
            $form->closeForm();

            echo $form;

?>