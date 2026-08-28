<?php
ini_set('memory_limit', '512M');

$diretorio = __DIR__ . '/assets/img';
$larguraMaxima = 1600;
$qualidadeJpg = 78;
$qualidadeWebp = 78;

$arquivos = glob($diretorio . '/*.{jpg,jpeg}', GLOB_BRACE);

if (empty($arquivos)) {
    echo "Nenhuma imagem JPG encontrada em $diretorio" . PHP_EOL;
    exit;
}

foreach ($arquivos as $caminho) {
    $tamanhoOriginal = filesize($caminho);
    $imagem = imagecreatefromjpeg($caminho);

    if (!$imagem) {
        echo "Não foi possível abrir: $caminho" . PHP_EOL;
        continue;
    }

    $larguraOriginal = imagesx($imagem);
    $alturaOriginal = imagesy($imagem);

    if ($larguraOriginal > $larguraMaxima) {
        $novaAltura = (int) round($alturaOriginal * ($larguraMaxima / $larguraOriginal));
        $imagemRedimensionada = imagecreatetruecolor($larguraMaxima, $novaAltura);
        imagecopyresampled(
            $imagemRedimensionada, $imagem,
            0, 0, 0, 0,
            $larguraMaxima, $novaAltura,
            $larguraOriginal, $alturaOriginal
        );
        imagedestroy($imagem);
        $imagem = $imagemRedimensionada;
    }

    imagejpeg($imagem, $caminho, $qualidadeJpg);

    $caminhoWebp = preg_replace('/\.(jpg|jpeg)$/i', '.webp', $caminho);
    imagewebp($imagem, $caminhoWebp, $qualidadeWebp);

    imagedestroy($imagem);

    $tamanhoNovo = filesize($caminho);
    $economia = round((1 - $tamanhoNovo / $tamanhoOriginal) * 100);
    echo basename($caminho) . ': ' . round($tamanhoOriginal / 1024) . 'KB -> ' . round($tamanhoNovo / 1024) . "KB ($economia% menor) + .webp gerado" . PHP_EOL;
}

echo 'Concluído!' . PHP_EOL;