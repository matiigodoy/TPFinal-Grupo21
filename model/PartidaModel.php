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

    public function startPartida(){
        $cheat = $this->validateUserCheated();
        if($cheat) return $cheat;
        $this->registerPartida();
        return $this->handlePartida();
    }

    public function validateUserCheated(){
        //si questionId no esta seteada OR 
        //el request viene de continuePartida (que la 1era vez tampoco esta seteada) ENTRA.
        //SINO ES TRAMPA
        if (!isset($_SESSION['questionId']) || ($_REQUEST['action'] == "continuePartida" && !isset($_SESSION['questionId']))) {

            $_SESSION['questionId'] = 0;
            return;
        }

        unset($_SESSION['questionId']);
        return ["fail" => "Lo siento, registramos que has hecho trampa o pasó algo raro. Podés volver al lobby y reintentar otra partida."];
    }

    public function handlePartida(){


        $flowValues = $this->startFlowPartida();
        if($this->checkWin($flowValues)) {
            unset($_SESSION['questionId']);
            return $flowValues;
        }
        $questionOK = false;
        if ($flowValues) {
            $questionOK = $this->registerUserWithThatQuestion($flowValues['question']);

            if($questionOK){
                $_SESSION['questionId'] = $flowValues['question']['id'];
            }
            $flowValues = $this->determineCategoryView($flowValues['category'], $flowValues);

            return ["category" => $flowValues['category'],
                "pregunta" => $flowValues['question']['pregunta'],
                "answers" => $flowValues['answers'],
                "answerKeys" => $flowValues['answerKeys'],
                "correct" => $flowValues['correct']['right_answer'],
                "questionOk" => $questionOK,
                "questionClass" => $flowValues['questionClass'],
                "questionStyle" => $flowValues['questionStyle'],
                "buttonClass" => $flowValues['buttonClass'],
                "buttonStyle" => $flowValues['buttonStyle']
            ];
        }
        return ["fail" => "Lo sentimos, hubo un error, intente en un momento más tarde"];
    }
    public function determineCategoryView($category, $flowValues){
        switch ($category) {
            case 'historia':
                $flowValues['questionClass'] = "d-grid gap-2 bg-warning";
                $flowValues['questionStyle'] = "";
                $flowValues['buttonClass'] = "g-col-2 btn btn-warning";
                $flowValues['buttonStyle'] = "width:100%; margin: 0em 0em 2em 0em;";
                return $flowValues;

            case 'cultura':
                $flowValues['questionClass'] = "d-grid gap-2";
                $flowValues['questionStyle'] = "background-color:blueviolet; color:white;";
                $flowValues['buttonClass'] = "g-col-2 btn";
                $flowValues['buttonStyle'] = "width:100%; margin: 0em 0em 2em 0em;background-color:blueviolet;color:white;";
                return $flowValues;

            case 'deportes':
                $flowValues['questionClass'] = "d-grid gap-2 bg-success text-light";
                $flowValues['questionStyle'] = "";
                $flowValues['buttonClass'] = "g-col-2 btn btn-success";
                $flowValues['buttonStyle'] = "width:100%; margin: 0em 0em 2em 0em;";
                return $flowValues;

            default:
                $flowValues['questionClass'] = "d-grid gap-2 bg-success text-light";
                $flowValues['questionStyle'] = "";
                $flowValues['buttonClass'] = "g-col-2 btn btn-light";
                $flowValues['buttonStyle'] = "width:100%; margin: 0em 0em 2em 0em;";
                return $flowValues;
        }
    }

    public function startFlowPartida() {
        $data = [];

        $data = $this->bringQuestionAndAnswers($data);

        return $data;
    }

    public function bringQuestionAndAnswers($data){
        //si chotea escribiendo a mano 'continue partida' tenemos como atajarnos
        if(!$_POST)
            return [];

        $sessionId = $_SESSION['userID'];
        $category = array_key_first($_POST);
        $data['category'] = $category;
        $accuracyPerc = $this->bringUserAccuracy($_SESSION['userID']);
        if(!$accuracyPerc) {
            $accuracyPerc = 0;
        }
        //restamos 130 y no 100 para evitar un 0 en primer ingreso y hacer mas facil el juego
        $userEasinessOfQuestions = 130 - $accuracyPerc;
        //$questionEasiness = $this->bringQuestionEasiness($userEasinessOfQuestions, $category);

        $query = $this->prepareBringQuestionAccToUserQuery($category, $userEasinessOfQuestions, $sessionId);
        $dataRaw = $this->database->query($query);
        if(empty($dataRaw)){
            $query = $this->prepareBringOnlyQuestionsWronglyAnswered($category, $sessionId);
            $dataRaw = $this->database->query($query);
        }
        if(empty($dataRaw)){
            $query = $this->prepareBringAllQuestionsQuery($category, $sessionId);
            $dataRaw = $this->database->query($query);
        }
        if (count($dataRaw) > 0) {
            $data['question'] = array_slice($dataRaw[0], 0, 3);
            $answersWithKeys = array_slice($dataRaw[0], 4, 4);
            $data['answerKeys'] = array_keys($answersWithKeys);
            $data['answers'] = array_values($answersWithKeys);
            $data['correct'] = array_slice($dataRaw[0], 8, 1);
            $_SESSION['correct'] = $data['correct'];

            return $data;
        }
        //SI ENTRA ACÁ ES PORQUE YA NO HAY MÁS PREGUNTAS, RESPONDIÓ TODO BIEN: GANÓ
        else {
            return ["win" => "¡¡Felicitaciones!! ¡HAS GANADO EL JUEGO!"];
        }
    }

    public function prepareBringQuestionAccToUserQuery($category, $userEaseNumber, $sessionId){
        return "SELECT quest.id, quest.category, quest.pregunta, quest.active, 
                       a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer, 
                       quest.question_ease
                FROM ( 
                        SELECT q.id, q.category, q.pregunta, q.active, 
                        SUM(q.count_acertada) / SUM(q.count_ofrecida) * 100 as question_ease
                        FROM question q 
                        WHERE q.category = '$category'                  
                        GROUP BY q.id 
                        HAVING question_ease <= $userEaseNumber) as quest 
                        LEFT JOIN answer a ON quest.id = a.question_id 
                        LEFT JOIN user_question uq ON quest.id = uq.id_question 
                        WHERE quest.active = 1 
                        AND quest.id NOT IN (
                            SELECT uq.id_question 
                            FROM user_question uq 
                            WHERE uq.id_user = $sessionId
                    ) 
                ORDER BY RAND() 
                LIMIT 1;";
    }

    public function prepareBringOnlyQuestionsWronglyAnswered($category, $sessionId)
    {
        return "SELECT q.id, q.category, q.pregunta, q.active, 
                       a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer 
                FROM question q
                LEFT JOIN answer a ON q.id = a.question_id
                LEFT JOIN user_question uq ON q.id = uq.id_question
                WHERE q.category = '$category'
                AND q.active = 1
                AND q.id IN(SELECT uq.id_question 
                            FROM user_question uq 
                            WHERE uq.id_user = $sessionId
                            AND uq.wasRight = 0)
                ORDER BY RAND()
                LIMIT 1;";
    }

    public function prepareBringAllQuestionsQuery($category, $sessionId){
        return "SELECT q.id, q.category, q.pregunta, q.active, 
                       a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer 
                FROM question q
                LEFT JOIN answer a ON q.id = a.question_id
                LEFT JOIN user_question uq ON q.id = uq.id_question
                WHERE q.category = '$category'
                AND q.active = 1
                AND q.id NOT IN(SELECT uq.id_question 
                            FROM user_question uq 
                            WHERE uq.id_user = $sessionId)
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
    public function registerUserRespondedRightOrWrong($respondedRight, $userId, $questionId){
        $query = "SELECT uq.id FROM user_question uq WHERE uq.id_user = $userId AND uq.id_question = $questionId";
        $userQuestionIdArray = $this->database->query($query);

        $userQuestionId = implode(',', array_column($userQuestionIdArray, 'id'));

        $wasRight = $respondedRight ? "1" : "0";
        $updateRowQuery = "UPDATE `user_question` SET `wasRight` = $wasRight WHERE `user_question`.`id` IN ($userQuestionId)";
        $stmt = $this->prepareQuery($updateRowQuery);
        $updateWasSuccessful = $this->executionSuccessful($stmt);
        return $updateWasSuccessful;
    }

    public function registerQuestionOfferedAndHitCount($questionId, $userCorrect){
        // Preparar la sentencia SQL para actualizar count_ofrecida
        $sql = "UPDATE question q SET count_ofrecida = count_ofrecida + 1";

        // Si la respuesta es correcta, también actualizamos count_acertada
        if ($userCorrect) {
            $sql .= ", count_acertada = count_acertada + 1";
        }

        $sql .= " WHERE q.id = ?";

        $stmt = $this->prepareQuery($sql);
        $stmt->bind_param("i", $questionId);
        return $this->executionSuccessful($stmt);
    }
    public function bringQuestionEasiness($userRatio, $category){

        do {
                $sql = "
                SELECT q.*, SUM(q.count_acertada) / SUM(q.count_ofrecida) * 100 as question_easiness 
                FROM question q 
                WHERE q.category = '$category'
                GROUP BY q.id 
                HAVING question_easiness <= $userRatio";

                $results = $this->database->query($sql);

            if (empty($results)) {
            $userRatio += $increment;
            }
        } while (empty($results));
    return $results;
    }

    public function bringUserAccuracy($userId){
        $sql = "SELECT SUM(uq.wasRight) / COUNT(*) * 100 AS accuracy
	            FROM user_question uq
                WHERE uq.id_user = $userId";

        $accuracyArray = $this->database->query($sql);
        return $accuracyArray[0]['accuracy'];
    }

    public function registerScoreToUser($userId){
        $sql = "UPDATE user u SET score = score + 5 WHERE u.id = ?";

        $stmt = $this->prepareQuery($sql);
        $stmt->bind_param("i", $userId);

        return $this->executionSuccessful($stmt);
    }

    public function checkAnswer(){

        if(!array_key_exists('questionId', $_SESSION))
            return ["fail" => "Has recargado la pagina check answer"];

        $questionId = $_SESSION['questionId'];
        $correctAnswer = $_SESSION['correct']['right_answer'];
        $answerGivenByUser =  array_keys($_POST);
        $optionSubstring = $answerGivenByUser != null ? substr($answerGivenByUser[1], 7) : null;
        $userCorrect = $correctAnswer === $optionSubstring;

        $this->registerUserRespondedRightOrWrong($userCorrect, $_SESSION['userID'], $questionId);
        $this->registerQuestionOfferedAndHitCount($questionId, $userCorrect);
        unset($_SESSION['questionId']);

        if($userCorrect){
            $this->registerScoreToUser($_SESSION['userID']);
            return ["category" => array_key_first($_POST)];
        }
        else{
            return ["questionId" => $questionId];
        }
    }
    public function checkWin($partidaData){
        return isset($partidaData['win']);
    }

    public function continuePartida(){
        $cheat = $this->validateUserCheated();
        if($cheat) return $cheat;
        return $this->handlePartida();
    }

    public function isTimeout($userId, $timeoutSeconds = 15) {
        $query = "SELECT start_time FROM user WHERE id = ?";
        $stmt = $this->prepareQuery($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($startTime);
        $stmt->fetch();
        $stmt->close();

        if ($startTime) {
            $startTime = strtotime($startTime);
            $currentTime = time();
            return ($currentTime - $startTime) > $timeoutSeconds;
        }
        return true;
    }

    public function saveStartTime($userId) {
        $startTime = date('Y-m-d H:i:s');
        $query = "UPDATE user SET start_time = ? WHERE id = ?";
        $stmt = $this->prepareQuery($query);
        $stmt->bind_param("si", $startTime, $userId);
        return $this->executionSuccessful($stmt);
    }


}