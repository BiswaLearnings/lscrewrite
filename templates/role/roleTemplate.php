<?php
//////////////////////////////////////////////////////////////////////////////////////////
//                                                                                      //
// NOTICE OF COPYRIGHT                                                                  //
//                                                                                      //
//                                                                                      //
//Copyright (C) 2010 onwards  Computer Sciences Corporation  http://www.csc.com         //
//                                                                                      //
// This program is free software: you can redistribute it and/or modify                 //
// it under the terms of the GNU General Public License as published by                 //
// the Free Software Foundation, either version 3 of the License, or                    //
// (at your option) any later version.                                                  //
//                                                                                      //
// This program is distributed in the hope that it will be useful,                      //
// but WITHOUT ANY WARRANTY; without even the implied warranty of                       //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                        //
// GNU General Public License for more details.                                         //
//                                                                                      //
//  You should have received a copy of the GNU General Public License                   //
//  along with this program.If not, see <http://www.gnu.org/licenses/>.                 //
//                                                                                      //
// @Created by: Venkatakrishnan                                                         //
// @date: 3/20/13  2:30 PM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////
?>
<script type="text/javascript" >
    $(document).ready(function() {

        var orgUnitHeadSignChangeChecked = $('#changeOrgUnitHeadSignature:checked').val()?true:false;
        var verticalHeadSignChangeChecked = $('#changeVerticalHeadSignature:checked').val()?true:false;
        var productLineManagerSignChangeChecked = $('#changeProductLineManagerSignature:checked').val()?true:false;
        var requestOrgUnitHeadSignChecked = $('#requestOrgUnitHeadSignature:checked').val()?true:false;
        var requestVerticalHeadSignature = $('#requestVerticalHeadSignature:checked').val()?true:false;
        var requestProductLineManagerSignature = $('#requestProductLineManagerSignature:checked').val()?true:false;

        //Initial setup : Stabilize the controls based on the checkbox values
        toggleDisplay($('#orgUnitHeadSignatureImage').length > 0 && !orgUnitHeadSignChangeChecked, 'orgUnitHeadSignatureImage', 'orgUnitHeadSignature');
        toggleDisplay($('#verticalHeadSignatureImage').length > 0 && !verticalHeadSignChangeChecked, 'verticalHeadSignatureImage', 'verticalHeadSignature');
        toggleDisplay($('#productLineManagerSignatureImage').length > 0 && !productLineManagerSignChangeChecked, 'productLineManagerSignatureImage', 'productLineManagerSignature');
        toggleDisplay(requestOrgUnitHeadSignChecked, 'orgUnitHeadNameEmailSection', 'orgUnitHeadSignatureFileUploadSection');
        toggleDisplay(requestVerticalHeadSignature, 'verticalHeadNameEmailSection', 'verticalHeadSignatureFileUploadSection');
        toggleDisplay(requestProductLineManagerSignature, 'productLineManagerNameEmailSection', 'productLineManagerSignatureFileUploadSection');

        //Binding the onclick events for the checkboxes.
        $('#requestOrgUnitHeadSignature').click(function(){
            var checked = $('#requestOrgUnitHeadSignature:checked').val()?true:false;
            toggleDisplay(checked, 'orgUnitHeadNameEmailSection', 'orgUnitHeadSignatureFileUploadSection');
        });

        $('#changeOrgUnitHeadSignature').click(function(){
            var checked = $('#changeOrgUnitHeadSignature:checked').val()?true:false;
            toggleDisplay(checked, 'orgUnitHeadSignature', 'orgUnitHeadSignatureImage');
        });

        $('#requestVerticalHeadSignature').click(function(){
            var checked = $('#requestVerticalHeadSignature:checked').val()?true:false;
            toggleDisplay(checked, 'verticalHeadNameEmailSection', 'verticalHeadSignatureFileUploadSection');
        });

        $('#changeVerticalHeadSignature').click(function(){
            var checked = $('#changeVerticalHeadSignature:checked').val()?true:false;
            toggleDisplay(checked, 'verticalHeadSignature', 'verticalHeadSignatureImage');
        });

        $('#requestProductLineManagerSignature').click(function(){
            var checked = $('#requestProductLineManagerSignature:checked').val()?true:false;
            toggleDisplay(checked, 'productLineManagerNameEmailSection', 'productLineManagerSignatureFileUploadSection');
        });

        $('#changeProductLineManagerSignature').click(function(){
            var checked = $('#changeProductLineManagerSignature:checked').val()?true:false;
            toggleDisplay(checked, 'productLineManagerSignature', 'productLineManagerSignatureImage');
        });

        $('#orgUnitHeadDesignation').val(<?php echo $pagefields["OrgUnitHeadDesignation"] ?>);
        $('#verticalHeadDesignation').val(<?php echo $pagefields["VerticalHeadDesignation"] ?>);
        $('#productLineManagerDesignation').val(<?php echo $pagefields["ProductLineManagerDesignation"] ?>);
        $( "#tabs" ).tabs();
    });

    function toggleDisplay(condition, controlToDisplayWhenTrue, controlToHideWhenTrue)
    {
        if(condition)
        {
            $('#'+ controlToDisplayWhenTrue).show();
            $('#'+ controlToHideWhenTrue).hide();
        }
        else
        {
            $('#'+ controlToDisplayWhenTrue).hide();
            $('#'+ controlToHideWhenTrue).show();
        }
    }
