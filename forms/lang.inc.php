<?php

include "../include/config.inc.php";

if (isset($_GET["lang"])) {
  $_SESSION["lang"] = $_GET["lang"];
  setcookie("lang", $_GET["lang"], time() + 86400 * 100, "/");
}

if (isset($_SERVER['HTTP_REFERER'])) {
  $referer = $_SERVER['HTTP_REFERER'];
  header("Location: $referer");
} else {
  header("Location: $arrConfig[url_site]");
}