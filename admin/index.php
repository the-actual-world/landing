<?php
include 'include/ui/header.php';

function getLast7Days() {
    $days = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $days[$date] = 0;
    }
    return $days;
}

// Fetch data for logs over the last 7 days
$sql = "SELECT DATE(data) as data, COUNT(*) as quantidade FROM logs WHERE data >= CURDATE() - INTERVAL 7 DAY GROUP BY DATE(data)";
$dadosGraficoLogs = my_query($sql);

// Prepare data for logs chart
$logsData = getLast7Days();
if (is_array($dadosGraficoLogs)) {
    foreach ($dadosGraficoLogs as $log) {
        $logsData[$log['data']] = $log['quantidade'];
    }
}
$labels = array_keys($logsData);
$quantidades = array_values($logsData);

// Fetch data for logs by module
$sql = "SELECT modulo, COUNT(*) as quantidade FROM logs GROUP BY modulo ORDER BY quantidade DESC";
$dadosGraficoModulos = my_query($sql);

// Fetch latest logs
$sql = "SELECT * FROM logs ORDER BY data DESC LIMIT 10";
$ultimasLogs = my_query($sql);
?>

<style>
  .dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 20px;
  }

  .dashboard-item {
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
  }

  .dashboard-title {
    text-align: center;
    margin-bottom: 10px;
  }

  .dashboard-big-item {
    grid-column: span 2;
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

  @media (max-width: 768px) {
    .dashboard-big-item {
      grid-column: span 1;
    }
  }
</style>

<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Estatísticas da Landing Page</li>
</ol>
<h2>Atividade Recente</h2>
<div class="dashboard-container">
  <div class="dashboard-item">
    <h2 class="dashboard-title">Número de Logs por Dia</h2>
    <canvas id="graficoLogs"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Número de Logs por Módulo</h2>
    <canvas id="graficoModulos"></canvas>
  </div>
  <div class="dashboard-big-item">
    <h2 class="dashboard-title">Últimas Logs</h2>
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
            <td><?php echo $log['id']; ?></td>
            <td><?php echo $log['pagina']; ?></td>
            <td><?php echo $log['modulo']; ?></td>
            <td><?php echo $log['acao']; ?></td>
            <td><?php echo $log['id_utilizador']; ?></td>
            <td><?php echo $log['data']; ?></td>
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
        label: 'Número de Logs por Dia',
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
        label: 'Número de Logs por Módulo',
        data: <?php echo json_encode(array_column($dadosGraficoModulos, 'quantidade')); ?>,
        backgroundColor: 'rgb(75, 192, 192)'
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
