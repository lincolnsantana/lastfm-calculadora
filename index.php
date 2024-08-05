<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link para o arquivo CSS externo -->

    <title>Last.fm Albums Hours</title>
</head>

<body class="d-flex justify-content-center align-items-center min-vh-100">

    <div class="container" id="user-form">
        <div class="row justify-content-center">
            <div class="col-md-4 d-flex justify-content-center align-items-center text-center">
                <div class="card bg-transparent border-0">
                    <div class="card-body bg-transparent custom-width">
                        <div class="container mb-4">
                            <h1 class="card-title title pink-border">Track your</h1>
                            <h1 class="card-title title pink-border">listening</h1><br>
                            <h1 class="card-title title pink-border">hours</h1>
                        </div>
                        <div class="container mb-4">
                            <h6 class="card-subtitle mb-2 text-body-secondary subtitle">Find out how many hours you've spent
                                listening to your top albums on Last.fm!</h6>
                        </div>
                        <div class="container mb-4">
                            <div class="row">
                                <div class="col-10 mx-auto custom-width">
                                    <form action="calculadorahoras.php" method="POST">
                                    <div class="input-group mb-2 h-50">
                                        <input type="text" id="username" name="username" class="form-control text-center input-text" placeholder="Your Last.fm username" aria-label="Username" aria-describedby="basic-addon1" required>
                                    </div>
                                    <div class="d-grid h-50">
                                        <button type="submit" class="btn btn-dark input-text">Calculate</button>
                                    </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="loading-div">
        <div class="row justify-content-center">
            <div class="col-md-4 d-flex justify-content-center align-items-center text-center">
                <div class="card bg-transparent border-0">
                    <div class="card-body bg-transparent">
                        <div class="container mb-4">
                            <h5 class="card-title loading">Hang tight, calculating</h5>
                             <h5 class="card-title loading">your hours...</h5>
                        </div>
                        <div class="container mb-4">
                            <div class="spinner-border text-dark text-end" role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scripts JavaScript -->
    <script src="js/loading.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>