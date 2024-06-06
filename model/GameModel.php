<?php

class GameModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function createGame($userId)
    {
        $gameId = 5; //hardcodeado
        $query = "INSERT INTO partida (id_partida, id_user) VALUES (?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ii", $gameId, $userId);

        if ($stmt->execute()) {
            $stmt->close();
            return $gameId;
        } else {
            $stmt->close();
            return false;
        }
    }

    public function saveAnswer($gameId, $userId, $questionId, $selectedOption)
    {


        $query = "SELECT right_answer FROM answer WHERE question_id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $questionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $correctAnswer = $result->fetch_assoc()['right_answer'];
        $stmt->close();

        $wasRight = ($selectedOption == $correctAnswer) ? 1 : 0;

        $query = "INSERT INTO partida (id_partida, id_user, id_question, was_right) VALUES (?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("iiib", $gameId, $userId, $questionId, $wasRight);
        $stmt->execute();
        $stmt->close();

        return $wasRight;
    }

    public function getQuestion($gameId, $userId) {
        $query = "SELECT q.id, q.pregunta, a.option_a, a.option_b, a.option_c, a.option_d 
                  FROM question q 
                  JOIN answer a ON q.id = a.question_id
                  WHERE q.id NOT IN (
                      SELECT id_question FROM partida WHERE id_partida = ? AND id_user = ?
                  )
                  ORDER BY RAND() LIMIT 1";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ii", $gameId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $question = $result->fetch_assoc();
        $stmt->close();

        return $question;
    }
}