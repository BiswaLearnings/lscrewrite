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
                require_once __SITE_PATH . '/libs/LSCAccordion.php';
                require_once __SITE_PATH . '/libs/LSCAccordion.php';
              //  require_once __SITE_PATH . '/app/views/settings/redirect.php';
         ?>  
 <script type="text/javascript" src="<?php echo WEB_PATH; ?>/content/js/jquery-1.9.1.min.js"></script>
 <script type="text/javascript">
     var jq = jQuery.noConflict();
 </script>
<script> 
		function getmetadatadeatils(combotype)
		{
			 
				 jq(function() {

				  var values = [];
				values.push(jq("#combotype").val()); 
				 
				  jq.post('?load=settings/displaysettingsview1/'+values,
				    
				      function(data){

				       jq("#crole").replaceWith('<span id="crole">'+ data + '</span>');
				     });
				 });
				 
         
	    }
			  
		 
</script>
       
       
          <?php 
       
          
                
                if (!empty($pagefields)) 
                { 
                	 
                	$combotype = $pagefields;
                 
                }else
                {
                	$combotype = '';
                }

                $form = new lscform();
                $form->openForm(array('action' => '?load=settings/displaysettingsview', 'name' => 'SettingsForm'));
                $form->addInline('<br />');
                $form->addLabel('Combo Type', array('for' => 'Combo Type ', 'style' => 'float: left; width: 10em; margin-right: 1em;'));
                $form->openSelect(array('name' => 'combotype', 'id' => 'combotype' ));
                $form->addOption('Select the value',array('value'=>0));
                foreach ($data as $value)
                {
                		
                	if ($value['id']==$combotype)
					{
                		$form->addOption($value['type'],array('value'=>$value[type] ,'selected'=>'selected' ));
                	}else
					{
						$form->addOption($value['type'],array('value'=>$value[type] ));
					}
                }
                $form->closeSelect();
                $form->addInline('&nbsp&nbsp&nbsp&nbsp');
                $form->addButton('submit', array('name' => 'getdata', 'value' => 'Get Data', 'style' => ''));
                $form->addInline('<br/>');
                //table 
                if (!empty($data)) {
                $form->openTable(array('name' => 'view_settings_table', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
                $form->openTableHeader();
                $form->openTableRow();
                $form->addTableHead('Combo Data');
                $form->addTableHead($lang[isactive]);
                $form->addTableHead($lang[edit]);
                $form->addTableHead($lang[view]);
                $form->closeTableRow();
                $form->closeTableHeader();
                $form->openTableBody();
                
              
                	foreach ($griddata as $row) {
                		$form->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
                		$form->addTableColumn($row['meta_text']);
						if($row['is_active']==1){
							$form->addTableColumn('Yes');
						}else{
							$form->addTableColumn('No');
						}
                		
                		$form->addTableColumn('<a href="?load=settings/editsettingsview/'.$row[id].'"><u>Edit</u></a>');
                		$form->addTableColumn('<a href="?load=settings/viewsettingsview/'.$row[id].'"><u>View</u></a>');
                		$form->closeTableRow();
                	}
               
                
                $form->closeTableBody();
                $form->closeTable();
                 }
                $form->closeForm();
                echo $form;

            
 
                ?>
        
 

                