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
// @Created by Prasanna                                                       //
// @date 2012-12-12                                                      	   			//
// @version 1.0								       										//
// @description:                             	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
?>
<link href="<?php echo WEB_PATH; ?>/content/css/new_styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<title><?php echo $lang['manage_meta_data'];?></title>

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


    <div id="pane">
       <div id="submenus">
        <div class="submenu"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/create.png" height="10" width="10" style="border: none; padding-right: 5px;"/><a href="?load=settings/settingsview"><?php echo $lang['add_meta_data'];?></a></div>
        <div class="submenu active"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/view.png" height="10" width="10" style="border: none; padding-right: 5px;"/><a href="?load=settings/managesettingsview"><?php echo $lang['manage_meta_data'];?></a></div>
        </div>
        <div id="userid"><img src="<?php echo WEB_PATH; ?>/content/images/commonimages/access.png" height="15" width="15" style="border: none; padding-right: 5px; padding-top: 5px"/>
              <?php
        $session = new Session();
        $session->welcome();
        ?>
        </div>
        <hr />
        <div class="bigContainer">
            <strong><?php echo $lang['view_meta_data'];?></strong><hr/>
                <?php
                  //TO DO
                  ob_start();

                  include_once __SITE_PATH.'/templates/settings/display_add_settings.php';
                  ob_end_flush();
                ?>
         </div>
      <?php
include(__SITE_PATH . '/app/views/footer.php');
?>