<?php include 'include/ui/header.php'; ?>

<?php
$users = my_query('SELECT id, primeiro_nome, ultimo_nome, email FROM utilizadores');
$sessionIds = my_query('SELECT DISTINCT id_sessao FROM logs');

function fetchLogs($userId = null, $sessionId = null)
{
  global $arrConfig;
  $conditions = [];
  if (!empty($userId)) {
    $conditions[] = "id_utilizador = '{$userId}'";
  }
  if (!empty($sessionId)) {
    $conditions[] = "id_sessao = '{$sessionId}'";
  }
  $whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

  $query = "SELECT * FROM logs {$whereClause} ORDER BY data ASC";
  return my_query($query);
}

$userId = $_POST['userId'] ?? null;
$sessionId = $_POST['sessionId'] ?? $sessionIds[0]['id_sessao'] ?? null;
$logs = $sessionId ? fetchLogs($userId, $sessionId) : [];

if (!empty($userId)) {
  $user = my_query("SELECT primeiro_nome, ultimo_nome, email FROM utilizadores WHERE id = '{$userId}'")[0];
}
?>

<head>
  <title>The Actual World - Logs</title>
  <style>
    .pathway-container {
      display: flex;
      overflow-x: auto;
      white-space: nowrap;
      padding: 20px 0;
    }

    .pathway-node {
      background-color: #f8f9fa;
      border: 1px solid #e0e0e0;
      border-radius: 5px;
      padding: 10px;
      position: relative;
      min-width: 300px;
    }

    .pathway-arrow {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 12px;
    }
  </style>
</head>

<main>
  <section class="hero-section" id="hero">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-sm-12 hero-text-image">
          <h1>Logs</h1>
          <p>Registo de atividades por sessão</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <form action="logs.php" method="post" class="mb-4">
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label for="userId">Administrador <span class="text-muted">(opcional)</span></label>
                  <select class="form-control" id="userId" name="userId">
                    <option value="">Qualquer visitante</option>
                    <?php foreach ($users as $user): ?>
                      <option value="<?php echo $user['id'] ?>" <?php echo $user['id'] === $userId ? 'selected' : '' ?>>
                        <?php echo "{$user['primeiro_nome']} {$user['ultimo_nome']} ({$user['email']})" ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group">
                  <label for="sessionId">ID da Sessão <span class="text-danger">(obrigatório)</span></label>
                  <select class="form-control" id="sessionId" name="sessionId" required>
                    <?php foreach ($sessionIds as $session): ?>
                      <option value="<?php echo $session['id_sessao'] ?>" <?php echo $session['id_sessao'] === $sessionId ? 'selected' : '' ?>>
                        <?php echo $session['id_sessao'] ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtrar</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php if (!empty($sessionId) && !empty($logs)): ?>
        <div class="row">
          <div class="container">
            <div class="pathway-container">
              <?php foreach ($logs as $log): ?>
                <div class="pathway-node">
                  <div class="overflow-auto bg-primary text-white p-2 mb-2 rounded">
                    <?php echo $log['pagina'] ?>
                  </div>
                  <?php if (!empty($log['de_onde'])): ?>
                    <div class="pathway-referrer overflow-auto"><strong>De onde?</strong>
                      <?php echo $log['de_onde'] ?>
                    </div>
                  <?php endif; ?>
                  <div class="pathway-info">
                    <div class="d-flex gap-2">
                      <span
                        class="badge <?php echo $log['acao'] === 'PAGINA_NAO_ENCONTRADA' ? 'bg-danger' : 'bg-success' ?>">
                        <?php echo $log['acao'] ?>
                      </span>
                      <span class="badge bg-info">
                        <?php echo $log['endereco_ip'] ?>
                      </span>
                    </div>
                    <div>
                      <small>
                        <?php echo $log['id_utilizador'] ? "📝 {$user['primeiro_nome']} {$user['ultimo_nome']} ({$user['email']})" : '❓ Anónimo' ?>
                      </small>
                    </div>
                    <div>
                      <small class="text-muted">
                        <?php echo date('d/m/Y H:i:s', strtotime($log['data'])) ?>
                      </small>
                    </div>
                  </div>
                </div>
                <?php if ($log !== end($logs)): ?>
                  <div class="pathway-arrow">
                    <i class="fas fa-arrow-right"></i>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php elseif (isset($sessionId)): ?>
        <div class="alert alert-info">Nenhuma log foi encontrada para a sessão especificada.</div>
      <?php endif; ?>
    </div>
  </section>
  </div>
</main>

<?php include 'include/ui/footer.php'; ?>