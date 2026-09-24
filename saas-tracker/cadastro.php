<?php

require_once "config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $categoria = $_POST["categoria"];
    $valor = str_replace(",", ".", $_POST["valor"]);
    $vencimento = $_POST["vencimento"];
    $forma_pagamento = $_POST["forma_pagamento"];
    $status = $_POST["status"];

    if (
        empty($nome) ||
        empty($categoria) ||
        empty($valor) ||
        empty($vencimento) ||
        empty($forma_pagamento)
    ) {

        $mensagem = "Preencha todos os campos.";

    } else {

        $sql = "
            INSERT INTO assinaturas
            (nome, categoria, valor, vencimento, forma_pagamento, status)
            VALUES (?, ?, ?, ?, ?, ?)
        ";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $categoria,
            $valor,
            $vencimento,
            $forma_pagamento,
            $status
        ]);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nova assinatura - SaaS Tracker</title>

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

                <a href="cadastro.php" class="menu-item active">
                    <i class="bi bi-plus-circle"></i>
                    Nova assinatura
                </a>

            </nav>

        </aside>


        <main class="col-md-10 content">

            <div class="topbar">

                <div>

                    <h1>Nova assinatura</h1>

                    <p>
                        Cadastre um novo serviço recorrente.
                    </p>

                </div>

            </div>


            <div class="form-container">

                <?php if ($mensagem): ?>

                    <div class="alert alert-danger">
                        <?= $mensagem ?>
                    </div>

                <?php endif; ?>


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
                                placeholder="Ex: Netflix"
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

                                <option value="">
                                    Selecione
                                </option>

                                <option>Streaming</option>
                                <option>Música</option>
                                <option>Internet</option>
                                <option>Hospedagem</option>
                                <option>Software</option>
                                <option>Games</option>
                                <option>Educação</option>
                                <option>Outros</option>

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
                                    placeholder="0,00"
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

                                <option value="">
                                    Selecione
                                </option>

                                <option>Cartão de crédito</option>
                                <option>Cartão de débito</option>
                                <option>Pix</option>
                                <option>Boleto</option>
                                <option>Débito automático</option>
                                <option>Outro</option>

                            </select>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="ativo">
                                    Ativo
                                </option>

                                <option value="cancelado">
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

                                Cadastrar assinatura

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