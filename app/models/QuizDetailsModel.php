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
// @date: 4/8/13  12:36 PM                                                              //
// @version: 1.0                                                                        //
// @description:                                                                        //
//                                                                                      //
////////////////////////////////////////////////////////////////////////////////////////// 
require_once __SITE_PATH . '/libs/DBUtil.php';
class QuizDetailsModel
{
    private $_questionsAddedFromBank;
    private $_questionsRemovedFromQuiz;
    private $_questionOrder;

    #region Class Getters and Setters
    public function setQuestionsAddedFromBank($questionsAddedFromBank)
    {
        $this->_questionsAddedFromBank = $questionsAddedFromBank;
    }

    public function getQuestionsAddedFromBank()
    {
        return $this->_questionsAddedFromBank;
    }

    public function setQuestionOrder($questionOrder)
    {
        $this->_questionOrder = $questionOrder;
    }

    public function getQuestionOrder()
    {
        return $this->_questionOrder;
    }

    public function setQuestionsRemovedFromQuiz($questionsRemovedFromQuiz)
    {
        $this->_questionsRemovedFromQuiz = $questionsRemovedFromQuiz;
    }

    public function getQuestionsRemovedFromQuiz()
    {
        return $this->_questionsRemovedFromQuiz;
    }
    #endregion

    private $_questions;
    private $_dbUtil;

    public function __construct()
    {
        $this->_dbUtil = new DBUtil();
        $this->_questions = array();
    }

    public function fetchOrderedQuestions($quizID)
    {
        $result = $this->_dbUtil->select(TBL_LSC_QUESTIONS, '*', 'quiz_id = '+$quizID, 'serial' );
        return $result;
    }

    public function populateDataFromPost()
    {
        $this->setQuestionsAddedFromBank($_POST['questionsAddedFromBank']);
        $this->setQuestionsRemovedFromQuiz($_POST['questionsRemovedFromQuiz']);
        $this->setQuestionOrder($_POST['questionOrder']);
    }

    public function save($quizID)
    {
        $questionsAdded = explode(',', $this->_questionsAddedFromBank);
        foreach($questionsAdded as $question)
        {
            if(!empty($question))
            {
                $this->_dbUtil->update(TBL_LSC_QUESTIONS, array('in_quiz = 1'), "id=$question AND quiz_id=$quizID");
            }
        }

        $questionsRemoved = explode(',', $this->_questionsRemovedFromQuiz);
        foreach($questionsRemoved as $question)
        {
            if(!empty($question))
            {
                $this->_dbUtil->update(TBL_LSC_QUESTIONS, array('in_quiz = 0'), "id=$question AND quiz_id=$quizID");
            }
        }

        $questionOrderList = explode(',', $this->_questionOrder);
        foreach($questionOrderList as $questionOrder)
        {
            $questionID_questionOrder_Mapping = explode(':', $questionOrder);
            if(count($questionID_questionOrder_Mapping) == 2)
            {
                $id = $questionID_questionOrder_Mapping[0];
                $order = $questionID_questionOrder_Mapping[1];
                $this->_dbUtil->update(TBL_LSC_QUESTIONS, array("serial = $order"), "id=$id AND quiz_id=$quizID");
            }
        }
    }

    public function moveAllToQuiz($quizID)
    {
        $this->_dbUtil->update(TBL_LSC_QUESTIONS, array('in_quiz = 1'), "quiz_id=$quizID");
    }

    public function moveAllToBank($quizID)
    {
        $this->_dbUtil->update(TBL_LSC_QUESTIONS, array('in_quiz = 0'), "quiz_id=$quizID");
    }
}


