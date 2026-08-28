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

function renderImagem(string $caminho, string $alt, string $classe = '', string $loading = 'lazy'): string {
    $webp = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $caminho);
    $classeAttr = $classe !== '' ? ' class="' . sanitize($classe) . '"' : '';
    return '<picture>'
        . '<source srcset="' . sanitize($webp) . '" type="image/webp">'
        . '<img src="' . sanitize($caminho) . '" alt="' . sanitize($alt) . '"' . $classeAttr . ' loading="' . sanitize($loading) . '">'
        . '</picture>';
}
?>