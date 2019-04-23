<br><br><br>
<div class="center-box">
    <h2>Tabla de los mejores 10 jugadores</h2>
    <br>
    <table class="table table-striped table-bordered table-hover table-responsive d-table w-100">
        <thead class="thead-dark">
            <tr>
            <th scope="col" width="10%">Posición</th>
            <th scope="col" width="50%">Jugador</th>
            <th scope="col" width="40%">Puntaje</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $resultado = $objBD->consulta_personalizada("SELECT * FROM perfil_usuario ORDER BY puntaje DESC LIMIT 10");
                if(count($resultado) == 0){
                    echo '
                        <tr class="bg-light">
                            <td colspan="3">No hay jugadores registrados aún</td>
                        </tr>
                    ';
                }else{
                    $i = 1;
                    foreach($resultado as $r){
                        extract($r);
                        if($i==1){
                            echo '
                                <tr style="background-color: #fff5a0; color: black;">
                                    <td><img src="/estados_financieros/assets/img/mejor.png"></td>
                                    <td>'.$nombre.'</td>
                                    <td>'.number_format($puntaje).' punto(s)</td>
                                </tr>
                            ';
                        }elseif($i==2){
                            echo '
                                <tr style="background-color: #d8d8d2; color: black;">
                                    <td><img src="/estados_financieros/assets/img/segundo.png"></td>
                                    <td>'.$nombre.'</td>
                                    <td>'.number_format($puntaje).' punto(s)</td>
                                </tr>
                            ';
                        }elseif($i==3){
                            echo '
                                <tr style="background-color: #dca560; color: black;">
                                    <td><img src="/estados_financieros/assets/img/tercero.png"></td>
                                    <td>'.$nombre.'</td>
                                    <td>'.number_format($puntaje).' punto(s)</td>
                                </tr>
                            ';
                        }else{
                            echo '
                                <tr class="bg-light" style="color:black">
                                    <td>'.$i.'</td>
                                    <td>'.$nombre.'</td>
                                    <td>'.number_format($puntaje).' punto(s)</td>
                                </tr>
                            ';
                        }
                        $i++;
                    }
                }
            ?>
        </tbody>
    </table>
    <a href="/estados_financieros/" class="btn btn-secondary btn-raised">Volver</a>
</div>
<br><br><br>