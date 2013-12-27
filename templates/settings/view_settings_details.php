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
?>
<?php
                //TO DO

                require_once __SITE_PATH . '/libs/form_handler.php';
              
                
                if (!empty($data)) 
                {
                	$Combovalue = $data['Combovalue'];
                	$combotype = $data['combotype'];
                	$timedetails= $data['timezonedetails'];
                	$isactive = $data['isactive'];
                }else
                {
                	$Combovalue = '';
                	$combotype = '';
                	$isactive =1;
                }
                
                $form = new lscform();
                $form->openForm(array('action' => '', 'name' => 'viewsettingsform'));
                $form->addInline('<br />');
                $form->addLabel('Combo Type', array('for' => 'Combo Type '));
				$form->openSelect(array('name' => 'combo_type', 'id' => 'combo_type', 'value' => $combotype));
				$form->addOption($combotype, array('value' => $combotype));
                //$form->addInput('text', array('name' => 'ComboType1','value'=> $combotype ,'readonly' => 'yes' ) );
                $form->closeSelect();
                $form->addInline('<br/>');
                $form->addLabel('Combo Value', array('for' => 'Combo Value: '));
                $form->addInput('text', array('name' => 'Combovalue','value'=> $Combovalue ,'readonly' => 'yes' ) );
                $form->addInline('<br />');
                $form -> addLabel ('Is Active', array ('for' => 'MyCheck'));
                if ($isactive ==1)
                {
              	  $form -> addInput ('checkbox', array ('id' => 'MyCheck', 'name' => 'isactive', 'test' => 'test','checked'=> 'checked','disabled' => 'yes'));
                }
                else 
                {
                	$form -> addInput ('checkbox', array ('id' => 'MyCheck', 'name' => 'isactive', 'test' => 'test','disabled' => 'yes' ));
                }
                $form->addInline('<br />');
                if ($combotype == 12)
                {
                	$form->addInline('<div id = "divName" name = "time"  >');
                }else
                {
                	$form->addInline('<div id = "divName" name = "time" , style ="visibility:hidden">');
                }
                $form->addLabel('Time Details', array('for' => 'timedetails: '));
                $form->addInput('text', array('name' => 'timedetails','value'=> $timedetails ,'readonly' => 'yes' ) );
                $form->addInline('<br />');
                $form->addInline('</div>');
                $form -> addLabel (' ',  '');
                $form->closeForm();
                echo $form;
              
                ?>
                