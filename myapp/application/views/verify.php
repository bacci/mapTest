<?php

$users = array('admin' => 'admin', 'guest' => 'guest');
 
if (!isset($_SERVER['PHP_AUTH_USER']) ||
!isset($users[$_SERVER['PHP_AUTH_USER']]) || 
$users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
    header('WWW-Authenticate: Basic realm="Basilik"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Voc� deve digitar um login e senha v�lidos para acessar este recurso\n";
    exit;
}