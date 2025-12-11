<?php

  include '../model.php';

  $con = estabelecerConexao();

  if( $con ):
    echo "Conexão estabelecida com sucesso!";
  else:
    echo "Erro no estabelecimento da conexão";
  endif;

?>
