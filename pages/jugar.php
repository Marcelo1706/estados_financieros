<?php
include_once("core/question.php");
include_once("core/new_question.php");
$du = $objBD->leer("perfil_usuario","*",array("id_usuario" => $_GET['usuario']))[0];
$nom_usuario = $du['nombre'];
$puntaje = $du['puntaje'];
?>
<script language="javascript">
    //variable con los puntajes 
    if(!sessionStorage.puntaje_alto){
        sessionStorage.puntaje_alto = 0;
    }
    //gonna send the correct answer to js to evaluate when clicked.
    var correct_answer = "<? echo 'question_' . $correct; ?>";
    var turn_count = "<? echo $_SESSION['question_number']; ?>"
    var puntaje_base = 200;
    var tiempo_transcurrido = 0;
    var puntaje_final = 0;
    $(document).ready(function(){
        setInterval(() => {
            tiempo_transcurrido++
        }, 1000);
        /*if they click an answer, take care of it*/
        $("#question p").click(function(){
            //correct_answer = question_something
            //alert(correct_answer)
            if(this.id === correct_answer){
                puntaje_final = (puntaje_base*turn_count) - tiempo_transcurrido;
                sessionStorage.puntaje_alto = parseInt(sessionStorage.puntaje_alto) + parseInt(puntaje_final);
                $.ajax({
                    type: "get",
                    url: "ajax?correcta=1&puntaje="+sessionStorage.puntaje_alto+"&id_usuario="+<?php echo $_GET['usuario']?>,
                    success: function(evt){
                        swal({
                            text: "Respuesta Correcta! Ha obtenido: "+puntaje_final+" puntos",
                            icon: "success",
                            button: "Aceptar"
                        }).then((result) => {
                            window.location.reload()
                        })
                    }
                })
            }
            else
            {
                $.ajax({
                    type: "get",
                    url: "ajax?incorrecta=1&puntaje="+sessionStorage.puntaje_alto+"&id_usuario="+<?php echo $_GET['usuario']?>,
                    success: function(evt){
                        swal({
                            text: "Respuesta Incorrecta! El juego ha finalizado",
                            icon: "error",
                            button: "Aceptar"
                        }).then((result) => {
                            sessionStorage.puntaje_alto = 0;
                            window.location = "/estados_financieros/";
                        })
                    }
                })
            }
            
        })
    });
</script>
<br><br><br>
<div class="center-box">
    <h2>Jugar</h2>
    <div class="container" id="question">
        <div class="row">
            <div class="col">Bienvenido <?php echo $nom_usuario ?></div>
            <div class="col">Puntaje más alto: <?php echo number_format($puntaje) ?></div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                <div class="card text-white bg-info mb-3" style="width: 100%">    
                        <h3><?php echo $q->getQuestion(); ?></h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="width: 100%">    
                    <p id="question_1"><strong>A:</strong><? echo $a ?></p>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="width: 100%">    
                    <p id="question_2"><strong>B:</strong><? echo $b ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="width: 100%">    
                    <p id="question_3"><strong>C:</strong><? echo $c ?></p>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="width: 100%">    
                    <p id="question_4"><strong>D:</strong><? echo $d ?></p>                
                </div>
            </div>
        </div>
    </div>
</div>