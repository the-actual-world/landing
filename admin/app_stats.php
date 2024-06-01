<?php
include 'include/ui/header.php';
include $arrConfig['dir_site'] . '/include/db_sb.inc.php';

// Function to generate the last 7 days with zero counts
function getLast7Days() {
    $days = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $days[$date] = 0;
    }
    return $days;
}

// Function to generate the last 7 months with zero counts
function getLast7Months() {
    $months = [];
    for ($i = 6; $i >= 0; $i--) {
        $month = date('Y-m', strtotime("-$i months"));
        $months[$month] = 0;
    }
    return $months;
}

// Fetch data for new users today
$sql = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = CURRENT_DATE";
$newUsersTodayData = my_sb_query($sql);
$newUsersTodayCount = $newUsersTodayData[0]['count'] ?? 0; // Handle potential null

// Fetch data for chat messages over the last 7 days
$sql = "SELECT DATE(created_at) as date, COUNT(*) as count FROM chat_messages WHERE created_at >= CURRENT_DATE - INTERVAL '7 days' GROUP BY DATE(created_at)";
$chatMessagesData = my_sb_query($sql);

// Prepare data for chat messages chart
$chatMessages = getLast7Days();
if (is_array($chatMessagesData)) {
    foreach ($chatMessagesData as $data) {
        $chatMessages[$data['date']] = $data['count'];
    }
}
$chatMessagesLabels = array_keys($chatMessages);
$chatMessagesCounts = array_values($chatMessages);

// Fetch data for posts over the last 7 days
$sql = "SELECT DATE(created_at) as date, COUNT(*) as count FROM posts WHERE created_at >= CURRENT_DATE - INTERVAL '7 days' GROUP BY DATE(created_at)";
$postsData = my_sb_query($sql);

// Prepare data for posts chart
$posts = getLast7Days();
if (is_array($postsData)) {
    foreach ($postsData as $data) {
        $posts[$data['date']] = $data['count'];
    }
}
$postsLabels = array_keys($posts);
$postsCounts = array_values($posts);

// Fetch data for new users over the last 7 days
$sql = "SELECT DATE(created_at) as date, COUNT(*) as count FROM users WHERE created_at >= CURRENT_DATE - INTERVAL '7 days' GROUP BY DATE(created_at)";
$usersData = my_sb_query($sql);

// Prepare data for users chart
$users = getLast7Days();
if (is_array($usersData)) {
    foreach ($usersData as $data) {
        $users[$data['date']] = $data['count'];
    }
}
$usersLabels = array_keys($users);
$usersCounts = array_values($users);

// Fetch data for chat messages over the last 7 months
$sql = "SELECT TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count FROM chat_messages WHERE created_at >= (CURRENT_DATE - INTERVAL '7 months') GROUP BY TO_CHAR(created_at, 'YYYY-MM')";
$chatMessagesDataMonthly = my_sb_query($sql);

// Prepare data for chat messages monthly chart
$chatMessagesMonthly = getLast7Months();
if (is_array($chatMessagesDataMonthly)) {
    foreach ($chatMessagesDataMonthly as $data) {
        $chatMessagesMonthly[$data['month']] = $data['count'];
    }
}
$chatMessagesLabelsMonthly = array_keys($chatMessagesMonthly);
$chatMessagesCountsMonthly = array_values($chatMessagesMonthly);

// Fetch data for posts over the last 7 months
$sql = "SELECT TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count FROM posts WHERE created_at >= (CURRENT_DATE - INTERVAL '7 months') GROUP BY TO_CHAR(created_at, 'YYYY-MM')";
$postsDataMonthly = my_sb_query($sql);

// Prepare data for posts monthly chart
$postsMonthly = getLast7Months();
if (is_array($postsDataMonthly)) {
    foreach ($postsDataMonthly as $data) {
        $postsMonthly[$data['month']] = $data['count'];
    }
}
$postsLabelsMonthly = array_keys($postsMonthly);
$postsCountsMonthly = array_values($postsMonthly);

// Fetch data for new users over the last 7 months
$sql = "SELECT TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count FROM users WHERE created_at >= (CURRENT_DATE - INTERVAL '7 months') GROUP BY TO_CHAR(created_at, 'YYYY-MM')";
$usersDataMonthly = my_sb_query($sql);

