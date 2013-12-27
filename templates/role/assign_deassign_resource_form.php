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
<script LANGUAGE="JavaScript">
var potentialUsers = '';
var assignedUsers = '';

$(document).ready(function(){
    potentialUsers = $('#potientalusers option');
    assignedUsers = $('#roleassignedusers option');
});

function filterByAvailusers(control)
{
    var tempOptions = potentialUsers;
    var filter = $(control).val().toLowerCase();
    var selectList = $('#potientalusers');
    if(filter)
    {
        selectList.empty();
        $(tempOptions).each(function(){
            var name = $(this).text();
            var value = $(this).val();
            if(name.toLowerCase().indexOf(filter) != -1)
            {
                selectList.append('<option value="' + value + '">' + name + '</option>');
            }
        });
    }
    else
    {
        selectList.empty();
        selectList.append(potentialUsers);
    }
}

function filterByAssignedUsers(control)
{
    //alert($(control).val());
    var tempOptions = assignedUsers;
    var filter = $(control).val().toLowerCase();
    var selectList = $('#roleassignedusers');
    if(filter)
    {
        selectList.empty();
        $(tempOptions).each(function(){
            var name = $(this).text();
            var value = $(this).val();
            if(name.toLowerCase().indexOf(filter) != -1)
            {
                selectList.append('<option value="' + value + '">' + name + '</option>');
            }
        });
    }
    else
    {
        selectList.empty();
        selectList.append(assignedUsers);
    }
}

function confirmSubmit_add()
{
	var ktpm = document.getElementById('ktpm').value;
	var kttype = document.getElementById('kttype').value;
	var targetdate = document.getElementById('targetdate').value;
	//alert ("Value of KTPM as :"+ktpm);
	//alert ("Value of targetdate as :"+targetdate);

	if (ktpm == "-1")
	{
		alert('Please select a value of KTPM');
		return false;
	}
	else if ( kttype == "-1")
	{
		alert('Please select a value of KT Type');
		return false;
	}	
	else if ( targetdate == "-1")
	{
		alert('Please select a value of Target Date');
		return false;
	}	
}

</script>
<?php

ob_start();
//TO DO
include_once __SITE_PATH . '/lang/lang.php';
require_once __SITE_PATH . '/libs/form_handler.php';

$form = new lscform();
//Form Start

//Shortid
$form->openForm(array('method' => 'POST', 'action' => $data['submissionURL'], 'id' => 'roleAssignResourceForm', 'name' => 'roleAssignResourceForm'));
$form->addLabel($lang['ktpm'].' <font color="red">* </font>', array('for' => '*'));
$form->openSelect(array('name' => 'ktpm', 'id' => 'ktpm' ));
$form->addOption("Select a KTPM", array('value'=>'-1'));
$form->addOption("None/KT Not Required", array('value'=>'0'));
foreach ($data as $obj_key => $ktpm)
{
	if ($obj_key == 'ktpm')
	{
		foreach ($ktpm as  $ktpm_datas)
		{
			if ($ktpm_datas['user_name'] == $ktpm)
			{
				$form->addOption($ktpm_datas['user_name'], array('selected' => 'selected', 'value' => $ktpm_datas['id']));
			} 
			else
			{
				$form->addOption($ktpm_datas['user_name'], array('value' => $ktpm_datas['id']));
			}
		}
	}
}
$form->closeSelect();

$form->addLabel($lang['kttype'].' <font color="red">* </font>', array('for' => '*'));
$form->openSelect(array('name' => 'kttype', 'id' => 'kttype' ));
$form->addOption("Select a KT Type", array('value'=>'-1'));
foreach ($data as $obj_key => $kttype)
{
	if ($obj_key == 'kttype') 
	{
		foreach ($kttype as  $kttype_datas) 
		{
			if ($kttype_datas['meta_code'] == $kttype) 
			{
				$form->addOption($kttype_datas['meta_text'], array('selected' => 'selected', 'value' => $kttype_datas['meta_code']));
			} else 
			{
				$form->addOption($kttype_datas['meta_text'], array('value' => $kttype_datas['meta_code']));
			}
		}
	}
}
$form->closeSelect();
$form->addLabel($lang['targetdate'].' <font color="red">* </font>', array('for' => '*'));
$form->openSelect(array('name' => 'targetdate', 'id' => 'targetdate' ));
$form->addOption("Select a Target Date", array('value'=>'-1'));
foreach ($data as $obj_key => $targetdate)
{
	if ($obj_key == 'targetdate')
	{
		foreach ($targetdate as  $targetdate_datas)
		{
			if ($targetdate_datas['meta_code'] == $targetdate)
			{
				$form->addOption($targetdate_datas['meta_text'], array('selected' => 'selected', 'value' => $targetdate_datas['meta_code']));
			} else
			{
				$form->addOption($targetdate_datas['meta_text'], array('value' => $targetdate_datas['meta_code']));
			}
		}
	}
}

