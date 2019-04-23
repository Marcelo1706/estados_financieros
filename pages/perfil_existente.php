<br><br><br>
<div class="center-box">
    <h2>Selecciona un perfil</h2>
    <br>
    <table class="table table-striped table-bordered table-hover table-responsive d-table w-100">
        <tbody>
            <?php
                $resultado = $objBD->consulta_personalizada("SELECT * FROM perfil_usuario ORDER BY puntaje DESC LIMIT 10");
                if(count($resultado) == 0){
                    echo '
                        <tr class="bg-light">
                            <td>No hay jugadores registrados aún</td>
                        </tr>
                    ';
                }else{
                    $i = 1;
                    foreach($resultado as $r){
                        extract($r);
                        echo '
                            <tr>
                                <td>'.$nombre.'</td>
                                <td><a href="jugar?usuario='.$id_usuario.'" class="btn btn-raised btn-primary">Jugar</a></td>
                            </tr>
                        ';
                        $i++;
                    }
                }
            ?>
        </tbody>
    </table>
    <a href="/estados_financieros/" class="btn btn-secondary btn-raised">Volver</a>
</div>
<br><br><br>