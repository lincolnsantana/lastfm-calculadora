<?php
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    echo "Authorization code: " . htmlspecialchars($code);
    // Aqui você pode prosseguir para trocar o código de autorização por um token de acesso.
} else {
    echo "Autorização de código não recebida";
}
?>