</script>
<?php
/**
 * Displaying errors
 */
$errorMessage = implode($error, '\n');
if(count($error) > 0)
{
    echo '<script type="text/javascript"> $(document).ready(function(){ alert("Please correct the following errors: \n\n'.$errorMessage.'"); });</script>';
}
$form = new lscform();
$searchButton = sprintf('<a id="searchUser" href="#"><img src="'.WEB_PATH.'/content/images/search-button.png" title="%s" height="20" width="20" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['searchuser']);
$sendEmailButton = sprintf('<a id="sendEmail" href="#"><img src="'.WEB_PATH.'/content/images/CommonImages/emailButton.png" title="%s" height="20" width="20" alt="" style="border: none; margin: 7px 0px 0px 5px;" /></a>', $lang['send_email']);
$form->openForm(array('action' => $data['submissionURL'], 'name' => 'addRoleForm', 'id'=>'addRoleForm'));

// The General Section
$form->addInline('<div style="float:left; width : 370px">');
$form->addLabel($lang['role_name'] . ' <font color="red">*</font>', array('for' => 'roleName'));

$form->addInput('text', array('name' => 'roleName', 'id' => 'roleName', "value" => $pagefields["RoleName"], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br/>');

$form->addLabel($lang['role_short_name'] . ' <font color="red">*</font>', array('for' => 'roleShortName'));
$form->addInput('text', array('name' => 'roleShortName', 'id' => 'roleShortName', "value" => $pagefields["RoleShortName"], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br/>');

$form->addLabel($lang['certificate_name'] . ' <font color="red">*</font>', array('for' => 'certName'));
$form->addInput('text', array('name' => 'certName', 'id' => 'certName', "value" => $pagefields["CertificateName"], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br/>');

$form->addLabel($lang['role_k_module_dfn_owner'] . ' <font color="red">*</font>', array('for' => 'roleModuleDefinitionOwner'));
$form->addInput('text', array('name' => 'roleModuleDefinitionOwner', 'id' => 'roleModuleDefinitionOwner', 'value' => $pagefields["RoleKModuleDefnOwner"], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('<br/>');

$form->addLabel($lang['role_k_module_dfn_approver'] . ' <font color="red">*</font>', array('for' => 'roleModuleDefinitionApprover'));
$form->addInput('text', array('name' => 'roleModuleDefinitionApprover', 'id' => 'roleModuleDefinitionApprover', 'value' => $pagefields["RoleKModuleDefnApprover"], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addInline('</div>');

// Create the Tab layout and Render
$tabsHtml = '<div id="tabs" style="width:450px; float:left; margin-left: 30px;"><ul><li><a href="#tabs-1">Level 1 Head</a></li><li><a href="#tabs-2">Level 2 Head</a></li><li><a href="#tabs-3">Level 3 Head</a></li>  </ul><div id="tabs-1" style="height: 150px;">';
$form->addInline($tabsHtml);

//The signature Section
// Organization Unit Head section
$form->addLabel($lang['designation'] . ' <font color="red">*</font>', array('for' => 'orgUnitHeadDesignation'));
$form->openSelect(array('name' => 'orgUnitHeadDesignation', 'id' => 'orgUnitHeadDesignation', 'value' => $pagefields['OrgUnitHeadDesignation'], 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Org Unit Head Designations', array('value' => ''));
$form->addOption('Org Unit Head', array('value' => '1'));
$form->addOption('Global Account Executive', array('value' => '2'));
$form->closeSelect();
$form->addInline('<br/>');
$form->addInline('<div id="orgUnitHeadSignatureFileUploadSection">');
$form->addLabel($lang['signature'], array('for' => 'orgUnitHeadSignature', 'style' => ''));
if(!empty($pagefields["OrgUnitHeadSignature"]))
{
    $form->addInline(sprintf("<img id='orgUnitHeadSignatureImage' width='150px' height='40px' style='border: #666666 solid thin;' src='data:image/png;base64,%s' />", base64_encode($pagefields["OrgUnitHeadSignature"])));
}
$form->addInput('file', array('name' => 'orgUnitHeadSignature', 'id' => 'orgUnitHeadSignature', 'style' => ''));
$form->addInline('</div><div id="orgUnitHeadNameEmailSection">');
$form->addLabel($lang['name'], array('for' => 'orgUnitHeadName'));
$form->addInput('text', array('name' => 'orgUnitHeadName', 'id' => 'orgUnitHeadName', "style" => "margin-right: 0.3em;"));
$form->addInline($searchButton.$sendEmailButton);
$form->addInline('</div>');
if(!empty($pagefields["OrgUnitHeadSignature"]))
{
    $form->addLabel($lang['change_sign'], array('for' => 'changeOrgUnitHeadSignature'));
    $form->addInput('checkbox', array('name' => 'changeOrgUnitHeadSignature', 'id' => 'changeOrgUnitHeadSignature', 'value' => 'true', $pagefields['ChangeOrgUnitHeadSignature'] => $pagefields['ChangeOrgUnitHeadSignature']));
}
$form->addLabel($lang['request_new_signature'], array('for' => 'requestOrgUnitHeadSignature'));
$form->addInput('checkbox', array('name' => 'requestOrgUnitHeadSignature', 'id' => 'requestOrgUnitHeadSignature', 'value' => 'true', $pagefields['ReqOrgUnitHeadSignature'] => $pagefields['ReqOrgUnitHeadSignature']));
$form->addInline('</div><div id="tabs-2"  style="height: 150px; width: 500px">');

//Vertical Head Section
$form->addLabel($lang['designation'] . ' <font color="red">*</font>', array('for' => 'verticalHeadDesignation'));
$form->openSelect(array('name' => 'verticalHeadDesignation', 'id' => 'verticalHeadDesignation', 'value' => $pagefields['VerticalHeadDesignation'], 'data-validation' => 'required;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Vertical Head Designations', array('value' => ''));
$form->addOption('Vertical Head', array('value' => '1'));
$form->addOption('Account Lead', array('value' => '2'));
$form->addOption('Global Program Executive', array('value' => '3'));
$form->closeSelect();
$form->addInline('<br/><div id="verticalHeadSignatureFileUploadSection">');
$form->addLabel($lang['signature'], array('for' => 'verticalHeadSignature', 'style' => ''));
if(!empty($pagefields["VerticalHeadSignature"]))
{
    $form->addInline(sprintf("<img id='verticalHeadSignatureImage' width='150px' height='40px' style='border: #666666 solid thin;' src='data:image/png;base64,%s' />", base64_encode($pagefields["VerticalHeadSignature"])));
}
$form->addInput('file', array('name' => 'verticalHeadSignature', 'id' => 'verticalHeadSignature', 'style' => ''));
$form->addInline('</div><div id="verticalHeadNameEmailSection">');
$form->addLabel($lang['name'], array('for' => 'verticalHeadName'));
$form->addInput('text', array('name' => 'verticalHeadName', 'id' => 'verticalHeadName', "style" => "margin-right: 0.3em;"));
$form->addInline($searchButton.$sendEmailButton);
$form->addInline('</div>');
if(!empty($pagefields["VerticalHeadSignature"]))
{
    $form->addLabel($lang['change_sign'], array('for' => 'changeVerticalHeadSignature'));
    $form->addInput('checkbox', array('name' => 'changeVerticalHeadSignature', 'id' => 'changeVerticalHeadSignature', 'value' => 'true', $pagefields['ChangeVerticalHeadSignature'] => $pagefields['ChangeVerticalHeadSignature']));
}
$form->addLabel($lang['request_new_signature'], array('for' => 'requestVerticalHeadSignature'));
$form->addInput('checkbox', array('name' => 'requestVerticalHeadSignature', 'id' => 'requestVerticalHeadSignature', 'value' => 'true', $pagefields['ReqVerticalHeadSignature'] => $pagefields['ReqVerticalHeadSignature']));
$form->addInline('</div><div id="tabs-3"  style="height: 150px;">');

//Product Line manager section
$form->addLabel($lang['designation'] . ' <font color="red">*</font>', array('for' => 'productLineManagerDesignation'));
$form->openSelect(array('name' => 'productLineManagerDesignation', 'id' => 'productLineManagerDesignation', 'value' => $pagefields['ProductLineManagerDesignation'], 'data-validation' => 'required;alpha-numeric;', 'onblur' => sprintf("validate(this, '%s');", WEB_PATH)));
$form->addOption('Select Productline Manager Designations', array('value' => ''));
$form->addOption('Functional Manager', array('value' => '1'));
$form->addOption('Account Lead', array('value' => '2'));
$form->addOption('Line Of Service PE', array('value' => '3'));
$form->closeSelect();
$form->addInline('<br/><div id="productLineManagerSignatureFileUploadSection">');
$form->addLabel($lang['signature'], array('for' => 'productLineManagerSignature', 'style' => ''));
if(!empty($pagefields["ProductLineManagerSignature"]))
{
    $form->addInline(sprintf("<img id='productLineManagerSignatureImage' width='150px' height='40px' style='border: #666666 solid thin;' src='data:image/png;base64,%s' />", base64_encode($pagefields["ProductLineManagerSignature"])));
}
$form->addInput('file', array('name' => 'productLineManagerSignature', 'id' => 'productLineManagerSignature', 'style' => ''));
$form->addInline('</div><div id="productLineManagerNameEmailSection">');
$form->addLabel($lang['name'], array('for' => 'productLineManagerName'));
$form->addInput('text', array('name' => 'productLineManagerName', 'id' => 'productLineManagerName', "style" => "margin-right: 0.3em;"));
$form->addInline($searchButton.$sendEmailButton);
$form->addInline('</div>');
if(!empty($pagefields["ProductLineManagerSignature"]))
{
    $form->addLabel($lang['change_sign'], array('for' => 'changeProductLineManagerSignature'));
    $form->addInput('checkbox', array('name' => 'changeProductLineManagerSignature', 'id' => 'changeProductLineManagerSignature', 'value' => 'true', $pagefields['ChangeProductLineManagerSignature'] => $pagefields['ChangeProductLineManagerSignature']));
}
$form->addLabel($lang['request_new_signature'], array('for' => 'requestProductLineManagerSignature'));
$form->addInput('checkbox', array('name' => 'requestProductLineManagerSignature', 'id' => 'requestProductLineManagerSignature', 'value' => 'true', $pagefields['ReqProductLineManagerSignature'] => $pagefields['ReqProductLineManagerSignature']));

$form->addInline("</div></div>");
$form->addInput('submit', array('value'=> ' Save Changes ', 'style' => 'clear:both; position:relative; display:block;', "onclick"=>"validateAndSubmit(event, 'addRoleForm');"));
$form->closeForm();
echo $form;
?>