// Prepare data for users monthly chart
$usersMonthly = getLast7Months();
if (is_array($usersDataMonthly)) {
    foreach ($usersDataMonthly as $data) {
        $usersMonthly[$data['month']] = $data['count'];
    }
}
$usersLabelsMonthly = array_keys($usersMonthly);
$usersCountsMonthly = array_values($usersMonthly);

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

  .statistics-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
  }

  .statistic-item {
    flex: 1;
    min-width: 150px;
    text-align: center;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
  }

  @media (max-width: 768px) {
    .statistics-container {
      flex-direction: column;
      align-items: center;
    }

    .statistic-item {
      width: 100%;
    }
  }
</style>

<h1 class="mt-4">Estatísticas</h1>
<ol class="breadcrumb mb-4">
  <li class="breadcrumb-item active">Estatísticas da Plataforma</li>
</ol>

<div class="statistics-container">
  <div class="statistic-item">
    <h3>Novos Utilizadores Hoje</h3>
    <p><?php echo $newUsersTodayCount; ?></p>
  </div>
</div>

<div class="dashboard-container">
  <div class="dashboard-item">
    <h2 class="dashboard-title">Mensagens de Chat</h2>
    <canvas id="chatMessagesChart"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Publicações</h2>
    <canvas id="postsChart"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Novos Utilizadores</h2>
    <canvas id="usersChart"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Mensagens de Chat (Mensal)</h2>
    <canvas id="chatMessagesChartMonthly"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Publicações (Mensal)</h2>
    <canvas id="postsChartMonthly"></canvas>
  </div>
  <div class="dashboard-item">
    <h2 class="dashboard-title">Novos Utilizadores (Mensal)</h2>
    <canvas id="usersChartMonthly"></canvas>
  </div>
</div>

<script>
  const chatMessagesCtx = document.getElementById('chatMessagesChart').getContext('2d');
  const chatMessagesChart = new Chart(chatMessagesCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($chatMessagesLabels); ?>,
      datasets: [{
        label: 'Número de Mensagens de Chat por Dia',
        data: <?php echo json_encode($chatMessagesCounts); ?>,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
        fill: false
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

  const postsCtx = document.getElementById('postsChart').getContext('2d');
  const postsChart = new Chart(postsCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($postsLabels); ?>,
      datasets: [{
        label: 'Número de Publicações por Dia',
        data: <?php echo json_encode($postsCounts); ?>,
        borderColor: 'rgb(54, 162, 235)',
        tension: 0.1,
        fill: false
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

  const usersCtx = document.getElementById('usersChart').getContext('2d');
  const usersChart = new Chart(usersCtx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($usersLabels); ?>,
      datasets: [{
        label: 'Novos Utilizadores por Dia',
        data: <?php echo json_encode($usersCounts); ?>,
        borderColor: 'rgb(255, 99, 132)',
        tension: 0.1,
        fill: false
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

  const chatMessagesCtxMonthly = document.getElementById('chatMessagesChartMonthly').getContext('2d');
  const chatMessagesChartMonthly = new Chart(chatMessagesCtxMonthly, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($chatMessagesLabelsMonthly); ?>,
      datasets: [{
        label: 'Número de Mensagens de Chat por Mês',
        data: <?php echo json_encode($chatMessagesCountsMonthly); ?>,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
        fill: false
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

  const postsCtxMonthly = document.getElementById('postsChartMonthly').getContext('2d');
  const postsChartMonthly = new Chart(postsCtxMonthly, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($postsLabelsMonthly); ?>,
      datasets: [{
        label: 'Número de Publicações por Mês',
        data: <?php echo json_encode($postsCountsMonthly); ?>,
        borderColor: 'rgb(54, 162, 235)',
        tension: 0.1,
        fill: false
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

  const usersCtxMonthly = document.getElementById('usersChartMonthly').getContext('2d');
  const usersChartMonthly = new Chart(usersCtxMonthly, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($usersLabelsMonthly); ?>,
      datasets: [{
        label: 'Novos Utilizadores por Mês',
        data: <?php echo json_encode($usersCountsMonthly); ?>,
        borderColor: 'rgb(255, 99, 132)',
        tension: 0.1,
        fill: false
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
