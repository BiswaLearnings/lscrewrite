<?php

//////////////////////////////////////////////////////////////////////////////////////////
//                                                                       	   			//
// NOTICE OF COPYRIGHT                                                   	   			//
//                                                                       	   			//
//                                                                       	   			//
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com    		//
//                                                                       	   			//
// This program is free software: you can redistribute it and/or modify  	   			//
// it under the terms of the GNU General Public License as published by  	   			//
// the Free Software Foundation, either version 3 of the License, or     	   			//
// (at your option) any later version.                                   	   			//
//                                                                                 		//
// This program is distributed in the hope that it will be useful,                 		//
// but WITHOUT ANY WARRANTY; without even the implied warranty of                  		//
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                   		//
// GNU General Public License for more details.                                    		//
//                                                                                 		//
//  You should have received a copy of the GNU General Public License              		//
//  along with this program.If not, see <http://www.gnu.org/licenses/>.            		//
//							                           									//
// @Created by Achappan Mahalingam                                                      //
// @date 2012-03-20                                                      	   			//
// @version 1.0								       										//
// @description:                              				//
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

include_once __SITE_PATH . '/lang/lang.php';
require_once __SITE_PATH . '/libs/form_handler.php';

$form = new lscform();


$form->openForm(array('method' => 'POST', 'action' => '?load=resource/bulkUploadResource', 'name' => 'importForm', 'enctype' => "multipart/form-data"));
//$form->openFieldset();
//$form->addLegend("Bulk Upload Resources");
$form->addInline('<br />');
$form->addLabel('Upload File', array('for' => 'Import File'));
$form->addInput('file', array('name' => 'importFile', 'value' => 'importFile'));
$form->addInline('<br /><div style="padding: 10px 55px 0 150px">');
$form->addButton('submit', array('name' => 'submit', 'value' => 'Upload'));
$form->addInline('</div>');
$error_flag = 0;
$count = 0;

if (!empty($callback)) {

    foreach ($callback as $value) {
        if ($count == 0) {
            echo "<font color='red'><h6>Excel contains below errors:</h6></font>";
        }

        if (!empty($value)) {
            echo "<br><font color='red'><b>*</b> " . $value . "</font>";
        }

        $error_flag = 1;
        $count++;
    }
}


if ($error_flag == 0) {
    if (!empty($data)) {

        echo "<center><font color='green'>Data inserted success fully!</font></center>";

        //Form Start
        $form->openTable(array('name' => 'bulkUploadResource_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
        $form->openTableHeader();
        $form->openTableRow();
        $form->addTableHead($lang[firstname] . " / " . $lang[lastname]);
        $form->addTableHead($lang[email]);
        $form->addTableHead($lang[city]);
        $form->addTableHead($lang[country]);
        $form->addTableHead($lang[isactive]);
        $form->closeTableRow();
        $form->closeTableHeader();
        $form->openTableBody();


        foreach ($data as $value) {
            $form->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
            $form->addTableColumn('<a href="?load=resource/resourceProfile/' . $value[username] . '">' . $value[firstname] . ' ' . $value[lastname] . '</a>');
            $form->addTableColumn($value[email_address]);
            $form->addTableColumn($value[city]);
            $form->addTableColumn($value[country]);
            if ($value[is_active] == 1) {
                $form->addTableColumn('Yes');
            } else {
                $form->addTableColumn('No');
            }
            $form->closeTableRow();
        }

        $form->closeTableBody();
        $form->closeTable();
    }
}
//$form->closeFieldset();
$form->closeForm();
echo $form;
?>