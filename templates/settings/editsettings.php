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
// @Created by                                                        //  
// @date 2012-12-12                                                      	   			// 
// @version 1.0								       										// 
// @description:                             	    // 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?><script type="text/javascript">
function validatecombotype(combotype){
		var inputVal=combotype.value;
	   
		if (inputVal=='12'){
			makeEnable();
		}
		else {
			makeDisable();
			 
		}
	}
	function makeDisable(){
		document.getElementById("divName").style.visibility='hidden';
	}
	function makeEnable(){
		document.getElementById("divName").style.visibility='visible';
	}
	</script>
<?php
                //TO DO

                require_once __SITE_PATH . '/libs/form_handler.php';
                if (!empty($error)) {
                	foreach ($error as $value)
                	{
                		echo "<font color='red' size='2' face='verdana'>".$value ."<br></font>";
                	}
                }
             
                if (!empty($pagefields)) 
                {
                	$id = $pagefields['id'];
                	$Combovalue = $pagefields['Combovalue'];
                	$combotype = $pagefields['combotype'];
                	$timedetails= $pagefields['timezonedetails'];
                	$isactive = $pagefields['isactive'];
                }else
                {
                	$Combovalue = '';
                	$combotype = '';
                	$timedetails='';
                	$isactive =1;
                }
               
                $form = new lscform();
                $form->openForm(array('action' => '?load=settings/updatesettingsview', 'name' => 'editSettingsForm'));
                $form->addInline('<br />');
                $form->addLabel('Combo Type', array('for' => 'Combo Type ' ));
                $form->openSelect(array('name' => 'combotype','onchange'=>'validatecombotype(this)'));
                $form->addOption('Select the value',array('value'=>0));
                foreach ($data as $value)
                { 
                	if ($value['id']==$combotype)
					{
                		$form->addOption($value['type'],array('value'=>$value['id'] ,'selected'=>'selected' ));
                	}else
					{
						$form->addOption($value['type'],array('value'=>$value['id']  ));
					}
                }
                $form->closeSelect();
                $form->addInline('<br/>');
                $form->addLabel('Combo Value', array('for' => 'Combo Value: '));
                $form->addInput('text', array('name' => 'Combovalue','value'=> $Combovalue ));
                $form->addInline('<br />');
                $form -> addLabel ('Is Active', array ('for' => 'MyCheck'));
                if ($isactive ==1)
                {
              	  $form -> addInput ('checkbox', array ('id' => 'MyCheck', 'name' => 'isactive', 'test' => 'test','checked'=> 'checked'));
                }
                else 
                {
                	$form -> addInput ('checkbox', array ('id' => 'MyCheck', 'name' => 'isactive', 'test' => 'test' ));
                }
                $form->addInline('<br />');
           
               if ($combotype == 12)
               { 
               	  $form->addInline('<div id = "divName" name = "time"  >');
               }else 
               {
               	    $form->addInline('<div id = "divName" name = "time" , style ="visibility:hidden">');
               }
                $form->addLabel('Time Details');
                $form->addInput('text', array('name' => 'timedetails','value'=> $timedetails  ));
                $form->addInline('<br />');
                $form->addInline('</div>');
               
                $form -> addLabel (' ',  '');
                $form->addButton('submit', array('name' => 'save', 'value' => 'Update', 'style' => 'background:#0066A2;color:white;border-style:outset;border-color:#0066A2;height:30px;width:100px;font: bold 15px arial,sans-serif;'));
                $form->addInput('hidden', array('name' => 'id','value'=> $id ));
                $form->closeForm();
                //echo '<div style="border: 1px solid darkgrey; text-align: center; width:430px;">';
                echo $form;
                //echo '</div>';
                ?>
                