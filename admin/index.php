<?php
include 'include/ui/header.php';

$sql = "SELECT DATE(data) as data, COUNT(*) as quantidade FROM logs GROUP BY DATE(data) ORDER BY DATE(data) DESC LIMIT 7";
$dadosGraficoLogs = my_query($sql);

$labels = [];
$quantidades = [];
foreach (array_reverse($dadosGraficoLogs) as $log) {
  $labels[] = $log['data'];
  $quantidades[] = $log['quantidade'];
}

$sql = "SELECT modulo, COUNT(*) as quantidade FROM logs GROUP BY modulo ORDER BY quantidade DESC";
$dadosGraficoModulos = my_query($sql);

$sql = "SELECT * FROM logs ORDER BY data DESC LIMIT 10";
$ultimasLogs = my_query($sql);
?>

<style>
  .dashboard-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .dashboard-item {
    flex-basis: 46%;
    margin-bottom: 20px;
  }

  .dashboard-big-item {
    flex-basis: 100%;
  }

  .dashboard-table {
    width: 100%;
    border-collapse: collapse;
  }

  .dashboard-table th,
  .dashboard-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  .dashboard-table th {
    background-color: #f2f2f2;
  }
</style>

<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Estatísticas da landing page</li>
</ol>
<h2>Atividade recente</h2>
<div class="dashboard-container">
  <div class="dashboard-item">
    <canvas id="graficoLogs"></canvas>
  </div>
  <div class="dashboard-item">
    <canvas id="graficoModulos"></canvas>
  </div>
  <div class="dashboard-big-item">
    <h2>Últimas logs</h2>
    <table class="dashboard-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Página</th>
          <th>Módulo</th>
          <th>Ação</th>
          <th>ID do Utilizador</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($ultimasLogs as $log): ?>
          <tr>
            <td>
              <?php echo $log['id']; ?>
            </td>
            <td>
              <?php echo $log['pagina']; ?>
            </td>
            <td>
              <?php echo $log['modulo']; ?>
            </td>
            <td>
              <?php echo $log['acao']; ?>
            </td>
            <td>
              <?php echo $log['id_utilizador']; ?>
            </td>
            <td>
              <?php echo $log['data']; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  var ctx = document.getElementById('graficoLogs').getContext('2d');
  var graficoLogs = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($labels); ?>,
      datasets: [{
        label: 'Número de logs por dia',
        data: <?php echo json_encode($quantidades); ?>,
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  ctx = document.getElementById('graficoModulos').getContext('2d');
  var graficoModulos = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_column($dadosGraficoModulos, 'modulo')); ?>,
      datasets: [{
        label: 'Número de logs por módulo',
        data: <?php echo json_encode(array_column($dadosGraficoModulos, 'quantidade')); ?>,
        backgroundColor: 'rgb(75, 192, 192)',
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

</div>


<?php include 'include/ui/footer.php'; ?>