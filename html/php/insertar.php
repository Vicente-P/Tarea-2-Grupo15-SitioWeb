<?php

require('../../db_config.php');
session_start();

if(isset($_POST['agregar'])){
    $id_album = $_POST['id_album'];
    $nombre=$_POST['nombre'];
    $letra=$_POST['letra'];
    $fecha_composicion=$_POST['fecha_composicion'];
    $query= "INSERT INTO CANCIONES(nombre, letra, fecha_composicion) 
    VALUES('$nombre','$letra', '$fecha_composicion') RETURNING id_cancion";
    $consulta = pg_query($dbconn, $query);
    $row = pg_fetch_row($consulta);
    $id_cancion = $row[0];
    $id_artista = $_SESSION['id_artista'];

}
if($consulta){
    $query2 = "INSERT INTO artista_compuso_cancion(id_artista, id_cancion)
    VALUES( $id_artista , $id_cancion)";
    $consulta2 = pg_query($dbconn, $query2);
    if($consulta2){
        $query3 = "INSERT INTO album_tiene_cancion(id_album, id_cancion)
        VALUES($id_album,$id_cancion)";
        $consulta3 = pg_query($dbconn, $query3);
        echo "<script> alert('Canción creada correctamente');window.location='../section/crud_canciones.html'</script>";
    }
}else {
    echo "<script> alert('ERROR: Problemas al crear la canción');window.location='../section/crud_canciones.html'</script>";
}

?>