<?php
$caminhoSolicitado = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$caminhoArquivo = __DIR__ . $caminhoSolicitado;
 
if ($caminhoSolicitado !== '/' && file_exists($caminhoArquivo) && !is_dir($caminhoArquivo)) {
    return false;
}
 
if (str_ends_with($caminhoSolicitado, '.php') && !file_exists($caminhoArquivo)) {
    http_response_code(404);
    require __DIR__ . '/includes/404.php';
    exit;
}
 
return false;