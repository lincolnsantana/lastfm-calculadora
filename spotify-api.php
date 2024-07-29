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

    if (isset($dados['albums']['items'][0])) {
        $album = $dados['albums']['items'][0];
        $id = $album['id'];
        $imagem_url = null;

        // Buscar a imagem de resolução 300x300
        if (isset($album['images'])) {
            foreach ($album['images'] as $imagem) {
                if ($imagem['width'] == 300 && $imagem['height'] == 300) {
                    $imagem_url = $imagem['url'];
                    break;
                }
            }
        }

        return [
            'id' => $id,
            'imagem_url' => $imagem_url
        ];
    }

    return null;
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

// Função para adicionar um novo álbum ao array
function adicionarAlbum(&$dados_musicais, $album, $imagem, $ano, $artista, $playcount, $total_horas) {
    $dados_musicais[] = array(
        "album" => $album,
        "imagem" => $imagem,
        "ano" => $ano,
        "artista" => $artista,
        "playcount" => $playcount,
        "total_horas" => $total_horas
    );
}

// Função de comparação para ordenar pelo total de horas em ordem decrescente
function compararTotalHoras($a, $b) {
    if ($a["total_horas"] == $b["total_horas"]) {
        return 0;
    }
    return ($a["total_horas"] > $b["total_horas"]) ? -1 : 1;
}

function formatarDuracao($duracao_ms)
{
    $duracao_min = floor($duracao_ms / 60000);
    $duracao_seg = round(($duracao_ms % 60000) / 1000);
    return "$duracao_min min $duracao_seg seg";
}

function formatarMsParaHoras($milisegundos) {
    // Convertendo milissegundos para segundos
    $segundos = $milisegundos / 1000;
    
    // Convertendo segundos para horas e minutos
    $horas = intval($segundos / 3600);
    $minutos = intval(($segundos % 3600) / 60);
    
    // Formatação para exibir no formato "h min"
    return sprintf("%dh %02dmin", $horas, $minutos);
}

$id_cliente = "6998bcd985764732b305777357bdf280";
$segredo_cliente = "9607cc79684d4142b737abd21ad247ea";
$token_acesso = obterTokenAcesso($id_cliente, $segredo_cliente);



?>