<?php
include_once '../../include/config.inc.php';
$uploadFolder = "{$arrConfig['dir_site']}/assets/img/uploads";
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

if (!empty($_FILES)) {
  $file = $_FILES['file'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileType = $file['type'];

  if (in_array($fileType, $allowedTypes)) {
    if (!file_exists($uploadFolder) && !is_dir($uploadFolder)) {
      mkdir($uploadFolder, 0755, true);
    }
    $filePath = $uploadFolder . '/' . uniqid() . '-' . $fileName;
    if (move_uploaded_file($fileTmpName, $filePath)) {
      echo json_encode(array('url' => $url_site_local . '/assets/img/uploads/' . basename($filePath)));
    } else {
      echo json_encode(array('error' => 'Failed to move uploaded file.'));
    }
  } else {
    echo json_encode(array('error' => 'Invalid file type.'));
  }
}