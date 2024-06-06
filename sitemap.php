<?php
include_once 'include/config.inc.php';

header('Content-Type: application/xml; charset=utf-8');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

// Add static URLs
$staticUrls = [
  'about.php',
  'contact.php',
  'help.php',
  'home.php',
  'index.php',
  'pricing.php',
  'updates.php',
  'robots.txt'
];

foreach ($staticUrls as $staticUrl) {
  echo '<url>';
  echo '<loc>' . htmlspecialchars($arrConfig['url_site'] . '/' . $staticUrl) . '</loc>';
  echo '<changefreq>monthly</changefreq>';
  echo '<priority>0.5</priority>';
  echo '</url>';
}

$products = my_query("SELECT id, nome FROM produtos WHERE ativo = 1");

foreach ($products as $product) {
  echo '<url>';
  echo '<loc>' . htmlspecialchars($arrConfig['url_site'] . '/product.php?id=' . $product['id'] . '&name=' . urlencode($product['nome'])) . '</loc>';
  echo '<changefreq>weekly</changefreq>';
  echo '<priority>0.8</priority>';
  echo '</url>';
}

$updates = my_query("SELECT A.id, B.titulo, A.data FROM atualizacoes A INNER JOIN atualizacoes_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = '$_SESSION[lang]'");

foreach ($updates as $update) {
  echo '<url>';
  echo '<loc>' . htmlspecialchars($arrConfig['url_site'] . '/update.php?id=' . $update['id'] . '&title=' . urlencode($update['titulo'])) . '</loc>';
  echo '<lastmod>' . date('Y-m-d', strtotime($update['data'])) . '</lastmod>';
  echo '<changefreq>weekly</changefreq>';
  echo '<priority>0.7</priority>';
  echo '</url>';
}

$pages = my_query("SELECT url, modificado_em FROM paginas WHERE ativo = 1");

foreach ($pages as $page) {
  echo '<url>';
  echo '<loc>' . htmlspecialchars($arrConfig['url_site'] . '/' . $page['url']) . '</loc>';
  echo '<lastmod>' . date('Y-m-d', strtotime($page['modificado_em'])) . '</lastmod>';
  echo '<changefreq>weekly</changefreq>';
  echo '<priority>0.6</priority>';
  echo '</url>';
}

$content = my_query("SELECT slug, modificado_em FROM conteudo WHERE ativo = 1");

foreach ($content as $item) {
  echo '<url>';
  echo '<loc>' . htmlspecialchars($arrConfig['url_site'] . '/' . $item['slug']) . '</loc>';
  echo '<lastmod>' . date('Y-m-d', strtotime($item['modificado_em'])) . '</lastmod>';
  echo '<changefreq>weekly</changefreq>';
  echo '<priority>0.6</priority>';
  echo '</url>';
}

echo '</urlset>';
?>