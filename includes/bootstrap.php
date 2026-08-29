<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/../logs/php-errors.log');

function exibirPaginaDeErro(int $codigoHttp): void {
    if (!headers_sent()) {
        http_response_code($codigoHttp);
    }
    require __DIR__ . '/erro.php';
    exit;
}

set_exception_handler(function (Throwable $excecao): void {
    error_log($excecao->getMessage() . ' em ' . $excecao->getFile() . ':' . $excecao->getLine());
    exibirPaginaDeErro(500);
});

set_error_handler(function (int $codigo, string $mensagem, string $arquivo, int $linha): bool {
    if (!(error_reporting() & $codigo)) {
        return false;
    }
    error_log($mensagem . ' em ' . $arquivo . ':' . $linha);
    if (in_array($codigo, [E_ERROR, E_USER_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        exibirPaginaDeErro(500);
    }
    return true;
});

register_shutdown_function(function (): void {
    $erro = error_get_last();
    if ($erro && in_array($erro['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
        error_log($erro['message'] . ' em ' . $erro['file'] . ':' . $erro['line']);
        exibirPaginaDeErro(500);
    }
});