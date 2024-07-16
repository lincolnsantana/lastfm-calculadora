<?php

function playcountUsuario($artista, $faixa, $apiUrl, $apiKey, $user)
{
    $busca = "$apiUrl?method=track.getInfo&user=$user&artist=" . str_replace(' ', '%20',  $artista) ."&track=" . str_replace(' ', '%20',  $faixa) ."&autocorrect=0&api_key=$apiKey&format=json";
    $json_pagina = json_decode(file_get_contents($busca), true);

    $usuario_playcount = $json_pagina['track']['userplaycount'];

    return $usuario_playcount;
}

?>