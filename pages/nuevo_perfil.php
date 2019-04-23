<br><br><br>
<div class="center-box">
    <h2>Crea un Nuevo Perfil</h2>
    <br>
    <div class="container">
        <form method="post" action="">
            <div class="form-group">
                <label for="usuario" style="color: white;">Nombre de Usuario</label>
                <div style="background-color: rgba(255,255,255,0.7); border-radius: 15px;">
                    <input type="text" class="form-control" id="usuario" aria-describedby="helpUsuario" name="usuario" maxlength="20">
                    <small id="helpUsuario" class="form-text text-muted">El nombre no puede contener espacios</small>
                </div>
            </div>
            <button type="submit" name="enviar" class="btn btn-primary btn-raised">Registrar</button>
            <a href="/estados_financieros/" class="btn btn-secondary btn-raised">Volver</a>
        </form>
    </div>
</div>
<br><br><br>
<?php
if(isset($_POST['enviar'])){
    $nombre = $_POST["usuario"];
    $validacion = count($objBD->leer("perfil_usuario","*",array("nombre" => $nombre)));
    if($validacion == 0){
        if($objBD->insertar("perfil_usuario",array("nombre" => $nombre, "puntaje" => "0"))){
            echo '
                    <script type="text/javascript">
                        swal({
                            text: "Se registró el perfil correctamente, ahora puedes jugar",
                            icon: "success",
                            button: "Aceptar"
                        }).then((result) => {
                            window.location = "/estados_financieros/"
                        })
                    </script>
                ';
        }
    }else{
        echo '
            <script type="text/javascript">
                swal({
                    text: "Ya existe un usuario con ese nombre",
                    icon: "error",
                    button: "Aceptar"
                }).then((result) => {
                    window.location = "/estados_financieros/nuevo_perfil"
                })
            </script>
        ';
    }
}
?>