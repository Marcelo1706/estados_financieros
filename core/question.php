<?php
include_once('configuracion.php');
include_once('baseDatos.php');

class question {

    private $q;
    private $db;
    private $correct_answer;

    public function __construct() {
        $this->db = new baseDatos("localhost","estados_financieros","root","mysql");
    }

    private function getRandomAnswer(){
        $res = $this->db->consulta_personalizada("Select respuesta from pregunta order by rand() limit 1;")[0];
        return $res['respuesta'];
    }

    public function getQuestionFromDb(){
        $res = $this->db->consulta_personalizada("Select * from pregunta where used = 0 Limit 1;");

        if(count($res) <= 0){
            $this->resetAllQuestions();
            $res = $this->db->consulta_personalizada("Select * from pregunta where used = 0 Limit 1;");
        }

        $ary = $res[0];
        try{
            $this->q = $ary['preg'];
            $real = $ary['respuesta'];
            $respa = $ary['respuesta'];
            $respb = $this->getRandomAnswer();
            $respc = $this->getRandomAnswer();
            $respd = $this->getRandomAnswer();
            $this->answers = array($respa,$respb,$respc,$respd);
            shuffle($this->answers);
            $this->correct_answer = array_search($real, $this->answers)+1;
        } catch (Exception $e) {
            echo "Cant fetch into array" . $e->getMessage();
        }

        $this->db->consulta_personalizada("Update pregunta SET used = 1 where id_pregunta = ". $ary['id_pregunta']);
    }

    public function getQuestion() {
        return $this->q;       
    }

    public function getFourAnswers() {
        return $this->answers;
    }

    public function getCorrectAnswer() {
        return $this->correct_answer;
    }

    public function resetAllQuestions() {
        try {
            $this->db->consulta_personalizada("Update pregunta set used = 0");
        } catch (Exception $e) {
            echo "Cant reset questions" . $e->getMessage();
        }
    }
}
?>