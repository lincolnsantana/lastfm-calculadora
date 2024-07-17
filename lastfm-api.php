<?php

function playcountFaixa($artista, $faixa, $apiUrl, $apiKey, $user)
{
    $busca = "$apiUrl?method=track.getInfo&user=$user&artist=" . str_replace(' ', '%20',  $artista) . "&track=" . str_replace(' ', '%20',  $faixa) . "&autocorrect=0&api_key=$apiKey&format=json";
    $json_pagina = json_decode(file_get_contents($busca), true);

    $faixa_playcount = $json_pagina['track']['userplaycount'];

    return $faixa_playcount;
}


function obterTopAlbuns($apiUrl, $apiKey, $user, $limit)
{
    $url = "$apiUrl?method=user.getTopAlbums&user=$user&limit=$limit&api_key=$apiKey&format=json";
    $json_pagina = json_decode(file_get_contents($url), true);
    $discos_lista = array();

    if (isset($json_pagina['topalbums']['album'])) {
        foreach ($json_pagina['topalbums']['album'] as $disco_nome) {
            $album = $disco_nome['name'];
            $artista = $disco_nome['artist']['name'];
            $discos_lista[$album] = $artista;
        }
    }

    return $discos_lista;
}

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "58b3181bd5318362464fd0e8fe566a00";


?>
