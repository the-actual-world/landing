<?php
include 'include/ui/header.php';

$mode = isset($_GET['mode']) ? $_GET['mode'] : null; // null | handle_form (process form action)
$module = isset($_GET['module']) ? $_GET['module'] : 'patrocinadores'; // slug of the module
$action = isset($_GET['action']) ? $_GET['action'] : 'list'; // list | add | update | delete

function renderFormField($field, $config, $languages, $values = [])
{
    global $arrConfig, $module, $action;
    $required = (!isset($config['required']) || $config['required']) ? 'required' : '';
    echo "<div class='mb-3'>";
    if (isset($config['lang_dependent']) && $config['lang_dependent']) {
        echo "<label class='form-label'>{$config['name']}</label>";
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
        echo "<thead><tr>";
        foreach ($languages as $lang => $langName) {
            echo "<th>{$langName}</th>";
        }
        echo "</tr></thead>";
        echo "<tbody><tr>";
        foreach ($languages as $lang => $langName) {
            $value = isset($values[$lang]) ? $values[$lang] : '';
            $inputId = "{$field}_{$lang}";
            echo "<td>";
            if ($config['type'] === 'textarea') {
                echo "<textarea class='form-control' name='{$field}[$lang]' id='$inputId' $required>$value</textarea>";
            } else if ($config['type'] === 'checkbox') {
                $checked = $value ? 'checked' : '';
                echo "<input type='checkbox' class='form-check-input' name='{$field}[$lang]' id='$inputId' $required $checked>";
            } else if ($config['type'] === 'hidden') {
                echo "<input type='hidden' name='{$field}[$lang]' value='$value'>";
            } else if ($config['type'] === 'decimal') {
                echo "<input type='number' class='form-control' name='{$field}[$lang]' id='$inputId' value='$value' $required step='0.01'>";
            } else if ($config['type'] === 'radio') {
                echo "<div class='form-check'>";
                foreach ($config['options'] as $option => $label) {
                    $checked = $value == $option ? 'checked' : '';
                    echo "<input type='radio' class='form-check-input' name='{$field}[$lang]' value='$option' $required $checked>$label<br>";
                }
                echo "</div>";
            } else if ($config['type'] === 'select') {
                echo "<select class='form-select' name='{$field}[$lang]' id='$inputId' $required>";
                foreach ($config['options'] as $option => $label) {
                    $selected = $value == $option ? 'selected' : '';
                    echo "<option value='$option' $selected>$label</option>";
                }
                echo "</select>";
            } else if ($config['type'] === 'html') {
                echo "<textarea class='wysiwyg' name='{$field}[$lang]' id='$inputId'>$value</textarea>";
            } else if ($config['type'] === 'image') {
                echo "<input type='file' class='form-control' name='{$field}[$lang]' id='$inputId' $required accept='image/*'>";
                if (!empty($value)) {
                    echo "<img src='{$arrConfig['url_site']}/assets/img/$config[folder]/$value' style='max-width: 100px; max-height: 100px'>";
                }
            } else {
                echo "<input type='{$config['type']}' class='form-control' name='{$field}[$lang]' id='$inputId' value='$value' $required>";
            }
            echo "</td>";
        }
        echo "</tr></tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        $input = "";

        if (isset($config['foreign'])) {
            $foreign = $config['foreign'];
            $input = "<select class='form-select' name='$field' $required>";
            $highlighted_columns = isset($foreign['highlighted_columns']) ? $foreign['highlighted_columns'] : [];
            $q = "SELECT * FROM $foreign[module]";
            $foreignData = my_query($q);

            $input .= "<option value='0'>Nenhum</option>";

            foreach ($foreignData as $row) {
                $highlighted_text = "";
                foreach ($highlighted_columns as $highlighted_column) {
                    $highlighted_text .= $row[$highlighted_column] . ", ";
                }
                $highlighted_text = substr($highlighted_text, 0, -2);
                $selected = $values[$field] == $row[$foreign['column']] ? 'selected' : '';
                $input .= "<option value='" . $row[$foreign['column']] . "' $selected>" . $row[$foreign['column']] . " - $highlighted_text</option>";
            }
            $input .= "</select>";
        } else if ($config['type'] === 'textarea') {
            $input = "<textarea class='form-control' name='$field' $required>{$values[$field]}</textarea>";
        } else if ($config['type'] === 'code') {
            $input = "<input type='hidden' name='$field' value='" . trim(htmlspecialchars($values[$field], ENT_QUOTES)) . "' $required>
            <div class='code language-php' data-field-name='$field'>" . trim(htmlspecialchars($values[$field], ENT_QUOTES)) . "</div>";
            if ($action === 'update') {
                $input .= '
                <script>
                    const value = "' . $arrConfig['url_site'] . '" + "/" + document.querySelector(\'input[name="url"]\').value;
                    document.write(\'<iframe src="\'+value+\'" frameborder="0" style="width: 100%; height: 900px; margin-top: 10px; border: 2px dashed #ccc; border-radius: 0.5rem;"></iframe>\');
                </script>';
            }
        } else if ($config['type'] === 'date') {
            $input = "<input type='date' class='form-control' name='$field' value='{$values[$field]}' $required>";
        } else if ($config['type'] === 'datetime') {
            $input = "<input type='datetime-local' class='form-control' name='$field' value='" . date('Y-m-d\TH:i:s', strtotime($values[$field])) . "' $required>";
        } else if ($config['type'] === 'time') {
            $input = "<input type='time' class='form-control' name='$field' value='{$values[$field]}' $required>";
        } else if ($config['type'] === 'html') {
            $input = "<textarea class='wysiwyg' name='$field'>{$values[$field]}</textarea>";
        } elseif ($config['type'] === 'checkbox') {
            $checked = $values[$field] ? 'checked' : '';
            $input = "<input type='checkbox' class='form-check-input' name='$field' $required $checked>";
        } else if ($config['type'] === 'password') {
            if ($action === 'add') {
                $input = "<input type='password' class='form-control' name='$field' $required>";
            } else {
                $input = "<input type='password' class='form-control' name='$field' placeholder='Deixa em branco para manter a mesma senha'>";
            }
        } elseif ($config['type'] === 'decimal') {
            $input = "<input type='number' class='form-control' name='$field' value='{$values[$field]}' $required step='0.01'>";
        } else if ($config['type'] === 'radio') {
            $input = "<div class='form-check'>";
            foreach ($config['options'] as $option => $label) {
                $checked = $values[$field] == $option ? 'checked' : '';
                $input .= "<input type='radio' class='form-check-input' name='$field' value='$option' $required $checked>$label<br>";
            }
            $input .= "</div>";
        } elseif ($config['type'] === 'select') {
            $input = "<select class='form-select' name='$field' $required>";
            foreach ($config['options'] as $option => $label) {
                $selected = $values[$field] == $option ? 'selected' : '';
                $input .= "<option value='$option' $selected>$label</option>";
            }
            $input .= "</select>";
        } elseif ($config['type'] === 'image') {
            $input = "<input type='file' class='form-control' name='$field' $required accept='image/*'>";
            if (!empty($values[$field])) {
                $input .= "<img src='{$arrConfig['url_site']}/assets/img/$config[folder]/{$values[$field]}' style='max-width: 100px; max-height: 100px'>";
            }
        } else {
            $input = "<input type='{$config['type']}' class='form-control' name='$field' value='{$values[$field]}' $required>";
        }

        if ($config['type'] !== 'hidden') {
            echo "<div class='mb-3'>
                    <label class='form-label' for='$field'>{$config['name']}</label>
                    $input
                </div>";
        } else {
            echo $input;
        }
    }
    echo "</div>";
}

function renderForm($module, $action, $fields, $languages, $data = [])
{
    global $modules;
    $textoForm = "<form method='post' enctype='multipart/form-data' action='crud.php?module=$module&action=$action&mode=handle_form";
    if ($action == 'update') {
        foreach ($fields as $field => $value) {
            if (isset($value['primary']) && $value['primary']) {
                $textoForm .= "&$field=" . $data['data_main'][$field];
            }
        }
    }
    $textoForm .= "'>";
    echo $textoForm;

    foreach ($fields as $field => $config) {
        $values = [];
        if (isset($config['lang_dependent']) && $config['lang_dependent']) {
            foreach ($languages as $lang => $langName) {
                $values[$lang] = isset($data['data_langs'][$lang][$field]) ? $data['data_langs'][$lang][$field] : '';
            }
        } else {
            $values[$field] = isset($data['data_main'][$field]) ? $data['data_main'][$field] : '';
        }
        renderFormField($field, $config, $languages, $values);
    }

    if ($action == 'update') {
        foreach ($modules as $slug => $_module) {
            foreach ($_module['columns'] as $field => $config) {
                if (isset($config['foreign']) && $config['foreign']['module'] == $module) {
                    echo "<h4>{$_module['name']}</h4>";

                    $foreign = $config['foreign'];
                    $q = "SELECT * FROM $slug WHERE $field = '" . $data['data_main'][$foreign['column']] . "'";
                    $foreignData = my_query($q);

                    if (count($foreignData) > 0) {
                        $columnsToRender = array_diff_key($_module['columns'], array_flip([$field]));
                        renderTable($slug, $columnsToRender, $foreignData, false, false, false);
                    } else {
                        echo "<p>Nenhum registo encontrado</p>";
                    }
                }
            }
        }
    }

    $btnText = $action == 'add' ? 'Adicionar' : 'Salvar';
    echo '<div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary mb-4">' . $btnText . '</button>
        <a href="crud.php?module=' . $module . '&action=list" class="btn btn-secondary mb-4">Cancelar</a>
    </div>';
    echo "</form>";
}


function renderTable($module, $fields, $data, $isDatatable = true, $showActions = true, $showAddButton = true)
{
    global $arrConfig, $modules, $formats;
    if (isset($config['editable']) && $modules[$module]['supports_lang']) {
        echo "<select class='form-select mb-3' onchange=\"window.location.href = this.value\">";
        foreach ($arrConfig['langs'] as $lang => $name) {
            $selected = $_GET['lang'] == $lang ? 'selected' : '';
            echo "<option value='crud.php?module=$module&action=list&lang=$lang' $selected>$name</option>";
        }
        echo "</select>";
    }

    echo "<table class='table table-striped' " . ($isDatatable ? "id='datatablesSimple'" : "") . ">";
    echo "<thead><tr>";
    foreach ($fields as $field => $config) {
        echo "<th>{$config['name']}</th>";
    }
    if ($showActions) {
        echo "<th>Ações</th>";
    }
    echo "</tr></thead>";
    foreach ($data as $row) {
        $primary_fields_text = "";
        foreach ($fields as $field => $config) {
            $primary_fields_text .= isset($config["primary"]) && $config["primary"] ? "&{$field}={$row[$field]}" : "";
        }

        echo "<tr>";
        foreach ($fields as $field => $config) {
            if ($config['type'] == 'checkbox') {
                $row[$field] = $row[$field] ? 'Sim' : 'Não';
            } else if ($config['type'] == 'date') {
                $row[$field] = date($formats['date'], strtotime($row[$field]));
            } else if ($config['type'] == 'datetime') {
                $row[$field] = date($formats['datetime'], strtotime($row[$field]));
            } else if ($config['type'] == 'time') {
                $row[$field] = date($formats['time'], strtotime($row[$field]));
            } else if ($config['type'] == 'decimal') {
                $row[$field] = number_format($row[$field], 2, ',', '.');
            } else if ($config['type'] == 'password') {
                $row[$field] = "********";
            } else if ($config['type'] == 'code') {
                $row[$field] = substr(strip_tags($row[$field]), 0, 50) . "...";
            } else if ($config['type'] == 'image') {
                $row[$field] = "<img src='{$arrConfig['url_site']}/assets/img/$config[folder]/{$row[$field]}' style='max-width: 100px; max-height: 100px'>";
            } else if ($config['type'] == 'html') {
                $row[$field] = substr(strip_tags($row[$field]), 0, 50) . "...";
            } else if ($config['type'] == 'radio') {
                $row[$field] = $config['options'][$row[$field]];
            } else if ($config['type'] == 'select') {
                $row[$field] = $config['options'][$row[$field]];
            }
            $text = "<td>{$row[$field]}</td>";
            if (isset($config['foreign'])) {
                $inner_text = substr(substr($text, 0, -5), 4);
                if ($inner_text == "" || $inner_text == "0") {
                    $text = "<td>Nenhum</td>";
                } else {

                    $foreign = $config['foreign'];
                    $highlighted_columns = isset($foreign['highlighted_columns']) ? $foreign['highlighted_columns'] : [];
                    $highlighted_text = "";
                    $q = "SELECT " . implode(", ", $highlighted_columns) . " FROM $foreign[module] WHERE $foreign[column] = {$row[$field]}";
                    $foreign_row = my_query($q)[0];
                    foreach ($highlighted_columns as $highlighted_column) {
                        $highlighted_text .= $foreign_row[$highlighted_column] . ", ";
                    }
                    $highlighted_text = substr($highlighted_text, 0, -2);
                    $text = "<td><a href='crud.php?module=$foreign[module]&action=update&$foreign[column]={$row[$field]}'>$inner_text</a> ($highlighted_text)</td>";
                }
            }
            echo $text;
        }
        if ($showActions) {
            echo "<td>
                    <div class='btn-group' role='group' aria-label='Basic example'>
                        <a href='crud.php?module=$module&action=update$primary_fields_text' class='btn btn-sm btn-primary'>
                        <i class='fa fa-edit'></i>
                        </a>
                        <a href='crud.php?module=$module&action=delete$primary_fields_text&mode=handle_form' class='btn btn-sm btn-danger' data-toggle='confirmation' data-title='Tens a certeza?' data-btn-ok-label='Sim' data-btn-ok-class='btn btn-success d-flex gap-1' data-btn-cancel-label='Não' data-btn-cancel-class='btn btn-danger d-flex gap-1' 
                        data-btn-ok-icon-class='fa fa-check' data-btn-cancel-icon-class='fa fa-times'>
                        <i class='fa fa-trash'></i>
                        </a>
                    </div>
                </td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";

    if ($showAddButton) {
        echo "<div class='d-flex justify-content-end'><a href='crud.php?module=$module&action=add' class='btn btn-success mt-2'>Adicionar Novo</a></div>";
    }
}

if ($mode == 'handle_form') {
    $texto_sql_primary_keys = "";
    if ($action !== 'add') {
        foreach ($modules[$module]['columns'] as $field => $config) {
            if (isset($config['primary']) && $config['primary']) {
                $texto_sql_primary_keys .= "$field = '{$arrConfig['conn']->real_escape_string($_GET[$field])}' AND ";
            }
        }
        $texto_sql_primary_keys = substr($texto_sql_primary_keys, 0, -5);
    }

    if ($action == 'add') {
        $sql_normal = "INSERT INTO $module (";
        $sql_normal_values = "VALUES (";
        $langs_data = array();
        foreach ($modules[$module]['columns'] as $field => $config) {
            if ($config['type'] == 'checkbox') {
                if (isset($_POST[$field])) {
                    $_POST[$field] = 1;
                } else {
                    $_POST[$field] = 0;
                }
            } else if ($config['type'] == 'html') {
                if ($arrConfig['url_site'] == $url_site_school) {
                    $_POST[$field] = str_replace(
                        $url_site_local,
                        $url_site_school,
                        $_POST[$field]
                    );
                } else if ($arrConfig['url_site'] == $url_site_prod) {
                    $_POST[$field] = str_replace(
                        $url_site_local,
                        $url_site_prod,
                        $_POST[$field]
                    );
                }
            } else if ($config['type'] == 'datetime') {
                $_POST[$field] = date('Y-m-d H:i:s', strtotime($_POST[$field]));
            } else if ($config['type'] == 'date') {
                $_POST[$field] = date('Y-m-d', strtotime($_POST[$field]));
            } else if ($config['type'] == 'time') {
                $_POST[$field] = date('H:i:s', strtotime($_POST[$field]));
            } else if ($config['type'] == 'password') {
                $_POST[$field] = password_hash($_POST[$field], PASSWORD_DEFAULT);
            } else if ($config['type'] == 'image') {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
                    $file = $_FILES[$field];
                    $filename = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];
                    $fileType = $file['type'];

                    $fileExt = explode('.', $filename);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('jpg', 'jpeg', 'png', 'gif');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = '../assets/img/' . $config['folder'] . '/' . $fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);
                                $_POST[$field] = $fileNameNew;
                            } else {
                                echo "Your file is too big!";
                            }
                        } else {
                            echo "There was an error uploading your file!";
                        }
                    } else {
                        echo "You cannot upload files of this type!";
                    }
                } else {
                    $_POST[$field] = '';
                }
            }

            if (!isset($config['editable']) || $config['editable']) {
                if (isset($config['lang_dependent']) && $config['lang_dependent']) {
                    foreach ($_POST[$field] as $lang => $value) {
                        $langs_data[$lang][$field] = $arrConfig['conn']->real_escape_string($value);
                    }
                } else {
                    $sql_normal .= "$field, ";
                    $sql_normal_values .= "'{$arrConfig['conn']->real_escape_string($_POST[$field])}', ";
                }
            }
        }
        $sql_normal = substr($sql_normal, 0, -2) . ") ";
        $sql_normal_values = substr($sql_normal_values, 0, -2) . ") ";
        $last_id = my_query($sql_normal . $sql_normal_values);

        if ($last_id) {
            if (isset($config['editable']) && $modules[$module]['supports_lang']) {
                foreach ($langs_data as $lang => $data) {
                    $sql_lang = "INSERT INTO {$module}_lang (id, lang, ";
                    $sql_lang_values = "VALUES ($last_id, '$lang', ";
                    foreach ($data as $field => $value) {
                        $sql_lang .= "$field, ";
                        $sql_lang_values .= "'$value', ";
                    }
                    $sql_lang = substr($sql_lang, 0, -2) . ") ";
                    $sql_lang_values = substr($sql_lang_values, 0, -2) . ") ";
                    my_query($sql_lang . $sql_lang_values);
                }
            }
        }

        if (isset($config['editable']) && $modules[$module]['supports_lang']) {
            foreach ($langs_data as $lang => $data) {
                $sql_lang = "INSERT INTO {$module}_lang (";
                $sql_lang_values = "VALUES (";

                foreach ($primary_fields as $field) {
                    $sql_lang .= "$field, ";
                    $sql_lang_values .= "'{$arrConfig['conn']->real_escape_string($data[$field])}', ";
                }

                $sql_lang .= "lang, ";
                $sql_lang_values .= "'$lang', ";

                foreach ($data as $field => $value) {
                    if (!in_array($field, $primary_fields)) {
                        $sql_lang .= "$field, ";
                        $sql_lang_values .= "'{$arrConfig['conn']->real_escape_string($value)}', ";
                    }
                }

                $sql_lang = substr($sql_lang, 0, -2) . ") ";
                $sql_lang_values = substr($sql_lang_values, 0, -2) . ") ";
                my_query($sql_lang . $sql_lang_values);
            }
        }

        redirect($arrConfig["url_admin"] . "/crud.php?module=$module&action=add&notice=1");
    }
    if ($action == 'update') {
        $langs_data = array();
        foreach ($modules[$module]['columns'] as $field => $config) {
            if ($config['type'] == 'checkbox') {
                if (isset($_POST[$field])) {
                    $_POST[$field] = 1;
                } else {
                    $_POST[$field] = 0;
                }
            } else if ($config['type'] == 'password') {
                if ($_POST[$field] != '') {
                    $_POST[$field] = password_hash($_POST[$field], PASSWORD_DEFAULT);
                } else {
                    $_POST[$field] = my_query("SELECT $field FROM $module WHERE $texto_sql_primary_keys")[0][$field];
                }
            } else if ($config['type'] == 'html') {
                if ($arrConfig['url_site'] == $url_site_school) {
                    $_POST[$field] = str_replace(
                        $url_site_local,
                        $url_site_school,
                        $_POST[$field]
                    );
                } else if ($arrConfig['url_site'] == $url_site_prod) {
                    $_POST[$field] = str_replace(
                        $url_site_local,
                        $url_site_prod,
                        $_POST[$field]
                    );
                }
            } else if ($config['type'] == 'datetime') {
                $_POST[$field] = date('Y-m-d H:i:s', strtotime($_POST[$field]));
            } else if ($config['type'] == 'date') {
                $_POST[$field] = date('Y-m-d', strtotime($_POST[$field]));
            } else if ($config['type'] == 'time') {
                $_POST[$field] = date('H:i:s', strtotime($_POST[$field]));
            } else if ($config['type'] == 'image') {
                if (isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
                    $file = $_FILES[$field];
                    $filename = $file['name'];
                    $fileTmpName = $file['tmp_name'];
                    $fileSize = $file['size'];
                    $fileError = $file['error'];
                    $fileType = $file['type'];

                    $fileExt = explode('.', $filename);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('jpg', 'jpeg', 'png', 'gif');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = '../assets/img/' . $config['folder'] . '/' . $fileNameNew;
                                move_uploaded_file($fileTmpName, $fileDestination);
                                $_POST[$field] = $fileNameNew;
                            } else {
                                echo "Your file is too big!";
                            }
                        } else {
                            echo "There was an error uploading your file!";
                        }
                    } else {
                        echo "You cannot upload files of this type!";
                    }
                } else {
                    $_POST[$field] = my_query("SELECT $field FROM $module WHERE $texto_sql_primary_keys")[0][$field];
                }
            }

            if (!isset($config['editable']) || $config['editable']) {
                if (isset($config['lang_dependent']) && $config['lang_dependent']) {
                    foreach ($_POST[$field] as $lang => $value) {
                        $langs_data[$lang][$field] = $arrConfig['conn']->real_escape_string($value);
                    }
                } else {
                    my_query("UPDATE $module SET $field = '{$arrConfig['conn']->real_escape_string($_POST[$field])}' WHERE $texto_sql_primary_keys");
                }
            }
        }
        if ($modules[$module]['supports_lang']) {
            foreach ($langs_data as $lang => $data) {
                foreach ($data as $field => $value) {
                    my_query("UPDATE {$module}_lang SET $field = '$value' WHERE $texto_sql_primary_keys AND lang = '$lang'");
                }
            }
        }

        $new_primary_fields = "";
        foreach ($modules[$module]['columns'] as $field => $config) {
            if (isset($config['primary']) && $config['primary']) {
                $new_primary_fields .= "$field=" . $_GET[$field] . "&";
            }
        }
        $new_primary_fields = substr($new_primary_fields, 0, -1);
        redirect($arrConfig["url_admin"] . "/crud.php?module=$module&action=update&notice=1&$new_primary_fields");
    }
    if ($action == 'delete') {
        my_query("DELETE FROM $module WHERE $texto_sql_primary_keys");
        if (isset($config['editable']) && $modules[$module]['supports_lang']) {
            my_query("DELETE FROM {$module}_lang WHERE $texto_sql_primary_keys");
        }

        redirect($arrConfig["url_admin"] . "/crud.php?module=$module&action=list");
        die;
    }

    exit;
}

