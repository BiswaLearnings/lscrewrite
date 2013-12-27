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
// @Created by Biswakalyana Mohanty                                                      //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>


<?php
                //TO DO

require_once __SITE_PATH . '/libs/form_handler.php';
include_once __SITE_PATH . '/lang/lang.php';

foreach($data as $dataKey=>$dataValue){
	if ($dataKey=='fieldValues'){
		$fieldvalues=$dataValue;
	}
	if ($dataKey=='message') {
		$message=$dataValue;
	}
	
}

			$form = new lscform();
            $form->openForm(array('name'=>'skillport_details','action'=>'?load=userQuiz/saveSkillportDetails/'.$data["module_Id"].'/'.$data["module_name"])) ;
            $form->openTable(array('align'=>'center'));
            $form->openTableRow();
            $form->openTableColumn();
            $form->addCustomLabel('Scores obtained in Skillport Assessment(%)<font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Scores obtained in Skillport Assessment(%)','style'=>' width : 25em'));
            $form->closeTableColumn();
            $form->openTableColumn();
            if(isset($fieldvalues["skillport_score"])){
            	$value = $fieldvalues["skillport_score"];
            }
            else $value = null;
            $form->addInput('text',array('name'=>'skillport_score','value'=>$value,'style'=>' width : 12em','onkeydown'=>'return onlyNumeric(event)'));
            $form->closeTableColumn();
            $form->closeTableRow();
            $form->openTableRow();
            $form->openTableColumn();
            $form->addCustomLabel('Attach your skillport Certificate here<font color="red">&nbsp;&nbsp;*</font>', array('for'=>'Attach your skillport Certificate here','style'=>' width : 25em'));
            $form->closeTableColumn();
            $form->openTableColumn();
            $form->addInput('file',array('name'=>'skillport_certificate'));
            $form->closeTableColumn();
            $form->closeTableRow();
            $form->closeTable();
            $form->addInline('<p align="center">');
            $form->addInline('<font color = "grey"><b> Note: </b>By Continuing forward, the certificate would be sent to LSC Adminfor Skillport course completion.<br><br></font>');
            $form->addInput('submit', array('name'=>'submit','value'=>'Continue'));
            $form->addInline('</p>');
            $form->closeForm();
            echo $form;
	
            
 /** Error messages **/
$errorMessage='';
if (!empty($message)) {
    	$errorMessage = implode($message, '\n');
    
    echo '<script type="text/javascript"> $(document).ready(function(){ alert("'.$errorMessage.'"); });</script>';
}
	?>