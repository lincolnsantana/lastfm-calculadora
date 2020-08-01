<?php

$apiUrl = "http://ws.audioscrobbler.com/2.0/";
$apiKey = "95439be5ca91fc0b25d9299abee8f65d";
$method = "user.getTopAlbums";
$method_album = "album.getInfo";

$user = "LincolnLopess";
//com a variavel limite iremos pegar os discos que vamos fazer o calculo
$limit = 2;


$consulta = "$apiUrl?method=$method&user=$user&limit=$limit&api_key=$apiKey";
//$resposta = file_get_contents($consulta);
//echo htmlentities($resposta);

            /*  pretendo usar depois */
$topAlbums = new DOMDocument();
$topAlbums->load($consulta);

//$artista_album = array();
$topAlbumsLista = $topAlbums->getElementsByTagName("album");

$album_artista = array();

    foreach ($topAlbumsLista as $album) {

        $nomes_albums = $album->getElementsByTagName("name");
        $nome_album = str_replace(" ", "+",$nomes_albums->item(0)->nodeValue);

        $nomes_artistas = $album->getElementsByTagName("name");
        $nome_artista = str_replace(" ", "+", $nomes_artistas->item(1)->nodeValue);

        $album_artista[$nome_album] = $nome_artista;
        //echo "$nome_album - $nome_artista \n";
    }

    var_dump($album_artista);

?>