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

        $presenter->render("historia", ["question" => $flowValues['question'], "answers" => $flowValues['answer']]);
    }
    public function startFlowPartida(){
        $data = [];

        $randomNumber = $this->generateRandomNumber();
        $this->bringQuestionAndAnswers($randomNumber, $data);
        $data['userHadThatQuestion'] = $this->checkUserAndQuestion($data['question']);
        return $data;
    }
    public function generateRandomNumber(){
        return random_int(1,50);
    }
    public function checkUserAndQuestion($question){
        $questionId = $question[0]['id'];
        $sessionId = $_SESSION['userID'];
        $this->query = "SELECT * FROM user_question WHERE id_user = $sessionId AND id_question= $questionId";

        $successful = $this->database->query($this->query);
        return $successful;
    }
    public function bringQuestionAndAnswers($randomNumber, $data){
        $category = array_key_last($_GET);
        //por ahora no busca por categoria(AND q.category = '$category'), al generar una pregunta al azar, tenemos que colocar preguntas en tablas separadas.
        $this->query = "SELECT q.*, a.* FROM question q 
                        LEFT JOIN answer a 
                        ON q.id = a.question_id 
                        WHERE q.id = $randomNumber  
                        AND a.question_id = q.id";
        $dataRaw = $this->database->query($this->query);
        $data['question'] = array_fill(0, 3, $dataRaw[0]);
        $data['answers'] = array_fill(2, 5, $dataRaw[0]);
        return $data;
    }

    public function bringAnswer($question){
        $id = $question[0]['id'];
        $query = "SELECT * FROM answer WHERE question_id = $id";
        $sucessful = $this->database->query($query);
        return $sucessful;
    }
    public function registerUserWithThatQuestion($question){
        $query = "INSERT INTO user_question (id_user, id_question) VALUES (?, ?)";
        $stmt = $this->prepareQuery($query);
        $stmt->bind_param("ii", $_SESSION['userID'], $question[0]['id']);
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
}
