<?php

/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

?>
<script>

    function redirectKnode(baseURL)
    {
        var knode = $('#knode').val();
        if (knode == 1)
        {
			document.getElementById("accountname").selectedIndex=0;
			makeDisable();
        }
        else
        {
			makeEnable();
			document.getElementById("accountname").selectedIndex=0;
        } 
   
        redirectToURL(baseURL + '?load=userModules/userOnChangeTasks/K/' + $('#knode').val());
    }

    function redirectAccount(baseURL)
    {
    	 redirectToURL(baseURL + '?load=userModules/userOnChangeTasks/A/' + $('#knode').val() + '/' + $('#accountname').val());
    }    

	function makeDisable()
	{
	    var accountNameControl = document.getElementById("accountname");
	    accountNameControl.disabled=true;
	}
	
	function makeEnable()
	{
	    var accountNameControl = document.getElementById("accountname");
	    accountNameControl.disabled=false;
	}

	function validate()
	{
		var accountName = document.getElementById('accountname').value;
		var knodeval = document.getElementById('knode').value;

		if ((accountName == -1) && (knodeval != 1))
		{
			alert('Please select a value of Account Name');
			return false;
		}
	}	    
</script>
<?php
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/form_handler.php';

if (!empty($data))
{
	foreach($data as $obj_key => $assignedtask)
	{
		if ($obj_key == 'tasktype')
		{
			$userTaskType = $assignedtask;
		}	
	}	
}

