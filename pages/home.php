<?php
  //$layout = __DIR__.'\layout\layout-view.php';
  require_once '../layout/layout.php';
  $title = 'Home';
?>

<article style="text-align: center;">
    <h1>¡Bienvenido aca <?php print $_SESSION['name'];?>!</h1>
    <h4>Aquí se muestra el contenido web visible solo para usuarios registrados.</h4>
</article>