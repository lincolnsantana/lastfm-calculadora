<?php
include('apis/lastfm-api.php');
include('apis/spotify-api.php');


// Exemplo de uso:
$limit = 10;
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link para o arquivo CSS externo -->

    <title>Last.fm Albums Hours</title>
</head>

<body class="d-flex align-items-center min-vh-100">
    <div class="container-fluid text-left">
        <div class="row mx-auto">
            <div class="col-sm-3 d-flex justify-content-center align-items-stretch">
                <div class="container mt-5">
                    <h1 class="result-title">This is the time you spend listening to your <span class="pink-border">favorite albums.</span></h1>
                </div>
            </div>
            <div id="result" class="col-sm-9 d-flex flex-nowrap overflow-auto h-100">
                <div id="col-result" class="d-flex no-select">


                    <?php
                    $rank = 1;
                    foreach ($dados_musicais as $dados) {
                        //$album_horas = formatarMsParaHoras($total_horas);
                        //echo "$album ($ano_lancamento) - plays(scrobbles): {$playcounts[$index]} horas ouvidas: $album_horas<br>";

                        //formatar a chave ano para mostrar somente o ano como data de lançamento.
                        $partes = explode('-',  $dados['ano']);
                        $ano = $partes[0];

                        echo '<div class="container card-album">
                        <h1 class="card-rank">'. $rank .'</h1>
                        <img src="' . $dados['imagem'] . '"
                            class="img-fluid mb-4" alt="' . $dados['artista'] . '">
                        <div class="space-right border-0">
                            <h4 class="album-name">' . $dados['album'] . '</h4>
                            <h5 class="artist-name">' . $dados['artista'] . '</h5>
                            <h6 class="playcount">' . number_format($dados['playcount'], 0, ',', '.') . ' scrobbles</h6>
                            <h4 class="hours">' . formatarMsParaHoras($dados['total_horas']) . '</h4>
                        </div>
                    </div>';

                    $rank++;
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts JavaScript -->
    <script src="js/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>