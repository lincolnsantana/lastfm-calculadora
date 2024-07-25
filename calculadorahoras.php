<?php
include("lastfm-api.php");
include("spotify-api.php");


// Exemplo de uso:
$limit = 4;
$user = $_POST['username'];


$resultados = obterTopAlbuns($apiUrl, $apiKey, $user, $limit);
$albuns = $resultados['albuns'];
$artistas = $resultados['artistas'];
$playcounts = $resultados['playcounts'];
$dados_musicais = array();


foreach ($albuns as $index => $album) {

    //echo "Artista: {$artistas[$index]} | {$album} | Playcount: {$playcounts[$index]}\n";
    $busca_album = buscarAlbum($album, $artistas[$index], $token_acesso);

    $ano_lancamento = buscarDataLancamento($album, $artistas[$index], $token_acesso);

    if ($busca_album['id']) {

        $faixas = obterFaixasAlbum($busca_album['id'], $token_acesso);

        if (!empty($faixas)) {
            //echo "Faixas do álbum '$album' de '{$artistas[$index]}':\n";
            $total_horas = 0;
            foreach ($faixas as $faixa) {

                $nome_faixa = $faixa['name'];
                $duracao = formatarDuracao($faixa['duration_ms']);
                $playcount = playcountFaixa($artistas[$index], $nome_faixa, $apiUrl, $apiKey, $user);
                $horas_faixa = formatarMsParaHoras($faixa['duration_ms'] * $playcount);

                //echo "Faixa: $nome_faixa - Duração: $duracao Playcount: $playcount horas faixa: $horas_faixa\n";

                $total_horas = $total_horas + ($faixa['duration_ms'] * $playcount);
            }
            $album_horas = '';

            adicionarAlbum($dados_musicais, $album, $busca_album['imagem_url'], $ano_lancamento, $artistas[$index], $playcounts[$index], $total_horas);
        } else {
            echo "Nenhuma faixa encontrada para o álbum '$album' de {$artistas[$index]}.";
        }
    } else {
        echo "Álbum $album de {$artistas[$index]} não encontrado.";
    }
}

usort($dados_musicais, "compararTotalHoras");

    foreach ($dados_musicais as $dados) {
        //$album_horas = formatarMsParaHoras($total_horas);
        //echo "$album ($ano_lancamento) - plays(scrobbles): {$playcounts[$index]} horas ouvidas: $album_horas<br>";

        //formatar a chave ano para mostrar somente o ano como data de lançamento.
        $partes = explode('-',  $dados['ano']);
        $ano = $partes[0];

        echo '
            <div class="col">
                <div class="card h-100">
                        <img src=" ' . $dados['imagem'] . ' " class="card-img-top" alt="' . $dados['artista'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $dados['album'] . '</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">' . $dados['artista'] . '</h6>
                                <h6 class="card-subtitle mb-2 text-body-secondary">' . $ano . '</h6>
                                <p class="card-text">' . number_format($dados['playcount'], 0, ',', '.'). ' scrobbles</p>
                                <h4 class="card-title">' . formatarMsParaHoras($dados['total_horas']) . '</h4>
                            </div>
                </div>
            </div>';
    }
