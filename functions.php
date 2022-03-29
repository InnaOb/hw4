<?php

function saveCheckBoxes(array $data)
{
    if (isset($data['checkboxes'])) {
        setcookie("task2", json_encode($data['checkboxes']), time() + 60);
    }
}

function checkedCheckbox()
{
    if (isset($_COOKIE['task2'])) {
        $cookie = json_decode($_COOKIE['task2']);
        return (array)$cookie;
    }
    return [];
}

function clickCounter()
{
    if (!isset($_SESSION['counter'])) {
        $_SESSION['counter'] = 0;
    }
    if (isset($_POST['increment'])) {
        ++$_SESSION['counter'];
    }
    if (isset($_POST['decrement']) && $_SESSION['counter'] != 0) {
        --$_SESSION['counter'];
    }
    if (isset($_POST['clear'])) {
        $_SESSION['counter'] = 0;
    }
    echo $_SESSION['counter'];
}

function addError(string $field, string $message)
{
    if (empty($_SESSION['errors'])) {
        $_SESSION['errors'] = [];
    }

    $_SESSION['errors'][$field][] = $message;
}

function showErrors(string $field)
{
    if (!empty($_SESSION['errors'][$field])) {
        foreach ($_SESSION['errors'][$field] as $error) {
            echo '<span class="error">' . $error . '</span>';
        }
        unset($_SESSION['errors'][$field]);
    }
}

function validateFileForm(array $fields, array $file = [])
{

    if ($file['size'] == 0 && $file['name'] == '') {
        addError('attachment', 'Please upload the file');
    }

    if (!empty($file)) {
        $allowedMimeTypes = ['text/plain', 'application/pdf', 'application/vnd.ms-excel', 'application/msword'];
        if (!empty($file['tmp_name']) && !in_array($file['type'], $allowedMimeTypes)) {
            addError('attachment', 'This type is not allowed');
        }
    }

    if (strlen($fields['description']) <= 5 && $fields['description'] > 100) {
        addError('description', 'Must be not less than 5 and not higher than 100 symbols');
    }

    if (!empty($_SESSION['errors'])) {
        return false;
    }
    return true;
}

function saveAttachment(array $file)
{
    $name = basename($file['name']);
    $info = explode('.', $name);
    $extension = $info[1];
    $newName = md5($name . time()) . '.' . $extension;
    $path = __DIR__ . '/files/' . $newName;
    if (!move_uploaded_file($file['tmp_name'], $path)) {
        exit('Something gone wrong');
    }
}

function redirectToSuccessPage()
{
    header('Location: success.php');
}

