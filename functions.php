<?php

function conn(){
  $conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

  if($conn && $conn->connect_error){
    echo 'Connessione fallita. Errore: ' .$conn->connect_error;
    exit();
  }

  return $conn;
}

function closeConn($conn){
  if(isset($conn))$conn->close();
}

function makeQuery($sql, $conn){
  return $conn->query($sql);
}

function baseUrl()
{
  $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

}