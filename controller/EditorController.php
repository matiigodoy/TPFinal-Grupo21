<?php

class EditorController
{
    private $editorModel;
    private $presenter;

    public function __construct($editorModel, $presenter)
    {
        $this->editorModel = $editorModel;
        $this->presenter = $presenter;
    }

    public function getEditorView()
    {
        $activeQuestions = $this->editorModel->getActiveQuestions();
        $inactiveQuestions = $this->editorModel->getInactiveQuestions();
        $questionsWithReports = $this->editorModel->getQuestionsWithReports();

        $data = [
            'activeQuestions' => $activeQuestions,
            'inactiveQuestions' => $inactiveQuestions,
            'questionsWithReports' => $questionsWithReports
        ];

        $this->presenter->render("editor", $data);
    }

    public function addQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = $_POST['question'];
            $category = $_POST['category'];
            $option_a = $_POST['option_a'];
            $option_b = $_POST['option_b'];
            $option_c = $_POST['option_c'];
            $option_d = $_POST['option_d'];
            $right_answer = $_POST['right_answer'];

            $this->editorModel->addQuestion($question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer);


            return $this->getEditorView();
        }
    }

    public function updateQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $question = $_POST['question'];
            $category = $_POST['category'];
            $option_a = $_POST['option_a'];
            $option_b = $_POST['option_b'];
            $option_c = $_POST['option_c'];
            $option_d = $_POST['option_d'];
            $right_answer = $_POST['right_answer'];

            $this->editorModel->updateQuestion($id, $question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer);

            // Volver a cargar la vista del editor después de actualizar la pregunta
            return $this->getEditorView();
        }
    }

    public function deleteQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $this->editorModel->deleteQuestion($id);

            // Volver a cargar la vista del editor después de eliminar la pregunta
            return $this->getEditorView();
        }
    }

    public function activateQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->editorModel->activateQuestionById($id);

            $this->getEditorView();
        }
    }
}