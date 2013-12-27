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
// @description:                              				// 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php

/**
 * 
 */
class Form {

    var $values = array();  //Holds submitted form field values
    var $errors = array();  //Holds submitted form error messages
    var $num_errors;   //The number of errors in submitted form

    /* Class constructor */

    public function __construct() {
        
    }

    /**
     * setValue - Records the value typed into the given
     * form field by the user.
     */
    function setValue($field, $value) {
        $this->values[$field] = $value;
    }

    /**
     * setError - Records new form error given the form
     * field name and the error message attached to it.
     */
    function setError($field, $errmsg) {
        $this->errors[$field] = $errmsg;
        $this->num_errors = count($this->errors);
    }

    /**
     * value - Returns the value attached to the given
     * field, if none exists, the empty string is returned.
     */
    function value($field) {
        if (array_key_exists($field, $this->values)) {
            return htmlspecialchars(stripslashes($this->values[$field]));
        } else {
            return "";
        }
    }

    /**
     * error - Returns the error message attached to the
     * given field, if none exists, the empty string is returned.
     */
    function error($field) {
        if (array_key_exists($field, $this->errors)) {
            return $this->errors[$field];
        } else {
            return "";
        }
    }

    /* getErrorArray - Returns the array of error messages */

    function getErrorArray() {
        return $this->errors;
    }

    function __toString() {
        return 'Form to String';
    }

}

?>
