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

/**
 *
 */
Class Template {

    function display($page, $data=null, $module_name=null, $callback=null) {
		
    	if ($module_name != '') {
            $path = __SITE_PATH . '/app/views/' . $module_name . '/' . $page . '.php';
        } else {
            $path = __SITE_PATH . '/app/views' . '/' . $page . '.php';
        }
		
        if (file_exists($path) == false) {

            throw new Exception('Template not found in ' . $path);
            return false;
        }
      
        include ($path);
    } 
function display_data($page, $data, $module_name,$pagefields,$griddata,$error) {
    
    	if($module_name!=''){
    		$path = __SITE_PATH . '/app/views/'.$module_name . '/' . $page . '.php' ;
    	}else{
    		$path = __SITE_PATH . '/app/views' . '/' . $page . '.php' ;
    	}
    
    	if (file_exists($path) == false)
    	{
    
    		throw new Exception('Template not found in '. $path);
    		return false;
    	}
    
    	include ($path);
    }

}

?>
