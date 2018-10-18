<?php
$db = pg_connect("host=localhost port=5432 dbname=tareaphp user=postgres password=1234");
$pw = $_POST['password'];
$pw2 = $_POST['pw2'];
if ($pw != $pw2) {
	die("Las contraseñas no son iguales");
	
}
$query = "INSERT INTO usuario VALUES ('$_POST[name]','$_POST[email]',
'$_POST[password]')";

if (pg_send_query($db, $query)) {
  $res=pg_get_result($db);
  if ($res) {
    $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
    if ($state==0) {
      // success
    }
    else {
      // some error happened
      if ($state=="23505") { // unique_violation
        die("El usuario ya existe");
      }
      else {
	die("Registro fallido");
       // process other errors
      }
    }
  }  
}

?>