if ($userTaskType == 'roles')
{	
	$roleform = new lscform();
    //Form Start
    $roleform->openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewUserAssignedRoles', 'name' => 'viewUserAssignedRoles'));
    $roleform->addInline('<div class="jquery-table" >');
    $roleform->openTable(array('name' => 'viewUserAssignedRoles', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
    $roleform->openTableHeader();
    $roleform->openTableRow();
    $roleform->addTableHead($lang['accname']);
    $roleform->addTableHead($lang['role_name']);
    $roleform->addTableHead($lang['region']);
    $roleform->addTableHead($lang['status']);
    $roleform->addTableHead($lang['validity']);
	$roleform->closeTableRow();
    $roleform->closeTableHeader();
    $roleform->openTableBody();
            
	foreach($data as $obj_key => $assignedroles) 
	{
		if ($obj_key == 'assignedroles')
	    {
	    	foreach ($assignedroles as  $assignedroles_datas)
	        {
	        	$roleform->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
	            $roleform->addTableColumn($assignedroles_datas['acctname']);
	            $roleform->addTableColumn($assignedroles_datas['rolename']);
	            $roleform->addTableColumn($assignedroles_datas['region']);
	            if ($assignedroles_datas['certified_date'] == '')
	            {	
	            	$roleform->addTableColumn($assignedroles_datas['rolestatus']);
	            }
	            else
	            {
	            	$roleform->addTableColumn('<a href="?load=userModules/userShowDetails/'.$assignedroles_datas['role_id'].'"><u>'.$assignedroles_datas['rolestatus'].'</u></a>');
	            }		
	            $roleform->addTableColumn($assignedroles_datas['certified_date']);
	            $roleform->closeTableRow();
			}
	    }	
	}
	
	$roleform->closeTableBody();
	$roleform->closeTable();
	$roleform->addInline('</div>');
	$roleform->closeForm();
	echo $roleform;	
}  
else if ($userTaskType == 'modules')
{
	$knodeDefVal = $data['knode'][0]['meta_code'];
	$moduleform = new lscform();
	$moduleform->openForm(array('method' => 'POST', 'action' => '?load=userModules/userShowDetails/', 'id' => 'viewUserAssignedModules', 'name' => 'viewUserAssignedModules'));
	$moduleform->addLabel($lang['knode'], array('for' => '*'));
	$moduleform->openSelect(array('name' => 'knode', 'id' => 'knode', 'onchange' => sprintf('redirectKnode(\'%s\')', WEB_PATH)  ));

	foreach ($data as $obj_key => $knode)
	{
		if ($obj_key == 'knodeval')
		{
			$knodeActionVal = $knode;
			$knodeFlag = 'Y';
		}	
		 
		if ($obj_key == 'knode')
		{
			foreach ($knode as  $knode_datas)
			{
				if ($knodeFlag == 'Y')
				{
					$knode = $knodeActionVal;
					$knodeDefVal = $knode;
				}
								
				if ($knode_datas['meta_code'] == $knode)
				{
					$moduleform->addOption($knode_datas['meta_text'], array('selected' => 'selected', 'value' => $knode_datas['meta_code']));
				}
				else
				{
					$moduleform->addOption($knode_datas['meta_text'], array('value' => $knode_datas['meta_code']));
				}
			}
		}
	}
	$moduleform->closeSelect();

	$moduleform->addLabel($lang['account'], array('for' => '*'));
	//$moduleform->openSelect(array('name' => 'accountname', 'id' => 'accountname' ));
	$moduleform->openSelect(array('name' => 'accountname', 'id' => 'accountname', 'onchange' => sprintf('redirectAccount(\'%s\')', WEB_PATH)));
	
	$moduleform->addOption('Select an acccount',array('value'=>'-1','selected'=>'selected'));
		
	foreach ($data as $obj_key => $acctname)
	{
		if ($obj_key == 'accountval')
		{
			$accountActionVal = $acctname;
			$accountFlag = 'Y';
		}
		
		if ($obj_key == 'assignedmodules')
		{
			foreach ($acctname as  $acctname_datas)
			{
				if ($accountFlag == 'Y')
				{
					$acctname = $accountActionVal;
				}
								
				if ($acctname_datas['account_id'] == $acctname)
				{
					$moduleform->addOption($acctname_datas['acctname'], array('selected' => 'selected', 'value' => $acctname_datas['account_id']));
				}
				else
				{
					if ($acctname_datas['acctname'] != '')
					{	
						$moduleform->addOption($acctname_datas['acctname'], array('value' => $acctname_datas['account_id']));
					}	
				}
			}
		}
	}
	$moduleform->closeSelect();

	$moduleform->addLabel($lang['role'], array('for' => '*'));
	$moduleform->openSelect(array('name' => 'rolename', 'id' => 'rolename' ));
	
	foreach ($data as $obj_key => $rolename)
	{
		if ($obj_key == 'roleval')
		{
			$roleActionVal = $rolename;
			$roleFlag = 'Y';
		}
			
		if ($obj_key == 'assignedmodules')
		{
			foreach ($rolename as  $rolename_datas)
			{
				if ($roleFlag == 'Y')
				{
					$rolename = $roleActionVal;
				}
								
				if ($rolename_datas['role_id'] == $rolename)
				{
					$moduleform->addOption($rolename_datas['rolename'], array('selected' => 'selected', 'value' => $rolename_datas['role_id']));
				}
				else
				{
					if ($rolename_datas['rolename'] != '')
					{	
						$moduleform->addOption($rolename_datas['rolename'], array('value' => $rolename_datas['role_id']));
					}	
				}
			}
		}
	}
	$moduleform->closeSelect();
	$moduleform->addInput('submit', array('name' => 'showdetails','value' => 'Show Details', 'onclick' => 'validate();'));
	$moduleform->closeForm();
	echo $moduleform;
	
	if ($knodeDefVal == 1 || $knodeActionVal == 1)
	{
		echo '<script type="text/javascript">makeDisable();</script>';
	}
	else
	{
		echo '<script type="text/javascript">makeEnable();</script>';
	}

	$gridform = new lscform();
	//Form Start
	$gridform->openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewUserAssignedRoles', 'name' => 'viewUserAssignedRoles'));
	$gridform->addInline('<div class="jquery-table" >');
	$gridform->openTable(array('name' => 'viewUserAssignedRoles', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
	$gridform->openTableHeader();
	$gridform->openTableRow();
	$gridform->addTableHead($lang['moduleName']);
	$gridform->addTableHead($lang['targetdate']);
	$gridform->addTableHead($lang['modulestatus']);
	$gridform->addTableHead($lang['dateofcompletion']);
	$gridform->closeTableRow();
	$gridform->closeTableHeader();
	$gridform->openTableBody();
	
	foreach($data as $obj_key => $modulegriddatas)
	{
		if ($obj_key == 'griddata')
		{
			foreach ($modulegriddatas as  $modulegrid_datas)
			{
				$gridform->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
				$gridform->addTableColumn('<a href="?load=userModules/userShowDetails/'.$modulegrid_datas['module_id'].'"><u>'.$modulegrid_datas['module_name'].'</u></a>');
				$gridform->addTableColumn($modulegrid_datas['targetdate']);
				$gridform->addTableColumn($modulegrid_datas['module_status']);
				$gridform->addTableColumn($modulegrid_datas['completed_date']);
				$gridform->closeTableRow();
			}
		}
	}
	
	$gridform->closeTableBody();
	$gridform->closeTable();
	$gridform->addInline('</div>');
	$gridform->closeForm();
	echo $gridform;
	
}	           

?>