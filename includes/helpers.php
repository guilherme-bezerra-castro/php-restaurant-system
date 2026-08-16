<?php
// Função de escape para segurança
function sanitize(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function validarTexto(string $valor, int $minimo, int $maximo): bool {
    $tamanho = mb_strlen(trim($valor));
    return $tamanho >= $minimo && $tamanho <= $maximo;
}

function validarTelefone(string $valor): bool {
    return (bool) preg_match('/^[\d\s()+-]{8,20}$/', $valor);
}

function validarCep(string $valor): bool {
    return (bool) preg_match('/^\d{5}-?\d{3}$/', $valor);
}
?>