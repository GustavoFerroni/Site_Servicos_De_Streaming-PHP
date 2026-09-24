<?php
require_once "config/conexao.php";

$sql = "SELECT * FROM assinaturas ORDER BY vencimento ASC";
$stmt = $pdo->query($sql);
$assinaturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlMensal = "
    SELECT SUM(valor)
    FROM assinaturas
    WHERE status = 'ativo'
";

$totalMensal = $pdo->query($sqlMensal)->fetchColumn() ?? 0;
$totalAnual = $totalMensal * 12;

$sqlAtivas = "
    SELECT COUNT(*)
    FROM assinaturas
    WHERE status = 'ativo'
";

$ativas = $pdo->query($sqlAtivas)->fetchColumn();

$sqlCanceladas = "
    SELECT COUNT(*)
    FROM assinaturas
    WHERE status = 'cancelado'
";

$canceladas = $pdo->query($sqlCanceladas)->fetchColumn();

function moeda($valor)
{
    return "R$ " . number_format($valor, 2, ",", ".");
}

function formatarData($data)
{
    return date("d/m/Y", strtotime($data));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SaaS Tracker</title>

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

        <!-- MENU -->

        <aside class="col-md-2 sidebar">

            <div class="logo">
                <i class="bi bi-credit-card-2-front"></i>
                SaaS Tracker
            </div>

            <nav>

                <a href="index.php" class="menu-item active">
                    <i class="bi bi-grid"></i>
                    Dashboard
                </a>

                <a href="cadastro.php" class="menu-item">
                    <i class="bi bi-plus-circle"></i>
                    Nova assinatura
                </a>

            </nav>

        </aside>


        <!-- CONTEÚDO -->

        <main class="col-md-10 content">

            <div class="topbar">

                <div>
                    <h1>Dashboard</h1>
                    <p>Controle suas assinaturas em um só lugar.</p>
                </div>

                <a href="cadastro.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Nova assinatura
                </a>

            </div>


            <!-- CARDS -->

            <div class="row g-4 mb-4">

                <div class="col-md-4">

                    <div class="dashboard-card">

                        <div class="card-icon blue">
                            <i class="bi bi-cash-stack"></i>
                        </div>

                        <div>
                            <span>Gasto mensal</span>
                            <h3><?= moeda($totalMensal) ?></h3>
                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="dashboard-card">

                        <div class="card-icon green">
                            <i class="bi bi-check-circle"></i>
                        </div>

                        <div>
                            <span>Assinaturas ativas</span>
                            <h3><?= $ativas ?></h3>
                        </div>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="dashboard-card">

                        <div class="card-icon red">
                            <i class="bi bi-x-circle"></i>
                        </div>

                        <div>
                            <span>Canceladas</span>
                            <h3><?= $canceladas ?></h3>
                        </div>

                    </div>

                </div>

            </div>


            <!-- GASTO ANUAL -->

            <div class="annual-card mb-4">

                <div>
                    <span>Gasto anual estimado</span>

                    <h2><?= moeda($totalAnual) ?></h2>

                    <p>
                        Baseado nas suas assinaturas atualmente ativas.
                    </p>
                </div>

                <i class="bi bi-bar-chart-line"></i>

            </div>


            <!-- ASSINATURAS -->

            <div class="table-container">

                <div class="table-header">

                    <div>

                        <h4>Suas assinaturas</h4>

                        <p>
                            Gerencie seus serviços recorrentes.
                        </p>

                    </div>

                    <input
                        type="text"
                        id="pesquisa"
                        class="form-control search"
                        placeholder="Pesquisar...">

                </div>


                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                        <tr>

                            <th>Serviço</th>
                            <th>Categoria</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                            <th>Ações</th>

                        </tr>

                        </thead>

                        <tbody id="tabelaAssinaturas">

                        <?php foreach ($assinaturas as $assinatura): ?>

                            <tr>

                                <td>

                                    <strong>
                                        <?= htmlspecialchars($assinatura['nome']) ?>
                                    </strong>

                                </td>


                                <td>

                                    <span class="category">
                                        <?= htmlspecialchars($assinatura['categoria']) ?>
                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        <?= moeda($assinatura['valor']) ?>
                                    </strong>

                                </td>


                                <td>
                                    <?= formatarData($assinatura['vencimento']) ?>
                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $assinatura['forma_pagamento']
                                    ) ?>

                                </td>


                                <td>

                                    <?php if ($assinatura['status'] === 'ativo'): ?>

                                        <span class="status ativo">
                                            ● Ativo
                                        </span>

                                    <?php else: ?>

                                        <span class="status cancelado">
                                            ● Cancelado
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <a
                                        href="editar.php?id=<?= $assinatura['id'] ?>"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    <a
                                        href="excluir.php?id=<?= $assinatura['id'] ?>"
                                        onclick="return confirmarExclusao()"
                                        class="btn btn-sm btn-outline-danger">

                                        <i class="bi bi-trash"></i>

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</div>


<script src="js/script.js"></script>

</body>

</html>