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

$errorMessage = '';
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

foreach ($data as $obj_key => $fields) {

    if ($obj_key == 'fields') {
        $shortid = $fields['shortid'];
        $firstName = $fields['firstName'];
        $lastName = $fields['lastName'];
        $email = $fields['email'];
        $city = $fields['city'];
        $country = $fields['country'];
        $timezone = $fields['timezone'];
        $plm_shortid = $fields['plm_username'];
        $productline = $fields['productline'];
        $emp_status = $fields['emp_status'];
        $rm_shortid = $fields['rm_username'];
        $work_region = $fields['work_region'];
        $user_role = $fields['user_role'];
        $isActive = $fields['isActive'];
    }

}


$form = new lscform();
//Form Start
$form->openForm(array('method' => 'POST', 'action' => '?load=resource/addResource', 'id' => 'addResourceForm', 'name' => 'addResourceForm'));

$form->openTable();

$form->openTableRow();
$form->openTableColumn(array('width' => '350px'));

//Shortid
$form->addLabel($lang['shortid'] . '<font color="red">*</font>', array('for' => '*'));
$form->addInput('text', array('name' => 'shortId', 'id' => 'shortId', 'value' => $shortid, 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');

//Firstname
$form->addLabel($lang['firstname'] . '<font color="red">*</font>', array('for' => 'First Name: '));
$form->addInput('text', array('name' => 'firstName', 'id' => 'firstName', 'value' => $firstName, 'data-validation' => 'required;alphabets;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');

//Lastname
$form->addLabel($lang['lastname'] . '<font color="red">*</font>', array('for' => 'Last Name: '));
$form->addInput('text', array('name' => 'lastName', 'id' => 'lastName', 'value' => $lastName, 'data-validation' => 'required;alphabets;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');

//Email
$form->addLabel($lang['email'] . '<font color="red">*</font>', array('for' => 'Email: '));
$form->addInput('text', array('name' => 'email', 'id' => 'email', 'value' => $email, 'data-validation' => 'required;email;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');

//City
$form->addLabel($lang['city'], array('for' => 'City: '));
$form->addInput('text', array('name' => 'city', 'id' => 'city', 'value' => $city));
$form->addInline('<br />');


//PLM Short Id
$form->addLabel($lang['plm_shortid'] . '<font color="red">*</font>', array('for' => 'PL Manager ShortId: '));
$form->addInput('text', array('name' => 'plm_shortid', 'id' => 'plm_shortid', 'value' => $plm_shortid, 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');


//Reporting Manager Short Id
$form->addLabel($lang['rm_shortid'] . '<font color="red">*</font>', array('for' => 'Report Managers ShortId: '));
$form->addInput('text', array('name' => 'rm_shortid', 'id' => 'rm_shortid', 'value' => $rm_shortid, 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br />');


$form->closeTableColumn();

$form->openTableColumn(array('width' => '350px'));


//Country
$form->addLabel($lang['country'], array('for' => 'Select a Country: '));
$form->openSelect(array('name' => 'country', 'id' => 'country', 'value' => $country));
$form->addOption("Select a country", array('value' => ''));

foreach ($data as $obj_key => $countries) {
    if ($obj_key == 'country') {
    	//var_dump($countries);
        foreach ($countries as  $country_datas) {

            if ($country_datas[meta_code] == $country) {
                $form->addOption($country_datas[meta_text], array('selected' => 'selected', 'value' => $country_datas[meta_code]));
            } else {
                $form->addOption($country_datas[meta_text], array('value' => $country_datas[meta_code]));
            }
        }
    }
}

$form->closeSelect();
$form->addInline('<br />');

//Timezone
$form->addLabel($lang['timezone'], array('for' => 'Select a Timezone: '));
$form->openSelect(array('name' => 'timezone', 'id' => 'timezone', 'value' => $timezone));
$form->addOption("Select a timezone", array('value' => ''));

foreach ($data as $obj_key => $timezones) {
    if ($obj_key == 'timezones') {
        foreach ($timezones as $timezone_key => $timezone_datas) {
            if ($timezone_datas[meta_code] == $timezone) {
                $form->addOption($timezone_datas[meta_text], array('selected' => 'selected', 'value' => $timezone_datas[meta_code]));
            } else {
                $form->addOption($timezone_datas[meta_text], array('value' => $timezone_datas[meta_code] ));
            }
        }
    }
}
$form->closeSelect();
$form->addInline('<br />');
//Product Line
$form->addLabel($lang['ProductLine'], array('for' => 'Product Line: '));
$form->openSelect(array('name' => 'productline', 'id' => 'productline', 'value' => $productline));
$form->addOption("Select Productline", array('value' => ''));

foreach ($data as $obj_key => $productlines_datas) {
    if ($obj_key == 'productlines') {
        foreach ($productlines_datas as $productline_key => $productline_value) {

            if ($productline_value[meta_code] == $productline) {

                $form->addOption($productline_value[meta_text], array('selected' => 'selected', 'value' => $productline_value[meta_code]));

            } else {
                $form->addOption($productline_value[meta_text], array('value' => $productline_value[meta_code]));
            }
        }
    }
}

$form->closeSelect();
$form->addInline('<br />');

//Employment Status
$form->addLabel($lang['empstatus'], array('for' => 'Employee Status: '));

$form->openSelect(array('name' => 'emp_status', 'id' => 'emp_status', 'value' => $emp_status));
$form->addOption("Select Employment Status", array('value' => ''));

foreach ($data as $obj_key => $emp_types_datas) {
    if ($obj_key == 'emp_statuses') {
        foreach ($emp_types_datas as $emp_type_key => $emp_type_values) {
            if ($emp_type_values[meta_code] == $emp_status) {
                $form->addOption($emp_type_values[meta_text], array('selected' => 'selected', 'value' => $emp_type_values[meta_code]));
            } else {
                $form->addOption($emp_type_values[meta_text], array('value' => $emp_type_values[meta_code]));
            }
        }
    }
}

$form->closeSelect();
$form->addInline('<br />');


//Work Region
$form->addLabel($lang['workregion'], array('for' => 'Work Region: '));
$form->openSelect(array('name' => 'work_region', 'id' => 'work_region', 'value' => $work_region));
$form->addOption("Select Work Region", array('value' => ''));

foreach ($data as $obj_key => $work_regions_datas) {
    if ($obj_key == 'work_regions') {
        foreach ($work_regions_datas as $region_key => $region_values) {
            if ($region_values[meta_code] == $work_region) {
                $form->addOption($region_values[meta_text], array('selected' => 'selected', 'value' => $region_values[meta_code]));
            } else {
                $form->addOption($region_values[meta_text], array('value' => $region_values[meta_code]));
            }
        }
    }
}

$form->closeSelect();
$form->addInline('<br />');
 $form->addLabel('IsActive', array('for' => 'Role: '));
 if($isActive==1){
  $form->addInput('checkbox', array('name' => "isActive", 'id' => "isActive", 'value' => "1", 'admin' => 'Admin','checked' => 'checked'));
 }else{
 	$form->addInput('checkbox', array('name' => "isActive", 'id' => "isActive", 'value' => "1", 'admin' => 'Admin'));
 }

$form->addInline('<br /><br />');
$form->closeTableColumn();

$form->openTableColumn(array('width' => '350px'));

$user_roles = array(
    1=>"User",
    2=>"Admin",
    3=>"SDM",
    4=>"KTPM",
    5=>"PLM",
    6=>"SAP Manager"
);

$form->addLabel($lang['role'] . '<font color="red">*</font>', array('for' => 'Role: '));
$i = 0;
foreach ($user_roles as $role_key=>$role) {
    $i++;
    if ($role_key != 1) {
        $form->addLabel('', array('for' => 'Role'));
    }


        $roles = explode(",", $user_role);

    $flag = true;
	foreach ($roles as $key => $value) {
	    if( $role_key==$value){
		 $form->addInput('checkbox', array('name' => "role[]", 'id' => $role, 'value' => $role_key, 'admin' => 'Admin', 'checked' => 'checked'));
			$flag=false;
		}

	}
   if($flag==true){

       $form->addInput('checkbox', array('name' => "role[]", 'id' => $role, 'value' => $role_key, 'admin' => 'Admin'));
	}

    $form->addInline('&nbsp;&nbsp;');
    $form->addCustomLabel("$role", array('for' => 'Admin'));

    $form->addInline('<br />');
}
$form->addInline('<br /><br />');
$form->closeTableColumn();
$form->closeTableRow();
$form->closeTable();
$form->addInline('<div style="padding: 10px 55px 0 50px">');
$form->addButton('submit', array('name' => 'submit', 'value' => 'Submit'));
$form->addInline('</div>');
$form->closeForm();

echo $form;
ob_end_flush();
?>