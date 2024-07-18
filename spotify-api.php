<?php

function obterTokenAcesso($id_cliente, $segredo_cliente)
{
    $url = "https://accounts.spotify.com/api/token";
    $cabecalhos = [
        "Authorization: Basic " . base64_encode("$id_cliente:$segredo_cliente"),
        "Content-Type: application/x-www-form-urlencoded"
    ];
    $dados = http_build_query(["grant_type" => "client_credentials"]);

    $opcoes = [
        'http' => [
            'header' => $cabecalhos,
            'method' => 'POST',
            'content' => $dados,
        ],
    ];

    $contexto = stream_context_create($opcoes);
    $resposta = file_get_contents($url, false, $contexto);
    $resultado = json_decode($resposta, true);

    return $resultado['access_token'] ?? null;
}


function buscarAlbum($nome_album, $nome_artista, $token_acesso)
{
    $url = "https://api.spotify.com/v1/search?q=album:" . urlencode($nome_album) . "%20artist:" . urlencode($nome_artista) . "&type=album&limit=1";
    $cabecalhos = [
        "Authorization: Bearer $token_acesso",
    ];
    $opcoes = [
        'http' => [
            'header' => $cabecalhos,
            'method' => 'GET',
        ],
    ];

    $contexto = stream_context_create($opcoes);
    $resposta = file_get_contents($url, false, $contexto);
    $dados = json_decode($resposta, true);

    return $dados['albums']['items'][0]['id'] ?? null;
}

function obterFaixasAlbum($id_album, $token_acesso)
{
    $url = "https://api.spotify.com/v1/albums/$id_album/tracks";
    $cabecalhos = [
        "Authorization: Bearer $token_acesso",
    ];
    $opcoes = [
        'http' => [
            'header' => $cabecalhos,
            'method' => 'GET',
        ],
    ];

    $contexto = stream_context_create($opcoes);
    $resposta = file_get_contents($url, false, $contexto);
    $dados = json_decode($resposta, true);

    return $dados['items'] ?? [];
}

function buscarDataLancamento($nome_album, $nome_artista, $token_acesso)
{
    $url = "https://api.spotify.com/v1/search?q=album:" . urlencode($nome_album) . "%20artist:" . urlencode($nome_artista) . "&type=album&limit=1";
    $cabecalhos = [
        "Authorization: Bearer $token_acesso",
    ];
    $opcoes = [
        'http' => [
            'header' => $cabecalhos,
            'method' => 'GET',
        ],
    ];

    $contexto = stream_context_create($opcoes);
    $resposta = file_get_contents($url, false, $contexto);
    $dados = json_decode($resposta, true);

    return $dados['albums']['items'][0]['release_date'] ?? null;
}


function formatarDuracao($duracao_ms)
{
    $duracao_min = floor($duracao_ms / 60000);
    $duracao_seg = round(($duracao_ms % 60000) / 1000);
    return "$duracao_min min $duracao_seg seg";
}

function formatarMsParaHoras($milisegundos) {
    $segundos = floor($milisegundos / 1000);
    $minutos = floor($segundos / 60);
    $horas = floor($minutos / 60);

    $segundos = $segundos % 60;
    $minutos = $minutos % 60;

    return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
}


$id_cliente = "";
$segredo_cliente = "";
$token_acesso = obterTokenAcesso($id_cliente, $segredo_cliente);

?>