<?php

class EditorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getActiveQuestions() {
        $query = "SELECT q.id, q.pregunta, q.category, a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer 
              FROM question q
              JOIN answer a ON q.id = a.question_id
              WHERE q.active = 1";  // Solo traer preguntas activas

        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        $stmt->close();
        return $questions;
    }

    public function getQuestionsWithReports() {
        $query = "SELECT q.id, q.pregunta, q.category, a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer 
              FROM question q
              JOIN answer a ON q.id = a.question_id
              WHERE q.reports > 0";

        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        $questionsWithReports = [];
        while ($row = $result->fetch_assoc()) {
            $questionsWithReports[] = $row;
        }

        $stmt->close();
        return $questionsWithReports;
    }

    public function getInactiveQuestions() {
        $query = "SELECT q.id, q.pregunta, q.category, a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer 
              FROM question q
              JOIN answer a ON q.id = a.question_id
              WHERE q.active = 0";  // Solo traer preguntas inactivas

        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result === false) {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }

        $inactiveQuestions = [];
        while ($row = $result->fetch_assoc()) {
            $inactiveQuestions[] = $row;
        }

        $stmt->close();
        return $inactiveQuestions;
    }

    public function addQuestion($question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer) {
        $query = "INSERT INTO question (pregunta, category, active) VALUES (?, ?, 1)";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('ss', $question, $category);
        $stmt->execute();

        $question_id = $stmt->insert_id;
        $stmt->close();

        $query = "INSERT INTO answer (question_id, option_a, option_b, option_c, option_d, right_answer) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('isssss', $question_id, $option_a, $option_b, $option_c, $option_d, $right_answer);
        $stmt->execute();
        $stmt->close();
    }

    public function updateQuestion($id, $question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer) {
        $query = "UPDATE question SET pregunta = ?, category = ? WHERE id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('ssi', $question, $category, $id);
        $stmt->execute();
        $stmt->close();

        $query = "
            UPDATE answer 
            SET option_a = ?, option_b = ?, option_c = ?, option_d = ?, right_answer = ? 
            WHERE question_id = ?
        ";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('sssssi', $option_a, $option_b, $option_c, $option_d, $right_answer, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteQuestion($id) {
        $query = "DELETE FROM answer WHERE question_id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $query = "DELETE FROM question WHERE id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    public function activateQuestionById($id) {
        $query = "UPDATE question SET active = 1 WHERE id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

}