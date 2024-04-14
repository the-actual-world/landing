<?php
include_once '../include/config.inc.php';
include_once '../include/modules.inc.php';
include_once 'include/auth.inc.php';
include_once 'get/userinfo.php';
?>


<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Admin - The Actual World</title>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2/dist/bootstrap-confirmation.min.js"></script>

  <link
    href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/fc-5.0.0/fh-4.0.0/kt-2.12.0/sb-1.7.0/datatables.min.css"
    rel="stylesheet">
  <link href="../assets/vendor/summernote/summernote-bs4.min.css" rel="stylesheet" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script
    src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.0/b-3.0.0/b-colvis-3.0.0/b-html5-3.0.0/b-print-3.0.0/cr-2.0.0/date-1.5.2/fc-5.0.0/fh-4.0.0/kt-2.12.0/sb-1.7.0/datatables.min.js"></script>

  <script src="../assets/vendor/summernote/summernote-bs4.min.js"></script>

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/atom-one-dark.min.css">
  <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>

  <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/languages/go.min.js"></script>

  <script src="js/datatables-simple.js" defer></script>

  <style type="text/css">
    div.code {
      color: #fff;
      background: #282a36;
      border-radius: 6px;
      box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
      font-family: monospace;
      font-size: 14px;
      font-weight: 400;
      min-height: 240px;
      letter-spacing: normal;
      line-height: 20px;
      padding: 10px;
      tab-size: 4;
      display: block;
      width: 100%;
    }
  </style>

  <script type="module" id="code">
    import { CodeJar } from "https://medv.io/codejar/codejar.js?"

    $(document).ready(function () {
      document.querySelectorAll('div.code').forEach((textarea) => {
        const editor = new CodeJar(textarea, (textarea) => {
          textarea.dataset.highlighted = '';
          textarea.textContent = textarea.textContent;
          hljs.highlightBlock(textarea);
        });

        const formField = textarea.getAttribute('data-field-name');
        const form = textarea.closest('form');


        editor.onUpdate(code => {
          form.querySelector(`[name="${formField}"]`).value = code.toString();
        });
      });
    });
  </script>

  <script>
    $(function () {
      $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
      });
    });

    function replaceHTMLWYSIWYG(to_replace, values) {
      if (values.includes("<?php echo $arrConfig['url_site'] ?>")) {
        var html = $('textarea.wysiwyg').summernote('code');
        foreach(var new_value in values) {
          if (new_value != "<?php echo $arrConfig['url_site'] ?>") {
            continue;
            html = html.replace(new RegExp(to_replace, 'g'), new_value);
          }
        }
        $('textarea.wysiwyg').summernote('code', html);
      }

      $(document).ready(function () {
        $('textarea.wysiwyg').summernote({
          callbacks: {
            onImageUpload: function (files) {
              var formData = new FormData();
              formData.append('file', files[0]);
              $.ajax({
                url: '<?php echo $arrConfig['url_site'] . '/admin/include/image-upload.php'; ?>',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                  console.log("DATA: " + JSON.stringify(data));
                  var image = JSON.parse(data);
                  if (image.url) {
                    let url = image.url;
                    if ("<?php echo $arrConfig['url_site'] ?>" == "<?php echo $url_site_escola ?>") {
                      url = url.replace("<?php echo $url_site_local ?>", "<?php echo $url_site_escola ?>");
                    } else if ("<?php echo $arrConfig['url_site'] ?>" == "<?php echo $url_site_prod ?>") {
                      url = url.replace("<?php echo $url_site_local ?>", "<?php echo $url_site_prod ?>");
                    }
                    var imageNode = $('<img>').attr('src', url);
                    $('textarea.wysiwyg').summernote('insertNode', imageNode[0]);
                  } else {
                    alert('Error uploading image: ' + image.error);
                  }
                }
              });
            },
            onInit: function () {
              replaceHTMLWYSIWYG('<?php echo $url_site_local ?>', [<?php echo join(", ", $not_localhost_urls) ?>]);
            },
          }
        });
      });
  </script>
</head>

<body>
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 d-flex align-items-center gap-2" href="index.php">
      <img src="../assets/img/logo.png" alt="The Actual World" style="height: 20px;" />
      TAW Admin
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
        class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group">
        <!-- <input class="form-control" type="text" placeholder="Procurar por..." aria-label="Search for..."
          aria-describedby="btnNavbarSearch" />
        <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
      -->
      </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
          aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#!">Definições</a></li>
          <li><a class="dropdown-item" href="#!">Atividades</a></li>
          <li>
            <hr class="dropdown-divider" />
          </li> 
          <li><a class="dropdown-item" href="trata/logout.php">Sair</a></li>
        </ul>
      </li> -->
      <a class="btn btn-danger" href="trata/logout.php">Sair</a>
    </ul>

  </nav>
  <div id="layoutSidenav">
    <div id="layoutSidenav_nav">
      <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
          <div class="nav">
            <div class="sb-sidenav-menu-heading">Logs</div>
            <a class="nav-link" href="index.php">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Dashboard
            </a>
            <a class="nav-link" href="logs.php">
              <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
              Caminhos de Navegação
            </a>
            <a class="nav-link" href="crud.php?module=logs&action=list">
              <div class="sb-nav-link-icon"><i class="fas fa-history"></i></div>
              Todas as Logs
            </a>
            <?php
            $categorias_modules = [
              "Importante" => [
                'paginas',
                'conteudo',
                'menu',
                'mensagens',
                'utilizadores',
              ],
              "Produtos" => [
                'produtos',
                'produtos_caracteristicas',
                'produtos_imagens',
              ],
              "FAQ" => [
                'faq',
                'faq_categorias',
              ],
            ];

            foreach ($categorias_modules as $categoria => $current_modules) {
              echo "<div class='sb-sidenav-menu-heading'>$categoria</div>";
              foreach ($current_modules as $module) {
                echo "
                <a class='nav-link' href='crud.php?module=$module&action=list'>
                  <div class='sb-nav-link-icon'>
                    <i class='{$modules[$module]['icon']}'></i>
                  </div>
                  {$modules[$module]['name']}
                </a>";
              }
            }
            ?>

            <div class="sb-sidenav-menu-heading">Outros Módulos</div>
            <?php
            foreach ($modules as $module => $module_info) {
              if (!in_array($module, array_merge(array_merge(...array_values($categorias_modules)), ['logs']))) {
                echo "
                <a class='nav-link' href='crud.php?module=$module&action=list'>
                  <div class='sb-nav-link-icon'>
                    <i class='{$module_info['icon']}'></i>
                  </div>
                  {$module_info['name']}
                </a>";
              }
            }
            ?>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <div class="small">Logado como:</div>
          <?php echo $sessao['primeiro_nome'] . ' ' . $sessao['ultimo_nome']; ?>
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main class="mt-4">
        <div class="container-fluid px-4">