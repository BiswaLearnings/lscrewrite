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
// @Created by Biswakalyana Mohanty                                                      // 
// @date 2013-4-4                                                      	   			// 
// @version 1.0								       										// 
// @description:                              	    // 
//                                                                              		// 
////////////////////////////////////////////////////////////////////////////////////////// 
?>
<?php
require_once __SITE_PATH . '/libs/fpdf/fpdf.php';


class PDF extends FPDF
{

	public $headerImage = array('file'=>'','x'=>'','y'=>'','width'=>'','height'=>'','type'=>'','link'=>'');
	public $footerImage = array('file'=>'','x'=>'','y'=>'','width'=>'','height'=>'','type'=>'','link'=>'');

	function __construct(){

		stream_wrapper_register('var', 'VariableStream'); //VariableStream class is defined below
		
	}
	/**********************************************************************************************/
	/* @author: Biswakalyan Mohanty
	/* Header() function is used to render the page header. 
	/* It is automatically called by AddPage() and should not be called directly by the application. 
	/* The implementation in FPDF is empty, so you have to subclass it and override the method if you want a specific processing.
	/**********************************************************************************************/
	function Header()
	{
	    
	    $this->Image($this->headerImage["file"],$this->headerImage["x"],$this->headerImage["y"],$this->headerImage["width"],$this->headerImage["height"]);
	    $this->ln(5);
	}
	function Footer()
	{
	   
	}
	
	
	/**********************************************************************************************
	* @author: Biswakalyan Mohanty
	* write_text() function is used to print a line in Certificate.  
	**********************************************************************************************/
	function write_text($text, $font, $style, $size)
	{
		$this->setFont("$font", "$style", $size);
	    $this->write( 10, "$text");
	    
	}
	
	
	/**********************************************************************************************
	* @author: Biswakalyan Mohanty
	* write_value() function is used to print a line in Certificate.  
	**********************************************************************************************/
	function write_value($text, $font, $style, $size)
	{
		$this->setFont("$font", "$style", $size);
	    $this->MultiCell(0, 10, $text , 0 ,"C");
	    
	}	
	
	/**********************************************************************************************/
	/* @author: Biswakalyan Mohanty
	/* MemImage() function display images that are loaded in memory without the need of temporary files. 
	/* It displays the blob image file fetched from DB.
	/**********************************************************************************************/
    function MemImage($data, $x=null, $y=null, $w=0, $h=0, $link='')
    {
        
        $v = 'img'.md5($data);
        $GLOBALS[$v] = $data;
        $a = getimagesize('var://'.$v);
        if(!$a){
            $this->Error('Invalid image data');
        }
        $type = substr(strstr($a['mime'],'/'),1);
        $this->Image('var://'.$v, $x, $y, $w, $h, $type, $link);
        unset($GLOBALS[$v]);
    }
	
	
}



/*********************************************************
**  @author: Biswakalyan Mohanty						**
**	Stream handler to read from global variables		**
**********************************************************/
class VariableStream
{
    var $varname;
    var $position;

    function stream_open($path, $mode, $options, &$opened_path)
    {
        $url = parse_url($path);
        $this->varname = $url['host'];
        if(!isset($GLOBALS[$this->varname]))
        {
            trigger_error('Global variable '.$this->varname.' does not exist', E_USER_WARNING);
            return false;
        }
        $this->position = 0;
        return true;
    }

    function stream_read($count)
    {
        $ret = substr($GLOBALS[$this->varname], $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }

    function stream_eof()
    {
        return $this->position >= strlen($GLOBALS[$this->varname]);
    }

    function stream_tell()
    {
        return $this->position;
    }

    function stream_seek($offset, $whence)
    {
        if($whence==SEEK_SET)
        {
            $this->position = $offset;
            return true;
        }
        return false;
    }
    
    function stream_stat()
    {
        return array();
    }
}
