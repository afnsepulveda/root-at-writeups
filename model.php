<?php

function estabelecerConexao()
{
   $hostname = 'localhost';
   $dbname = 'u506280443_afomonDB';
   $username = 'u506280443_afomondbUser';
   $password = '#Bl:cy94e4';

   try {
         $conexao = new PDO( "mysql:host=$hostname;dbname=$dbname;charset=utf8mb4",
                              $username, $password );
   }
   catch( PDOException $e ) {
      echo $e->getMessage();
   }

   return $conexao;
    
}

?>