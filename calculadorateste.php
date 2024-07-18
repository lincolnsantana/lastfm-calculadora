<?php
include("lastfm-api.php");
include("spotify-api.php");


// Exemplo de uso:
$limit = 1;
$user = "LincolnLopess";
$album_horas = '';


$resultados = obterTopAlbuns($apiUrl, $apiKey, $user, $limit);
//var_dump($resultados);

$albuns = $resultados['albuns'];
$artistas = $resultados['artistas'];
$playcounts = $resultados['playcounts'];



foreach ($albuns as $index => $album) {
    
    //echo "Artista: {$artistas[$index]} | {$album} | Playcount: {$playcounts[$index]}\n";
    $id_album = buscarAlbum($album, $artistas[$index], $token_acesso);
    $ano_lancamento = buscarDataLancamento($album, $artistas[$index], $token_acesso);

    if($id_album) {
        
        $faixas = obterFaixasAlbum($id_album, $token_acesso);

        if (!empty($faixas)) {
            echo "Faixas do álbum '$album' de '{$artistas[$index]}':\n";
            $total_horas = 0;
            foreach ($faixas as $faixa) {

                $nome_faixa = $faixa['name'];
                $duracao = formatarDuracao($faixa['duration_ms']);
                $playcount = playcountFaixa($artistas[$index], $nome_faixa, $apiUrl, $apiKey, $user);
                $horas_faixa = formatarMsParaHoras($faixa['duration_ms'] * $playcount);

                echo "Faixa: $nome_faixa - Duração: $duracao Playcount: $playcount horas faixa: $horas_faixa\n";

                $total_horas = $total_horas + ($faixa['duration_ms'] * $playcount);
            }

            $album_horas = formatarMsParaHoras($total_horas);
            echo "$album ($ano_lancamento) - plays(scrobbles): {$playcounts[$index]} horas ouvidas: $album_horas\n";
        } else {
            echo "Nenhuma faixa encontrada para o álbum '$album' de {$artistas[$index]}.";
        }

    }else {
        echo "Álbum $album de {$artistas[$index]} não encontrado.";
    }
    

}



?>

