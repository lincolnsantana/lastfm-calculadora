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
    $url = "https://api.spotify.com/v1/search?q=album:" . urlencode($nome_album) . "%20artist:" . urlencode($nome_artista) . "&type=album&market=BR&limit=1";

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
    } else {
        $url = "https://api.spotify.com/v1/search?q=" . urlencode($nome_album) . "&type=album&market=BR&limit=1";

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
    }

    return $resposta;
}


function obterFaixasAlbumSpotify($id_album, $token_acesso)
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

/*
function buscarTempoDaFaixa($nomeFaixa, $nomeArtista, $token_acesso) {
    // Configurações
    $base_url = 'https://api.spotify.com/v1/search';
    
    // Parâmetros da busca
    $params = [
        'q' => 'track:' . $nomeFaixa . ' artist:' . $nomeArtista,
        'type' => 'track',
        'market' => 'BR',
        'limit' => 1
    ];

    // Monta a URL para requisição
    $url = $base_url . '?' . http_build_query($params);

    // Configuração do cabeçalho da requisição
    $options = [
        'http' => [
            'header' => "Authorization: Bearer $token_acesso\r\n",
            'method' => 'GET'
        ]
    ];
    
    // Cria o contexto da requisição
    $context = stream_context_create($options);

    // Executa a requisição e obtém a resposta
    $response = @file_get_contents($url, false, $context);

    // Verifica se a resposta é válida
    if ($response === FALSE) {
        return 'Erro na requisição';
    }

    // Decodifica a resposta JSON
    $data = json_decode($response, true);

    // Verifica se a faixa foi encontrada
    if (isset($data['tracks']['items'][0]['duration_ms'])) {
        // Converte o tempo para minutos e segundos
        $tempo_ms = $data['tracks']['items'][0]['duration_ms'];
        

        return $tempo_ms;
    } else {
        return 'Tempo não encontrado';
    }
}
*/

function buscarTempoDaFaixa($nomeFaixa, $nomeArtista, $token_acesso) {
    // Configurações
    $base_url = 'https://api.spotify.com/v1/search';
    
    // Parâmetros da busca
    $params = [
        'q' => 'track:' . $nomeFaixa . ' artist:' . $nomeArtista,
        'type' => 'track',
        'limit' => 1
    ];
    

    // Monta a URL para requisição
    $url = $base_url . '?' . http_build_query($params);

    // Configuração da requisição
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token_acesso
    ]);

    // Executa a requisição
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodifica a resposta JSON
    $data = json_decode($response, true);

    // Verifica se a faixa foi encontrada
    if (isset($data['tracks']['items'][0]['duration_ms'])) {
        // Converte o tempo para minutos e segundos
        $tempo_ms = $data['tracks']['items'][0]['duration_ms'];
        
        
        return $tempo_ms;
    } else {
        return 0;
    }
}


// Função para adicionar um novo álbum ao array
function adicionarAlbum(&$dados_musicais, $album, $imagem, $artista, $playcount, $total_horas)
{
    $dados_musicais[] = array(
        "album" => $album,
        "imagem" => $imagem,
        "artista" => $artista,
        "playcount" => $playcount,
        "total_horas" => $total_horas
    );
}

// Função de comparação para ordenar pelo total de horas em ordem decrescente
function compararTotalHoras($a, $b)
{
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

function formatarMsParaHoras($milisegundos)
{
    // Convertendo milissegundos para segundos
    $segundos = $milisegundos / 1000;

    // Convertendo segundos para horas e minutos
    $horas = intval($segundos / 3600);
    $minutos = intval(($segundos % 3600) / 60);

    // Formatação para exibir no formato "h min"
    return sprintf("%dh%02dmin", $horas, $minutos);
}

$id_cliente = "6998bcd985764732b305777357bdf280";
$segredo_cliente = "9607cc79684d4142b737abd21ad247ea";
$token_acesso = obterTokenAcesso($id_cliente, $segredo_cliente);

?>
