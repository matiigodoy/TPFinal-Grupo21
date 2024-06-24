<?php

class PartidaModel
{
    private $database;
    private $question;
    public function __construct($database) {
        $this->database = $database;
    }

    public function renderPartidaView($presenter){
        return $presenter->render("partida");
    }

    public function startPartida($presenter){

        $this->registerPartida();

        $this->handlePartida($presenter);
    }

    public function handlePartida($presenter){

        $flowValues = $this->startFlowPartida();
        $questionOK = false;
        if ($flowValues) {
            $questionOK = $this->registerUserWithThatQuestion($flowValues['question']);
        
            if($questionOK){
                $_SESSION['questionId'] = $flowValues['question']['id'];
            }
        }

        $presenter->render($flowValues['category'], 
                            ["category" => $flowValues['category'],
                            "pregunta" => $flowValues['question']['pregunta'], 
                            "answers" => $flowValues['answers'], 
                            "answerKeys" => $flowValues['answerKeys'],
                            "correct" => $flowValues['correct']['right_answer'],
                            "questionOk" => $questionOK]);
    }

    public function startFlowPartida(){
        $data = [];

        $data = $this->bringQuestionAndAnswers($data);
        
        return $data;
    }

    public function checkUserAndQuestion($question){
        $questionId = $question['id'];
        $sessionId = $_SESSION['userID'];
        $userQuestionQuery = "SELECT uq.id_question FROM user_question uq WHERE id_user = $sessionId";

        $dbArray = $this->database->query($userQuestionQuery);

        return count($dbArray) > 0;
    }
    public function bringQuestionAndAnswers($data){

        $category = array_key_first($_POST);
        $data['category'] = $category;
        
        // do {
            $query = $this->prepareBringQuestionQuery($category);
            $dataRaw = $this->database->query($query);
            if (count($dataRaw > 0)) {
                # code...
            
            $data['question'] = array_slice($dataRaw[0], 0, 3);
            // $this->registerQuestionIdInQuestionList($data['question']['id']);
            // $questionWasShown = $this->checkUserAndQuestion($data['question']);

        // } while ($questionWasShown);
        
        $answersWithKeys = array_slice($dataRaw[0], 8, 4);
        $data['answerKeys'] = array_keys($answersWithKeys);
        $data['answers'] = array_values($answersWithKeys);
        $data['correct'] = array_slice($dataRaw[0], 12, 1);
        $_SESSION['correct'] = $data['correct'];
        
        

        return $data;
        }
        return null;
    }
    public function prepareBringQuestionQuery($category){
        $sessionId = $_SESSION['userID'];

        return "SELECT q.*, a.* 
                FROM question q
                LEFT JOIN answer a ON q.id = a.question_id
                LEFT JOIN user_question uq ON q.id = uq.id_question
                WHERE q.category = 'historia' 
                AND uq.id_user != $sessionId
                ORDER BY RAND()
                LIMIT 1;";
    }

    public function setQuestionsList(){
        if (!isset($_SESSION['selected_questions'])) {
            $_SESSION['selected_questions'] = [];
            return;
        }
        if($_SESSION['selected_questions'] > 0 && $_SESSION['selected_questions'] < 2) {
            return $_SESSION['selected_questions'];
        }

        return implode(',', $_SESSION['selected_questions']);
    }
    public function registerQuestionIdInQuestionList($selected_question_id){
        $_SESSION['selected_questions'][] = $selected_question_id;
    }
    public function registerUserWithThatQuestion($question){
        $query = "INSERT INTO user_question (id_user, id_question) VALUES (?, ?)";
        $stmt = $this->prepareQuery($query);
        $stmt->bind_param("ii", $_SESSION['userID'], $question['id']);
        $successful = $this->executionSuccessful($stmt);
        return $successful;
    }

    public function registerPartida() {
        $userId = $_SESSION['userID'];
        $time = date('Y-m-d');
        $query = "INSERT INTO partida (id_user, partida_date) 
                  VALUES (?, ?)";
        $stmt = $this->prepareQuery($query);


        $stmt->bind_param("is",
            $userId,
            $time
        );

        return $this->executionSuccessful($stmt);
    }

    public function prepareQuery($query){
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        return $stmt;
    }

    public function executionSuccessful($stmt){

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        $stmt->close();
        return false;
    }

    public function checkAnswer($presenter){
        $correctAnswer = $_SESSION['correct']['right_answer'];
        $answerGivenByUser =  array_keys($_POST);
        $optionSubstring = $answerGivenByUser != null ? substr($answerGivenByUser[0], 7) : null;

        if($correctAnswer === $optionSubstring){
            $presenter->render("successfulAnswer", ["category" => array_key_first($_POST)]);
        }
        else{
            $presenter->render("failedAnswer");
        }
    }

    public function continuePartida($presenter){
        $this->handlePartida($presenter);
    }

}