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
require_once __SITE_PATH . '/libs/pdfLib.php';
?>


<?php 
/*
 * Create a pdf
 */

$orientation = "L";
$unit = "mm";
$size = "A4";
$staticText_fontFamily = 'Arial';
$staticText_fontStyle = '';
$staticText_fontSize = 14;
$dynamicText_fontFamily = 'Arial';
$dynamicText_fontStyle = 'IB';
$dynamicText_fontSize = 15;

$certificate = new PDF();
$certificate->headerImage["file"]=WEB_PATH.'content/images/certificateheader.jpg';
$certificate->headerImage["x"]=10;
$certificate->headerImage["y"]=5;
$certificate->headerImage["width"]=275;
$certificate->FPDF($orientation,$unit,$size);
$certificate->AddPage($orientation,$size);
$certificate->SetMargins(5, 6, 10);
$certificate->Image(WEB_PATH.'content/images/lsclogo.jpg',20,60);
$certificate->ln(5);
$certificate->Image(WEB_PATH.'content/images/certificateFlag.jpg',3,135,100,60);

/* certificate text*/
$certificate->SetMargins(105,'',15);
$certificate->SetXY( 105, 40);
$certificate->write_text("This is to certify that ", $staticText_fontFamily,$staticText_fontStyle,$staticText_fontSize);
$certificate->Line(155,48,280,48);
$certificate->Line(105,58,280,58);
$certificate->write_value($data["user_name"], $dynamicText_fontFamily, $dynamicText_fontStyle, $dynamicText_fontSize);

$certificate->SetXY( 105, 60);
$certificate->write_text("has successfully completed the knowledge requirement for the role of  ", $staticText_fontFamily,$staticText_fontStyle,$staticText_fontSize);
$certificate->Line(105,78,280,78);
$certificate->Line(105,88,280,88);
$certificate->Ln();
$certificate->write_value($data['role_name'],$dynamicText_fontFamily, $dynamicText_fontStyle, $dynamicText_fontSize);

$certificate->SetXY( 105, 92);
$certificate->write_text("for the ",$staticText_fontFamily,$staticText_fontStyle,$staticText_fontSize);
$certificate->Line(125,100,280,100);
$certificate->Line(105,110,280,110);
$certificate->write_value($data['account_name'],$dynamicText_fontFamily, $dynamicText_fontStyle, $dynamicText_fontSize);
$certificate->SetXY( 105, 114);
$certificate->write_text("account. ",$staticText_fontFamily,$staticText_fontStyle,$staticText_fontSize);

$certificate->SetXY( 105, 124);
$certificate->write( 10, "This certificate is valid until ");
$certificate->Line(170,132,280,132);
$certificate->write_value( $data['valid_untill'],$dynamicText_fontFamily, $dynamicText_fontStyle, $dynamicText_fontSize);

/* Signature section*/
$certificate->Line(105,175,155,175);
$certificate->Line(170,175,215,175);
$certificate->Line(230,175,275,175);
$certificate->setFont($staticText_fontFamily,$staticText_fontStyle,13);
$certificate->SetXY( 105, 177);
$certificate->Cell(50,5,$data["orgunit_designation"],0,1,"C");
$certificate->SetXY( 170, 177);
$certificate->Cell(50,5,$data["vertical_head_designation"],0,1,"C");
$certificate->SetXY( 230, 177);
$certificate->Cell(50,5,$data["pl_manager_designation"],0,1,"C");
if(!empty($data["orgunit_signature"]))
$certificate->MemImage($data["orgunit_signature"],105,152,50,20);
if(!empty($data["vertical_head_signature"]))
$certificate->MemImage($data["vertical_head_signature"],170,152,50,20);
if(!empty($data["pl_manager_signature"]))
$certificate->MemImage($data["pl_manager_signature"],230,152,50,20);


$certificate->Output();






?>