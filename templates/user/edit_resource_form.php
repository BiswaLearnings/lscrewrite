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
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>

<?php

ob_start();

include_once __SITE_PATH . '/lang/lang.php';
require_once __SITE_PATH . '/libs/form_handler.php';

foreach ($data as $obj_key => $values) {

	if ($obj_key == 'fields'){

		foreach ($values as $key => $value) {

			$username = htmlspecialchars_decode($value[user_name]);

			$firstname = $value[first_name];
			$lastname = $value[last_name];
			$email = $value[email_address];

			$city = $value[city];
			$country = $value[country];

			$timezone = $value[time_zone];
                        if($value[pl_managerid]!=0){
			$plmanagerid = $value[pl_managerid];
                        }
			$productline = $value[product_line];
			$employee_type = $value[employee_type];
                        if($value[reporting_managerid]!=0){
			$rm_short_id = $value[reporting_managerid];
                        }
			$region = $value[region];
			$user_role = $value[role];
			$isActive = $value[is_active];
		}
	}else if($obj_key == 'callbacks'){


		$username = $values['shortid'];
        $firstname = $values['firstName'];
        $lastname = $values['lastName'];
        $email = $values['email'];
        $city = $values['city'];
        $country = $values['country'];
        $timezone = $values['timezone'];
        $plmanagerid = $values['plm_shortid'];
        $productline = $values['productline'];
        $employee_type = $values['emp_status'];
        $rm_short_id = $values['rm_shortid'];
        $region = $values['work_region'];
        $user_role = $values['user_role'];
		$isActive = $values['isActive'];

	}

	if($obj_key=='plm_name'){
            foreach ($values as $key => $value) {
            	if(!empty($value[user_name]) ){
            		$plmanagerid = $value[user_name];
            	}

            }
        }

	if($obj_key=='rm_name'){
            foreach ($values as $key => $value) {
            	if(!empty($value[user_name])){
                $rm_short_id = $value[user_name];
				}
            }
        }
}

$form = new lscform();

foreach ($data as $obj_key => $errors) {
	if ($obj_key == 'errors') {
		foreach ($errors as $key => $value) {
			if(!empty($value)){
                $errorMessage .= sprintf('%s\n', $value);
			}
		}
	}
}
if(!empty($errorMessage))
{
    echo '<script type="text/javascript"> $(document).ready(function(){ alert("Please correct the following errors: \n\n'.$errorMessage.'"); });</script>';
}
//Form Start
$form -> openForm(array('method' => 'POST', 'action' => '?load=resource/updateResource', 'id' => 'editResourceForm', 'name' => 'editResourceForm'));
$form -> addInput('hidden', array('name' => 'update', 'id' => 'update', 'value' => 'update'));

$form->openTable();
$form->openTableRow();

$form->openTableColumn();
//Shortid
$form -> addLabel($lang['shortid'] . '<font color="red">*</font>', array('for' => '*'));
$form -> addInput('text', array('name' => 'shortId', 'id' => 'shortId', 'value' => $username));
$form -> addInline('<br/>');

//Firstname
$form -> addLabel($lang['firstname'] . '<font color="red">*</font>', array('for' => 'First Name: '));
$form -> addInput('text', array('name' => 'firstName', 'id' => 'firstName', 'value' => $firstname));
$form -> addInline('<br />');

//Lastname
$form -> addLabel($lang['lastname'] . '<font color="red">*</font>', array('for' => 'Last Name: '));
$form -> addInput('text', array('name' => 'lastName', 'id' => 'lastName', 'value' => $lastname));
$form -> addInline('<br />');

//Email
$form -> addLabel($lang['email'] . '<font color="red">*</font>', array('for' => 'Email: '));
$form -> addInput('text', array('name' => 'email', 'id' => 'email', 'value' => $email));
$form -> addInline('<br />');

//City
$form -> addLabel($lang['city'], array('for' => 'City: '));
$form -> addInput('text', array('name' => 'city', 'id' => 'city', 'value' => $city));
$form -> addInline('<br />');

//PLM Short Id
$form->addLabel($lang['plm_shortid'] . '<font color="red">*</font>', array('for' => 'PL Manager ShortId: '));
$form->addInput('text', array('name' => 'plm_shortid', 'id' => 'plm_shortid', 'value' => $plmanagerid));
$form->addInline('<br />');


//Reporting Manager Short Id
$form -> addLabel($lang['rm_shortid'] . '<font color="red">*</font>', array('for' => 'Report Managers ShortId: '));
$form -> addInput('text', array('name' => 'rm_shortid', 'id' => 'rm_shortid', 'value' => $rm_short_id));
$form -> addInline('<br />');

$form->closeTableColumn();
$form->openTableColumn();

//Country
$form -> addLabel($lang['country'], array('for' => 'Select a Country: '));
$form -> openSelect(array('name' => 'country', 'id' => 'country', 'value' => $country));
$form -> addOption("Select Country", array('value' => ''));

foreach ($data as $obj_key => $countries) {
	if ($obj_key == 'country') {

		foreach ($countries as $country_datas) {
			if ($country_datas[meta_code] == $country) {
				$form -> addOption($country_datas[meta_text], array('selected' => 'selected', 'value' => $country_datas[meta_code]));
			} else {
				$form -> addOption($country_datas[meta_text], array('value' => $country_datas[meta_code]));
			}
		}
	}
}
$form -> closeSelect();
$form -> addInline('<br />');

