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
// @date: 3/25/13  11:02 AM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
//////////////////////////////////////////////////////////////////////////////////////////
?>
<style type="text/css" media="screen">
    @import "<?php echo WEB_PATH; ?>/content/media/css/data_page.css";
    @import "<?php echo WEB_PATH; ?>/content/media/css/data_table.css";

    @import "<?php echo WEB_PATH; ?>/content/media/css/data_table_jui.css";
    @import "<?php echo WEB_PATH; ?>/content/media/css/themes/base/jquery-ui.css";
    .dataTables_info { padding-top: 0; }
    .dataTables_paginate { padding-top: 0; }
    .css_right { float: right; }
    #example_wrapper .fg-toolbar { font-size: 0.8em }
    #theme_links span { float: left; padding: 2px 10px; }
</style>

<script src="<?php echo WEB_PATH; ?>/content/media/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
    $(document).ready( function () {
        $('#example').dataTable({ bJQueryUI: true,

            "sPaginationType": "full_numbers"
        })

    } );
</script>

<?php
            $form = new lscform();
            //Form Start
            $form->openForm(array('method' => 'POST', 'action' => '', 'id' => 'viewRoles', 'name' => 'viewRoles'));
            $form->addInline('<div class="jquery-table" >');
            $form->openTable(array('name' => 'viewRolesTable', 'cellpadding' => "0", 'cellspacing' => "0", 'border' => "0", 'class' => "display", 'id' => "example"));
            $form->openTableHeader();
            $form->openTableRow();
            $form->addTableHead('Roles');
            $form->addTableHead('');
            $form->addTableHead('');
            $form->addTableHead('');
            $form->addTableHead('');
            $form->addTableHead('');
            $form->closeTableRow();
            $form->closeTableHeader();
            $form->openTableBody();
            foreach($data["roles"] as $row)
            {
                $form->openTableRow(array('class' => "odd_gradeX", 'id' => "2"));
                $form->addTableColumn(sprintf('<a href="?load=roles/editRole/%s">%s</a>', $row["id"], $row["role_name"]));
                $form->addTableColumn(sprintf('<a href="?load=roles/editRole/%s">Manage Modules</a>', '#'));
				$form->addTableColumn(sprintf('<a href="?load=roleAssignResource/assignResource/%s/%s">Assign/Deassign Resource</a>', $row["id"], $row["account_id"]));
                $form->addTableColumn(sprintf('<a href="?load=roles/editRole/%s">Manage KTPM/TargetDate </a>', '#'));
                $form->addTableColumn(sprintf('<a href="?load=roles/showCertificate/%s" target="_blank">View Certificate</a>', $row["id"]));
                $form->addTableColumn(sprintf("<img src=\"%scontent/images/delete-icon.png\" alt=\"Delete\" onclick=\"alertAndRedirect('Do you want to delete this role?', '%s?load=roles/deleteRole/%s/%s')\" />", WEB_PATH, WEB_PATH, $data["accountID"], $row["id"]));
                $form->closeTableRow();
            }
            $form->closeTableBody();
            $form->closeTable();
            $form->addInline('</div>');
            $form->closeForm();
            echo $form;
?>