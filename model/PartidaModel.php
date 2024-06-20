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

        $flowValues = $this->startFlowPartida();

        if($flowValues['userHadThatQuestion']){
            $this->startFlowPartida();
        }

        $this->registerUserWithThatQuestion($flowValues['question']);

        $presenter->render(array_key_last($_GET), 
                            ["pregunta" => $flowValues['question']['pregunta'], 
                            "answers" => $flowValues['answers'], 
                            "answerKeys" => $flowValues['answerKeys'],
                            "correct" => $flowValues['correct']['right_answer']]);
    }
    public function startFlowPartida(){
        $data = [];

        $data = $this->bringQuestionAndAnswers( $data);
        $data['userHadThatQuestion'] = $this->checkUserAndQuestion($data['question']);
        return $data;
    }

    public function checkUserAndQuestion($question){
        $questionId = $question['id'];
        $sessionId = $_SESSION['userID'];
        $this->query = "SELECT * FROM user_question WHERE id_user = $sessionId AND id_question= $questionId";

        $successful = $this->database->query($this->query);
        return $successful;
    }
    public function bringQuestionAndAnswers($data){
        $category = array_key_last($_GET);
        //por ahora no busca por categoria(AND q.category = '$category'), al generar una pregunta al azar, tenemos que colocar preguntas en tablas separadas.
        $this->query = "SELECT q.*, a.* FROM question q 
                        LEFT JOIN answer a 
                        ON q.id = a.question_id 
                        WHERE category = '$category' 
                        ORDER BY RAND()
                        LIMIT 1";
        $dataRaw = $this->database->query($this->query);
        $data['question'] = array_slice($dataRaw[0], 0, 3);
        $answersWithKeys = array_slice($dataRaw[0], 5, 4);
        $data['answerKeys'] = array_keys($answersWithKeys);
        $data['answers'] = array_values($answersWithKeys);
        $data['correct'] = array_slice($dataRaw[0], 9, 1);
        $_SESSION['correct'] = $data['correct'];
        return $data;
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
        $optionSubstring = substr($answerGivenByUser[0], 7);
        $quetieneesto = strpos($answerGivenByUser[0], $correctAnswer);

        if($correctAnswer === $optionSubstring){
            $presenter->render("successfulAnswer");
        }
        else{
            $presenter->render("failedAnswer");
        }
    }
}
