<?php
include("lastfm-calculadora.php");
include("trackinfo.php");
include("spotify-api.php");

//API Spotify
$id_cliente = "6998bcd985764732b305777357bdf280";
$segredo_cliente = "9607cc79684d4142b737abd21ad247ea";
$token_acesso = obterTokenAcesso($id_cliente, $segredo_cliente);
$album_horas = '';

if ($token_acesso) {

    foreach ($discos_lista as $disco => $artista) {
        //echo "$disco - $artista\n";
        $id_album = buscarAlbum($disco, $artista, $token_acesso);
        if ($id_album) {
            $faixas = obterFaixasAlbum($id_album, $token_acesso);

            if (!empty($faixas)) {
                //echo "Faixas do álbum '$disco' de '$artista':\n";
                $total_horas = 0;
                foreach ($faixas as $faixa) {

                    $nome_faixa = $faixa['name'];
                    //$duracao = formatarDuracao($faixa['duration_ms']);
                    $playcount = playcountUsuario($artista, $nome_faixa, $apiUrl, $apiKey, $user);
                    //$horas_faixa = formatarMsParaHoras($faixa['duration_ms'] * $playcount);
                    //echo "Faixa: $nome_faixa - Duração:". $faixa['duration_ms'] ." Playcount: $playcount\n";

                    $total_horas = $total_horas + ($faixa['duration_ms'] * $playcount);
                }

                $album_horas = formatarMsParaHoras($total_horas);
                echo "Album: $disco - horas ouvidas: $album_horas\n";
            } else {
                echo "Nenhuma faixa encontrada para o álbum '$disco' de '$artista'.";
            }
        } else {
            echo "Álbum '$disco' de '$artista' não encontrado.";
        }
    }
} else {
    echo "Falha ao obter o token de acesso";
}
