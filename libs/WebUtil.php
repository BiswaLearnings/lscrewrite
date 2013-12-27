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
// @description:                              	    //
//                                                                              		//
//////////////////////////////////////////////////////////////////////////////////////////
?>
<?php

/**
 *
 */
class WebUtil {

    /**
     *
     * @param type $param
     * @return boolean
     */
    function isNumeric($param) {
        if (ctype_digit($param)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param type $param
     * @return boolean
     */
    function isAlphaNumeric($param) {
        if (ctype_alnum($param)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function isStringContainsNumbers($param) {
        if ((preg_match('/\d/', $param) > 0) || $this->isSpecialCharExists($param)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param type $string
     * @return boolean
     */
    function isSpecialCharExists($param) {

        if (preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $param)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param type $param
     * @return boolean
     */
    function isValidEmailAddress($param) {
        if (!filter_var($param, FILTER_VALIDATE_EMAIL)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *
     * @param type $var
     * @return type
     */
    function is_empty($var) {
        return empty($var);
    }

    /**
     *
     * @param type $match
     * @param type $array
     * @return int
     */
    function array_value_count($array) {
        $count = 0;
        foreach ($array as $value) {
                if(!empty($value)){
                    $count++;
                }
        }
        return $count;
    }

    /**
     * Generate CSV from a query result object
     *
     * @access	public
     * @param	object	The query result object
     * @param	string	The delimiter - comma by default
     * @param	string	The newline character - \n by default
     * @param	string	The enclosure - double quote by default
     * @return	string
     */
    function csv_from_result($query, $delim = ",", $newline = "\n", $enclosure = '"') {
        if (!is_object($query) OR !method_exists($query, 'list_fields')) {
            show_error('You must submit a valid result object');
        }

        $out = '';

        // First generate the headings from the table column names
        foreach ($query->list_fields() as $name) {
            $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $name) . $enclosure . $delim;
        }

        $out = rtrim($out);
        $out .= $newline;

        // Next blast through the result array and build out the rows
        foreach ($query->result_array() as $row) {
            foreach ($row as $item) {
                $out .= $enclosure . str_replace($enclosure, $enclosure . $enclosure, $item) . $enclosure . $delim;
            }
            $out = rtrim($out);
            $out .= $newline;
        }

        return $out;
    }

    function isProperSignatureUpload($fileName, $controlName)
    {
        $errors = array();
        $type = strtolower($_FILES[$fileName]['type']);
        $size = $_FILES[$fileName]['size'];
        $validImageTypes = array("image/jpg", "image/gif", "image/png", "image/x-png", "image/bmp", "image/jpeg", "image/pjpeg");
        if(!in_array($type,$validImageTypes))
        {
            $errors[] = "Please choose a valid image type for " . $controlName;
        }
        if($size > 2097152)
        {
            $errors[] = " : Max File size : 2MB for " . $controlName;
        }
        return $errors;
    }
}

?>