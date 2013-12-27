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
// @date 2012-12-12                                                      	   			// 
// @version 1.0								       										// 
// @description:                              	    // 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<div align="center">
<?php 

require_once __SITE_PATH.'/libs/form_handler.php';

$form = new lscform();
$form -> openForm (array ('action' => '?load=login/auth', 'name' => 'loginForm'));
echo "<br><br><br><br><br><br><br><br>";
echo "<b>Please Login to LSC!</b><br><br>";
 if(!empty($data)){
            foreach ($data as $value) {
                echo "<br>";
                echo "<font color='red'>".$value."</font>";
            }
        }
$form -> addInline ('<br /><br />');
$form -> addLabel ('Username', array ('for' => 'MyText: ', 'style' => 'margin: 15px;'));
$form -> addInline ('&nbsp;&nbsp;&nbsp;');
$form -> addInput ('text', array ('name' => 'userName'));
$form -> addInline ('<br /><br />');
$form -> addLabel ('Password', array ('for' => 'Password: ', 'style' => 'margin: 15px;'));
$form -> addInline ('&nbsp;&nbsp;&nbsp;');
$form -> addInput ('password', array ('name' => 'password'));
$form -> addInline ('<br /><br />');
$form -> addInput ('submit', array ('name' => 'submit', 'value' => 'Submit'));
$form -> closeForm ();
echo '<div style="border: 1px solid darkgrey; text-align: center; width: 350px;">';
echo $form;
echo '</div>';


?>
</div>