?>

<main>
    <?php
    if (isset($_GET['notice'])) {
        $notice = $_GET['notice'];
        if ($notice == 1) {
            echo "<div class='alert alert-success' role='alert'>Registo salvo com sucesso!</div>";
        }
    }
    ?>

    <?php

    switch ($action) {
        case 'add':
            renderForm($module, 'add', $modules[$module]['columns'], $arrConfig['langs']);
            break;
        case 'update':
            $primary_and_text_sql = "";
            foreach ($modules[$module]['columns'] as $field => $config) {
                if (isset($config['primary']) && $config['primary']) {
                    $primary_and_text_sql .= "$field = '{$_GET[$field]}' AND";
                }
            }
            $primary_and_text_sql = substr($primary_and_text_sql, 0, -3);

            // if (isset($config['editable']) && $modules[$module]['supports_lang']) {
            if ($modules[$module]['supports_lang']) {
                $data = my_query("SELECT * FROM {$module}_lang WHERE $primary_and_text_sql");
                $mainData = my_query("SELECT * FROM $module WHERE $primary_and_text_sql LIMIT 1");

                $data_langs = [];
                foreach ($data as $row) {
                    $data_langs[$row["lang"]] = $row;
                }

                $data = array(
                    0 => array(
                        "data_langs" => $data_langs,
                        "data_main" => $mainData[0]
                    )
                );
            } else {
                $data = array(
                    0 => array(
                        "data_main" => my_query("SELECT * FROM $module WHERE $primary_and_text_sql LIMIT 1")[0]
                    )
                );
            }
            renderForm($module, 'update', $modules[$module]['columns'], $arrConfig['langs'], $data[0]);
            break;
        case 'list':
            if (isset($modules[$module]['db_pagination']) && $modules[$module]['db_pagination']) {
                echo '
                <table class="table table-striped" id="datatablesSimpleServerSidePagination"></table>
                ';
                echo "
                <script>
                var table = document.querySelector('#datatablesSimpleServerSidePagination');
                var tHead = table.createTHead();
                var rows = tHead.insertRow();
                var headers = ['" .
                    implode("', '", array_map(function ($column) {
                        return $column['name'];
                    }, $modules[$module]['columns']))
                    . "'];
                headers.forEach(header => {
                    var th = document.createElement('th');
                    th.textContent = header;
                    rows.appendChild(th);
                });
                </script>
                ";
                echo '
                <script>
                    $(document).ready(function () {
                    const datatablesSimple = document.getElementById("datatablesSimpleServerSidePagination");
                    if (datatablesSimple) {
                      new DataTable(datatablesSimple, {
                        processing: true,
                        serverSide: true,
                        ajax: {
                          url: "' . $arrConfig['url_admin'] . '/list.php",
                          type: "GET",
                        },
                        searchable: true,
                        sortable: true,
                        lengthMenu: [15, 25, 50, 75, 100],
                        pageLength: ' . $arrConfig["pagination"] . ',
                        orderCellsTop: true,
                        fixedHeader: true,
                        colReorder: true,
                        language: {
                          paginate: {
                            previous: "Anterior",
                            next: "Próximo",
                          },
                          lengthMenu: "Mostrar _MENU_ registos por página",
                          zeroRecords: "Nenhum registo encontrado",
                          emptyTable: "Tabela vazia",
                          info: "A exibir _START_ até _END_ de _TOTAL_ registos",
                          infoEmpty: "Nenhum registo encontrado",
                          infoFiltered: "(filtrado de _MAX_ registos)",
                          searchBuilder: {
                            value: "Valor",
                            valueJoiner: "e",
                            titleAttr: "Construtor de Pesquisa",
                            buttonAttr: "Construtor de Pesquisa",
                            logicAnd: "E",
                            logicOr: "Ou",
                            add: "Adicionar Filtro",
                            clearAll: "Limpar Tudo",
                            condition: "Condição",
                            conditions: {
                              no: "Não",
                              yes: "Sim",
                              "=": "Igual",
                              "!=": "Diferente",
                              "<": "Menor que",
                              "<=": "Menor ou igual a",
                              ">": "Maior que",
                              ">=": "Maior ou igual a",
                              string: {
                                equals: "Igual",
                                not: "Diferente",
                                startsWith: "Começa com",
                                notStartsWith: "Não começa com",
                                contains: "Contém",
                                notContains: "Não contém",
                                endsWith: "Termina com",
                                notEndsWith: "Não termina com",
                                empty: "Vazio",
                                notEmpty: "Não vazio",
                              },
                            },
                            data: "Coluna",
                            deleteTitle: "Apagar filtro",
                            leftTitle: "Condição Externa",
                            rightTitle: "Condição Interna",
                            valueTitle: "Valor",
                            buttonTitle: "Filtro",
                            selected: "selecionado",
                            selectedAll: "Todos selecionados",
                            selectedNone: "Nenhum selecionado",
                            titleButton: "Filtros",
                          },
                          buttons: {
                            copyTitle: "Copiado para a área de transferência",
                            copyKeys:
                              "Pressiona <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> para copiar os dados da tabela para a área de transferência. <br><br>Para cancelar, clica nesta mensagem ou pressiona ESC.",
                            copySuccess: {
                              1: "1 linha copiada para a área de transferência",
                              _: "%d linhas copiadas para a área de transferência",
                            },
                          },
                        },
                        columnDefs: [
                          {
                            targets: 1,
                            className: "noVis",
                          },
                        ],
                        layout: {
                          topEnd: {
                            buttons: [
                              {
                                extend: "print",
                                text: "<i class=\'bi bi-printer\'></i>",
                                className: "btn btn-primary",
                                titleAttr: "Imprimir",
                                exportOptions: {
                                  columns: ":visible",
                                },
                              },
                              {
                                extend: "csv",
                                text: "<i class=\'bi bi-file-earmark-spreadsheet\'></i>",
                                className: "btn btn-warning",
                                titleAttr: "CSV",
                                exportOptions: {
                                  columns: ":visible",
                                },
                              },
                              {
                                extend: "excel",
                                text: "<i class=\'bi bi-file-earmark-excel\'></i>",
                                className: "btn btn-success",
                                titleAttr: "Excel",
                                exportOptions: {
                                  columns: ":visible",
                                },
                              },
                              {
                                extend: "pdf",
                                text: "<i class=\'bi bi-file-earmark-pdf\'></i>",
                                className: "btn btn-danger",
                                titleAttr: "PDF",
                                exportOptions: {
                                  columns: ":visible",
                                },
                              },
                              {
                                extend: "copy",
                                text: "<i class=\'bi bi-clipboard\'></i>",
                                className: "btn btn-secondary",
                                titleAttr: "Copiar",
                                exportOptions: {
                                  columns: ":visible",
                                },
                              },
                              {
                                extend: "colvis",
                                text: "<i class=\'bi bi-eye\'></i> Colunas",
                                className: "btn btn-light",
                                title: "Colunas",
                                popoverTitle: "Escolher colunas",
                              },
                            ],
                          },
                        },
                      });
                    }
                  });
                </script>';
            } else {
                if (isset($config['editable']) && $modules[$module]['supports_lang']) {
                    $on_text = "";
                    foreach ($modules[$module]['columns'] as $field => $config) {
                        if (isset($config['primary']) && $config['primary']) {
                            $on_text .= "A.$field = B.$field AND ";
                        }
                    }
                    $on_text = substr($on_text, 0, -5);

                    $lang = $_GET['lang'] ?? $_SESSION["lang"] ?? 'pt';
                    $data = my_query("SELECT * FROM $module A
                                        INNER JOIN {$module}_lang B ON $on_text
                                        WHERE B.lang = '$lang'");
                } else {
                    $data = my_query("SELECT * FROM $module");
                }
                renderTable($module, $modules[$module]['columns'], $data);
            }

            break;
    }

    ?>
</main>
</div>
</main>

<?php include 'include/ui/footer.php'; ?>