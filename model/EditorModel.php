<?php

class EditorModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    public function getAllQuestions() {
        $query = "
            SELECT q.id, q.pregunta, q.category, q.count_acertada, q.count_ofrecida, q.isCreada, q.reports,
                   a.option_a, a.option_b, a.option_c, a.option_d, a.right_answer
            FROM questions q
            JOIN answers a ON q.id = a.question_id
        ";
        $result = $this->database->query($query);

        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }

        return $questions;
    }

    public function addQuestion($question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer) {
        $query = "INSERT INTO questions (pregunta, category) VALUES (?, ?)";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('ss', $question, $category);
        $stmt->execute();
        $question_id = $stmt->insert_id;
        $stmt->close();

        $query = "
            INSERT INTO answers (option_a, option_b, option_c, option_d, right_answer, question_id) 
            VALUES (?, ?, ?, ?, ?, ?)
        ";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('sssssi', $option_a, $option_b, $option_c, $option_d, $right_answer, $question_id);
        $stmt->execute();
        $stmt->close();
    }

    public function updateQuestion($id, $question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer) {
        $query = "UPDATE questions SET pregunta = ?, category = ? WHERE id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('ssi', $question, $category, $id);
        $stmt->execute();
        $stmt->close();

        $query = "
            UPDATE answers 
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
        $query = "DELETE FROM answers WHERE question_id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();

        $query = "DELETE FROM questions WHERE id = ?";
        $stmt = $this->database->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

}