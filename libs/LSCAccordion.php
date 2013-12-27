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
    // @Created by: Venkatakrishnan                                                         //
    // @date: March 3rd 2013                                                    	   		//
    // @version: 1.0								       									//
    // @description: Library for including accordion into any php page                	    //
    //                                                                              		//
    //////////////////////////////////////////////////////////////////////////////////////////

	class LSCAccordion
	{
		private $accordion;
		
		function __construct()
		{
			$this->accordion = array();
		}
		
		public function Add_HeaderAndContent($header, $content, $headerOptions)
		{
			$accordionUnit = new AccordionUnit($header, $content, $headerOptions);
			$this->accordion[count($this->accordion)] = $accordionUnit;
		}

		public function RenderAccordion()
		{
			$styleSheetScript = sprintf('<link href="%scontent/css/Accordion.css" rel="stylesheet" type="text/css" />', WEB_PATH);
			$accordionMainScript = sprintf('<script type="text/javascript" src="%scontent/js/ddaccordion.js"></script>', WEB_PATH);
            $accordionInitialization = sprintf('<script type="text/javascript" src="%scontent/js/ddaccordion-init.js"></script>', WEB_PATH);

            $output = '';
            $output .= $styleSheetScript;
            $output .= $accordionMainScript;
            $output .= $accordionInitialization;

            foreach($this->accordion as $accordionUnit)
            {
                $output .= '<div class="accordionheader">';
                $output .= '<div class="headerTitle">';
                $output .= $accordionUnit->HeaderTitleText;
                $output .= '</div>';
                foreach($accordionUnit->HeaderOptions as $headerOption)
                {
                    $output .= sprintf("<a class = \"headerOptions\" href=\"%s\">", $headerOption->URL);
                    $output .= $headerOption->Title;
                    $output .= '</a>';
                }
                $output .= '</div><div class="accordionContent">';
                $output .= $accordionUnit->Content;
                $output .= '</div>';
            }

            echo $output;
		}

        public function RenderNestedAccordion()
        {
            $output = '';
            foreach($this->accordion as $accordionUnit)
            {
                $output .= '<div class="accordionheader">';
                $output .= '<div class="headerTitle">';
                $output .= $accordionUnit->HeaderTitleText;
                $output .= '</div>';
                foreach($accordionUnit->HeaderOptions as $headerOption)
                {
                    $output .= sprintf("<a class = \"headerOptions\" href=\"%s\">", $headerOption->URL);
                    $output .= $headerOption->Title;
                    $output .= '</a>';
                }
                $output .= '</div><div class="accordionContent">';
                $output .= $accordionUnit->Content;
                $output .= '</div>';
            }

            return $output;
        }
	}
	
	/// An AccordionUnit is a minimum pair of a Header and a Content that goes into an accordion.
    /// The header Options are the additional options that appear on the right hand side of the accordion.
    /// These header options are usually Hyperlinks.
    class AccordionUnit
	{
		public $HeaderTitleText;
		public $Content;
		public $HeaderOptions;
		
		public function __construct($header, $content, $headerOptions)
		{
			$this->HeaderTitleText = $header;
			$this->Content = $content;
            $this->HeaderOptions = $headerOptions;
		}
	}
	
	class HeaderOption
	{
		public $Title;
		public $URL;
		
		function __construct($title, $url)
		{
			$this->Title = $title;
			$this->URL = $url;
		}
	}