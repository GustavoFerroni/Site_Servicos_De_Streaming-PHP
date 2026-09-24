<?php

require_once "config/conexao.php";

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    $stmt = $pdo->prepare(
        "DELETE FROM assinaturas WHERE id = ?"
    );

    $stmt->execute([$id]);
}

header("Location: index.php");

exit;
?>