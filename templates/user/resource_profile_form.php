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
// @date 2013-03-20                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

require_once __SITE_PATH . '/libs/form_handler.php';


foreach ($data as $obj_key => $values) {

	if ($obj_key == 'fields') {

		foreach ($values as $key => $value) {

			$username = $value[user_name];
			$firstname = $value[first_name];
			$lastname = $value[last_name];
			$email = $value[email_address];
			$city = $value[city];
			$country = $value[country];
			$timezone = $value[time_zone];
			$productline = $value[product_line];
			$employee_type = $value[employee_type];
			$region = $value[region];
			$user_role = $value[role];
			$isActive = $value[is_active];
		}
	}

	if ($obj_key == 'plm_name') {
		foreach ($values as $key => $value) {
			if (!empty($value[user_name])) {
				$plmanagerid = $value[user_name];
			}

		}
	}

	if ($obj_key == 'rm_name') {
		foreach ($values as $key => $value) {
			if (!empty($value[user_name])) {
				$rm_short_id = $value[user_name];
			}
		}
	}
}


$form = new lscform();
//Form Start
$form -> openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewResource', 'name' => 'viewResource'));
//$form->openFieldset(array('style' => 'border:1px solid #ccc;'));
//$form->addLegend("$firstname $lastname");
$form -> openTable(array('name' => 'view_resource_table', 'cellpadding' => "10", 'cellspacing' => "0", 'border' => "0", 'class' => "table", 'id' => "table"));
$form->openTableRow();
$form->openTableColumn();
$form -> openTable();
//Username
$form -> openTableRow();
$form -> addTableColumn("<b>Username</b>");
$form -> addTableColumn('<a href="#">' . $firstname . ' ' . $lastname . '</a>');
$form -> closeTableRow();

//Email
$form -> openTableRow();
$form -> addTableColumn("<b>Email</b>");
$form -> addTableColumn($email);
$form -> closeTableRow();

//City
$form -> openTableRow();
$form -> addTableColumn("<b>City</b>");
$form -> addTableColumn($city);
$form -> closeTableRow();

//Country
$form -> openTableRow();
$form -> addTableColumn("<b>Country</b>");
$form -> addTableColumn($country);
$form -> closeTableRow();

//PL Manager
$form -> openTableRow();
$form -> addTableColumn("<b>PL Manager</b>");
$form -> addTableColumn($plmanagerid);
$form -> closeTableRow();

//Resource Manager
$form -> openTableRow();
$form -> addTableColumn("<b>Resource Manager</b>");
$form -> addTableColumn($rm_short_id);
$form -> closeTableRow();

//Product Line
$form -> openTableRow();
$form -> addTableColumn("<b>Product Line</b>");
//$form -> addTableColumn($productline);
$form -> closeTableRow();


//Region
$form -> openTableRow();
$form -> addTableColumn("<b>Region</b>");
//$form -> addTableColumn($region);
$form -> closeTableRow();


//Role
$form -> openTableRow();
$form -> addTableColumn("<b>Role</b>");
//$form -> addTableColumn($user_role);
$form -> closeTableRow();


//Is Active
$form -> openTableRow();
$form -> addTableColumn("<b>IsActive</b>");

if ($isActive == 1) {
	$form -> addTableColumn('Yes');
} else {
	$form -> addTableColumn('No');
}


$form -> closeTableRow();
$form->closeTable();
$form->closeTableColumn();


$form->closeTableRow();
$form -> closeTable();
//$form->closeFieldset();
$form -> closeForm();

echo $form;
?>