//Timezone
$form -> addLabel($lang['timezone'], array('for' => 'Select a Timezone: '));
$form -> openSelect(array('name' => 'timezone', 'id' => 'timezone', 'value' => $timezone));
$form -> addOption("Select Timezone", array('value' => ''));

foreach ($data as $obj_key => $timezones) {
	if ($obj_key == 'timezones') {
		foreach ($timezones as $timezone_datas) {
			if ($timezone_datas[meta_code] == $timezone) {
				$form -> addOption($timezone_datas[meta_text], array('selected' => 'selected', 'value' => $timezone_datas[meta_code]));
			} else {
				$form -> addOption($timezone_datas[meta_text], array('value' => $timezone_datas[meta_code]));
			}
		}
	}
}
$form -> closeSelect();
$form->addInline('<br />');

//Product Line
$form -> addLabel($lang['ProductLine'], array('for' => 'Product Line: '));
$form -> openSelect(array('name' => 'productline', 'id' => 'productline', 'value' => $productline));
$form -> addOption("Select Productline", array('value' => ''));

foreach ($data as $obj_key => $productlines_datas) {
	if ($obj_key == 'productlines') {
		foreach ($productlines_datas as $productline_key => $productline_value) {

			if ($productline_value[meta_code] == $productline) {

				$form -> addOption($productline_value[meta_text], array('selected' => 'selected', 'value' => $productline_value[meta_code]));

			} else {
				$form -> addOption($productline_value[meta_text], array('value' => $productline_value[meta_code]));
			}
		}
	}
}

$form->closeSelect();
$form->addInline('<br />');

//Employment Status
$form -> addLabel($lang['empstatus'], array('for' => 'Employee Status: '));

$form -> openSelect(array('name' => 'emp_status', 'id' => 'emp_status', 'value' => $employee_type));
$form -> addOption("Select Employment Status", array('value' => ''));

foreach ($data as $obj_key => $emp_types_datas) {
	if ($obj_key == 'emp_statuses') {
		foreach ($emp_types_datas as $emp_type_key => $emp_type_values) {

			if ($emp_type_values[meta_code] == $employee_type) {

				$form -> addOption($emp_type_values[meta_text], array('selected' => 'selected', 'value' => $emp_type_values[meta_code]));
			} else {
				$form -> addOption($emp_type_values[meta_text], array('value' => $emp_type_values[meta_code]));
			}
		}
	}
}

$form -> closeSelect();
$form -> addInline('<br />');

//Work Region
$form -> addLabel($lang['workregion'], array('for' => 'Work Region: '));
$form -> openSelect(array('name' => 'work_region', 'id' => 'work_region', 'value' => $region));
$form -> addOption("Select Work Region", array('value' => ''));

foreach ($data as $obj_key => $work_regions_datas) {
	if ($obj_key == 'work_regions') {
		foreach ($work_regions_datas as $region_key => $region_values) {
			if ($region_values[meta_code] == $region) {
				$form -> addOption($region_values[meta_text], array('selected' => 'selected', 'value' => $region_values[meta_code]));
			} else {
				$form -> addOption($region_values[meta_text], array('value' => $region_values[meta_code]));
			}
		}
	}
}

$form -> closeSelect();
$form->addInline('<br />');
$form->addLabel('IsActive', array('for' => 'Role: '));

 if($isActive==1){
  $form->addInput('checkbox', array('name' => "isActive", 'id' => "isActive", 'value' => "1", 'admin' => 'Admin','checked' => 'checked'));
 }else{
 	$form->addInput('checkbox', array('name' => "isActive", 'id' => "isActive", 'value' => "1", 'admin' => 'Admin'));
 }
$form->addInline('<br /><br /><br />');
$form->closeTableColumn();
$form->openTableColumn();


$user_roles = array(1 => "User", 2 => "Admin", 3 => "Service Delivery Manager", 4 => "KTPM", 5 => "PL Manager", 6 => "SAP Manager");

$form -> addLabel($lang['role'] . '<font color="red">*</font>', array('for' => 'Role: '));

foreach ($user_roles as $role_key => $role) {

	if ($role_key != 1) {
		$form -> addLabel('', array('for' => 'Role'));
	}

	$roles = explode(",", $user_role);

	$flag = true;
	foreach ($roles as $key => $value) {
		if ($role_key == $value) {
			$form -> addInput('checkbox', array('name' => "role[]", 'id' => $role, 'value' => $role_key, 'admin' => 'Admin', 'checked' => 'checked'));
			$flag = false;
		}

	}
	if ($flag == true) {
	      $form -> addInput('checkbox', array('name' => "role[]", 'id' => $role, 'value' => $role_key, 'admin' => 'Admin'));
	}

	$form -> addInline('&nbsp;&nbsp;');
	$form -> addCustomLabel("$role", array('for' => 'Admin'));
	$form -> addInline('<br />');
}
$form->addInline('<br /><br />');
$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable();
$form->addInline('<div style="padding: 10px 55px 0 50px">');
$form->addButton('submit', array('name' => 'submit', 'value' => 'Submit'));
$form->addInline('</div>');

$form -> closeForm();

echo $form;
ob_end_flush();
?>