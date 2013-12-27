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
// @date: 4/4/13  4:35 PM                                                               //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
////////////////////////////////////////////////////////////////////////////////////////// 
require_once __SITE_PATH . '/log4php/Logger.php';
require_once __SITE_PATH . '/app/models/QuizDetailsModel.php';
require_once __SITE_PATH . '/app/models/QuizModel.php';

class QuizController extends baseController
{
    private $_logger;
    private $_template;
    private $_quizDetailsModel;
    private $_quizModel;

    function __construct()
    {
        $this->_template = new Template();
        $this->_logger = Logger::getLogger("Roles Controller");
        $this->_quizDetailsModel = new QuizDetailsModel();
        $this->_quizModel = new QuizModel();
    }

    public function index()
    {}

    public function Details($quizID)
    {
        $data = array();
        $data['questions'] = $this->_quizDetailsModel->fetchOrderedQuestions($quizID);
        $data['quizID'] = $quizID;
        $this->_template->display('quizDetails', $data, 'quiz');
    }

    public function processQuizDetails($quizID)
    {
        $this->_quizDetailsModel->populateDataFromPost();
        $this->_quizDetailsModel->save($quizID);
        $this->Details($quizID);
    }

    public function allToQuiz($quizID)
    {
        $this->_quizDetailsModel->moveAllToQuiz($quizID);
        $this->Details($quizID);
    }

    public function allToBank($quizID)
    {
        $this->_quizDetailsModel->moveAllToBank($quizID);
        $this->Details($quizID);
    }

    public function addQuestion($quizID)
    {
        $data = array();
        $data['grades'] = $this->_quizModel->getGrades();
        $this->_template->display('question', $data, 'quiz');
    }

}
