<?php

class EditorController
{
    private $editorModel;
    private $presenter;

    public function __construct($editorModel, $presenter) {
        $this->editorModel = $editorModel;
        $this->presenter = $presenter;
    }

    public function getEditorView(){
        $totalQuestions = $this->editorModel->getAllQuestions();

        $data['editor'] = [
            'totalQuestions' => $totalQuestions,
        ];
    }
}