$form->closeSelect();

$form->addInline('<div style="position: relative; float:left; padding-top:15px;">');
$form->openFieldset();
$form->addLegend($lang['assignusers']);
$form->addLabel('Filter By ', array('for' => '*'));
$form->addInput('text', array('name' => 'searchnameassign', 'id' => 'searchnameassign', 'style'=>'margin-right:10px;', 'onkeyup' => 'filterByAssignedUsers(this);'));
$form->addInline('<br />');
$form->openSelect(array('name' => 'roleassignedusers[]', 'id' => 'roleassignedusers', 'size'=> '18', 'multiple' => 'multiple', 'onfocus' => "document.getElementById('roleAssignResourceForm').add.disabled=true;document.getElementById('roleAssignResourceForm').remove.disabled=false;document.getElementById('roleAssignResourceForm').notify.disabled=false;document.getElementById('potientalusers').selectedIndex=-1;", 'style' => 'float:left; margin-left : 5px; width : 450px;' ));
foreach ($data as $obj_key => $roleassigneduser)
{
	if ($obj_key == 'roleassignedusers')
	{
		//var_dump($countries);
		foreach ($roleassigneduser as  $roleassigneduser_datas)
		{
			if ($roleassigneduser_datas['user_name'] == $roleassigneduser)
			{
				$fullname = $roleassigneduser_datas['first_name'] . ' ' . $roleassigneduser_datas['last_name'] .' ,'. $roleassigneduser_datas['email_address'];
				$form->addOption($fullname, array('selected' => 'selected', 'value' => $roleassigneduser_datas['id']));
			}
			else
			{				
				$fullname = $roleassigneduser_datas['first_name'] . ' ' . $roleassigneduser_datas['last_name'] .' ,'. $roleassigneduser_datas['email_address'];
				$form->addOption($fullname, array('value' =>$roleassigneduser_datas['id']));
			}	
		}
	}
}
$form->closeSelect();
$form->closeFieldset();
$form->addInline('</div>');

$form->addInline('<div style="position:relative; float:left; width: 100px;padding-top:125px;">');
$form->addButton('submit', array('name' => 'addbutton', 'id' => 'add', 'value' => 'Assign', 'disabled' => 'true', 'onclick'=>'return confirmSubmit_add();', 'style' => 'float : left;margin:10px 25px 10px 25px;'));
$form->addButton('submit', array('name' => 'rembutton', 'id' => 'remove', 'value' => 'DeAssign', 'disabled' => 'true', 'style' => 'float : left;margin:10px 25px 10px 25px;'));
$form->addButton('submit', array('name' => 'notifybutton', 'id' => 'notify', 'value' => 'Notify', 'disabled' => 'true', 'style' => 'float : left;margin:10px 25px 10px 25px;'));
$form->addInline('</div>');
$form->addInline('<div style="position:relative; float:left; margin-left: 30px;">');
$form->addInline('<br />');
$form->openFieldset();
$form->addLegend($lang['availusers']);
$form->addLabel('Filter By ', array('for' => '*'));
$form->addInput('text', array('name' => 'searchnameavail', 'id' => 'searchnameavail', 'style'=>'margin-right:10px;', 'onkeyup' => 'filterByAvailusers(this);'));
$form->addInline('<br />');
$form->openSelect(array('name' => 'potientalusers[]', 'id' => 'potientalusers', 'size'=> '18', 'multiple' => 'multiple', 'onfocus' => "document.getElementById('roleAssignResourceForm').add.disabled=false;document.getElementById('roleAssignResourceForm').remove.disabled=true;document.getElementById('roleAssignResourceForm').notify.disabled=true;", 'style' => 'float:right; margin-right : 5px; width : 450px; ' ));

foreach ($data as $obj_key => $potientaluser)
{
	if ($obj_key == 'potientalusers')
	{
		foreach ($potientaluser as  $potientaluser_datas)
		{
			if ($potientaluser_datas['user_name'] == $potientaluser)
			{
				$fullname = $potientaluser_datas['first_name'] . ' ' . $potientaluser_datas['last_name'] .' ,'. $potientaluser_datas['email_address'];
				$form->addOption($fullname, array('selected' => 'selected', 'value' => $potientaluser_datas['id']));
			} 
			else
			{
				$fullname = $potientaluser_datas['first_name'] . ' ' . $potientaluser_datas['last_name'] .' ,'. $potientaluser_datas['email_address'];
				$form->addOption($fullname, array('value' =>$potientaluser_datas['id']));
			}
		}
	}
}
$form->closeSelect();
$form->closeFieldset();

$form->addInline('</div>');
$form->closeForm();

echo $form;
ob_end_flush();
?>
