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
include_once __SITE_PATH . '/lang/lang.php';
include_once __SITE_PATH . '/app/views/header.php';
require_once __SITE_PATH . '/libs/Session.php';
require_once __SITE_PATH . '/libs/DBUtil.php';
?>

<div style="padding-top: 5px; padding-left: 5px;" class="style1">
    <div class="breadcrumb">
        <span class="left"></span>
        <ul>
            <li><a href="?load=account/accountlists">Home</a></li>
            <li><a href="#">Resource</a></li>
            <li><a href="#" class="active">Add New Resource</a></li>
        </ul>
        <span class="right"></span>
    </div>
</div>
<div class="mcright">
    <div class="mc01">
        <div id="tab-container">
            <?php
            echo "<div align='center'><font color='green'>Success</font></div>";
            ?>
        </div>
    </div>
</div>

<br>
<?php
include(__SITE_PATH . '/app/views/footer.php');
?>