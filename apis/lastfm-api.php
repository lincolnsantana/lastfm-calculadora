<?php

function obterTopAlbuns($apiUrl, $apiKey, $user, $limit) {
    $url = "$apiUrl?method=user.getTopAlbums&user=$user&limit=$limit&api_key=$apiKey&format=json";
    $jsonPagina = json_decode(file_get_contents($url), true);
    $discosLista = [];
    $artistasLista = [];
    $playcountsLista = [];

    if (isset($jsonPagina['topalbums']['album'])) {
        foreach ($jsonPagina['topalbums']['album'] as $discoNome) {
            $album = $discoNome['name'];
            $artista = $discoNome['artist']['name'];
            $playcount = $discoNome['playcount'];

            $discosLista[] = $album;
            $artistasLista[] = $artista;
            $playcountsLista[] = $playcount;
        }
    }

    return ['albuns' => $discosLista, 'artistas' => $artistasLista, 'playcounts' => $playcountsLista];
}

function obterFaixasAlbum($apiUrl, $apiKey, $album, $artista) {
    // URL da API da Last.fm para buscar informações de um álbum
    $busca = "$apiUrl?method=album.getinfo&api_key=$apiKey&artist=" . urlencode($artista) . "&album=" . urlencode($album) . "&format=json";


    // Decodifica a resposta JSON
    $album_info = json_decode(file_get_contents($busca), true);

    // Verifica se a requisição foi bem sucedida e se há faixas retornadas
    if (isset($album_info['album']) && isset($album_info['album']['tracks']) && isset($album_info['album']['tracks']['track'])) {
        $faixas = [];
        // Itera sobre as faixas do álbum e as adiciona ao array
        foreach ($album_info['album']['tracks']['track'] as $faixa) {
            $faixas[] = $faixa['name'];
        }
        return $faixas;
    } else {
        // Caso não encontre faixas, retorna falso ou uma mensagem de erro
        return false;
    }
}

function playcountFaixa($artista, $faixa, $apiUrl, $apiKey, $user)
{
    $busca = "$apiUrl?method=track.getInfo&user=$user&artist=" . str_replace(' ', '%20',  $artista) . "&track=" . str_replace(' ', '%20',  $faixa) . "&autocorrect=0&api_key=$apiKey&format=json";
    $json_pagina = json_decode(file_get_contents($busca), true);

    $faixa_playcount = $json_pagina['track']['userplaycount'];

    return $faixa_playcount;
}


$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "58b3181bd5318362464fd0e8fe566a00";



?>



