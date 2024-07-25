<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Link para o arquivo CSS externo -->

    <title>Last.fm Calculadora de Horas</title>
</head>

<body class="d-flex flex-column">
    <div class="container-separado">
        <div class="container form-container d-flex flex-column">
            <h1 class="text-center">Last.fm Calculadora de Horas Escutadas por Álbum</h1>
            <form id="calcForm" action="calculadorahoras.php" method="POST">
                <div class="form-group">
                    <label for="username">Seu nome de usuário da Last.fm</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="basic-addon3" required>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" id="calculateBtn" class="btn btn-dark" disabled>
                        Calcular
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="container result-container">
        <div id="resultado" class="row">
            <!-- O resultado da página calculadorahoras.php será carregado aqui -->
        </div>
        <div id="loadingIcon" class="spinner-border text-dark" role="status" style="display:none;">
            <span class="sr-only visually-hidden">Loading...</span>
        </div>
    </div>
    

    <!-- Scripts JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="ajax.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>