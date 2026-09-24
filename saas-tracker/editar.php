<?php

require_once "config/conexao.php";

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET["id"]);

$stmt = $pdo->prepare(
    "SELECT * FROM assinaturas WHERE id = ?"
);

$stmt->execute([$id]);

$assinatura = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$assinatura) {
    header("Location: index.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $categoria = $_POST["categoria"];
    $valor = str_replace(",", ".", $_POST["valor"]);
    $vencimento = $_POST["vencimento"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $status = $_POST["status"];


    $sql = "
        UPDATE assinaturas

        SET
            nome = ?,
            categoria = ?,
            valor = ?,
            vencimento = ?,
            forma_pagamento = ?,
            status = ?

        WHERE id = ?
    ";


    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $nome,
        $categoria,
        $valor,
        $vencimento,
        $forma_pagamento,
        $status,
        $id
    ]);


    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Editar assinatura</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container-fluid">

<div class="row">

<aside class="col-md-2 sidebar">

<div class="logo">

<i class="bi bi-credit-card-2-front"></i>

SaaS Tracker

</div>


<nav>

<a href="index.php" class="menu-item">

<i class="bi bi-grid"></i>

Dashboard

</a>


<a href="cadastro.php" class="menu-item">

<i class="bi bi-plus-circle"></i>

Nova assinatura

</a>

</nav>

</aside>


<main class="col-md-10 content">

<div class="topbar">

<div>

<h1>Editar assinatura</h1>

<p>
Atualize os dados do serviço.
</p>

</div>

</div>


<div class="form-container">

<form method="POST">

<div class="row g-4">


<div class="col-md-6">

<label class="form-label">
Nome do serviço
</label>

<input
type="text"
name="nome"
class="form-control"
value="<?= htmlspecialchars($assinatura['nome']) ?>"
required>

</div>


<div class="col-md-6">

<label class="form-label">
Categoria
</label>

<select
name="categoria"
class="form-select"
required>

<?php

$categorias = [
    "Streaming",
    "Música",
    "Internet",
    "Hospedagem",
    "Software",
    "Games",
    "Educação",
    "Outros"
];

foreach ($categorias as $categoria):

?>

<option
value="<?= $categoria ?>"
<?= $assinatura['categoria'] === $categoria ? 'selected' : '' ?>>

<?= $categoria ?>

</option>

<?php endforeach; ?>

</select>

</div>


<div class="col-md-6">

<label class="form-label">
Valor mensal
</label>

<div class="input-group">

<span class="input-group-text">
R$
</span>

<input
type="number"
step="0.01"
name="valor"
class="form-control"
value="<?= $assinatura['valor'] ?>"
required>

</div>

</div>


<div class="col-md-6">

<label class="form-label">
Data de vencimento
</label>

<input
type="date"
name="vencimento"
class="form-control"
value="<?= $assinatura['vencimento'] ?>"
required>

</div>


<div class="col-md-6">

<label class="form-label">
Forma de pagamento
</label>

<select
name="forma_pagamento"
class="form-select"
required>

<?php

$pagamentos = [
    "Cartão de crédito",
    "Cartão de débito",
    "Pix",
    "Boleto",
    "Débito automático",
    "Outro"
];

foreach ($pagamentos as $pagamento):

?>

<option
value="<?= $pagamento ?>"
<?= $assinatura['forma_pagamento'] === $pagamento ? 'selected' : '' ?>>

<?= $pagamento ?>

</option>

<?php endforeach; ?>

</select>

</div>


<div class="col-md-6">

<label class="form-label">
Status
</label>

<select
name="status"
class="form-select">

<option
value="ativo"
<?= $assinatura['status'] === 'ativo' ? 'selected' : '' ?>>

Ativo

</option>

<option
value="cancelado"
<?= $assinatura['status'] === 'cancelado' ? 'selected' : '' ?>>

Cancelado

</option>

</select>

</div>


<div class="col-12">

<hr>

<button
type="submit"
class="btn btn-primary">

<i class="bi bi-check-lg"></i>

Salvar alterações

</button>


<a
href="index.php"
class="btn btn-secondary">

Cancelar

</a>

</div>

</div>

</form>

</div>

</main>

</div>

</div>

</body>

</html>