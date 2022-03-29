<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'functions.php';

saveCheckBoxes($_GET);
$cookieData = checkedCheckbox();

$fields = $_POST;

if (isset($fields['upload'])) {
    $attachment = $_FILES['attachment'];
    $result = validateFileForm($fields, $attachment);
    if ($result) {
        if (!empty($_FILES['attachment']['tmp_name'])) {
            $_SESSION['fileName'] = $attachment['name'];
            if (!empty($fields['description'])) {
                $_SESSION['description'] = $fields['description'];
            }
            saveAttachment($attachment);
        }
        redirectToSuccessPage();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <title>Hello, world!</title>
</head>
<body>
<div class="container">

    <!-- Task 1 !-->
    <div class="row task-block">
        <div class="col-lg-12">
            <h4>Task 1</h4>
        </div>
        <div class="col-lg-2">
            <h5 class="title-text">Counter: <?php clickCounter(); ?></h5>
        </div>
        <div class="col-lg-10">
            <form action="index.php" method="POST">
                <button type="submit" class="btn btn-secondary" name="increment">Increment</button>
                <button type="submit" class="btn btn-success" name="decrement">Decrement</button>
                <button type="submit" class="btn btn-danger" name="clear">Clear</button>
            </form>
        </div>
    </div>


    <!-- Task 2 !-->
    <div class="row task-block">
        <div class="col-lg-12">
            <h4>
                Task 2
                <button type="submit" form="checkboxesForm" class="btn btn-primary" name="saveCheckboxes">Save</button>
            </h4>
        </div>
        <div class="col-lg-12">
            <form id="checkboxesForm" action="index.php" method="GET">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox1" name="checkboxes[1]"
                                   value="checkbox1" <?php if (in_array('checkbox1', $cookieData)) echo 'checked'; ?>>
                            <label class="form-check-label" for="checkbox1">
                                Admin role
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox2" name="checkboxes[2]"
                                   value="checkbox2" <?php if (in_array('checkbox2', $cookieData)) echo 'checked'; ?>>
                            <label class="form-check-label" for="checkbox2">
                                Moderator role
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox3" name="checkboxes[3]"
                                   value="checkbox3" <?php if (in_array('checkbox3', $cookieData)) echo 'checked'; ?>>
                            <label class="form-check-label" for="checkbox3">
                                User role
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox4" name="checkboxes[4]"
                                   value="checkbox4" <?php if (in_array('checkbox4', $cookieData)) echo 'checked'; ?>>
                            <label class="form-check-label" for="checkbox4">
                                Default role
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Task 3 !-->
    <div class="row task-block">
        <form action="index.php" method="POST" enctype="multipart/form-data">
            <div class="col-lg-12">
                <h4>
                    Task 3
                    <button type="submit" name="upload" value="upload" class="btn btn-primary">Upload</button>
                </h4>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea cols="30" rows="3" class="form-control" id="description" name="description"></textarea>
                    <?php showErrors('description'); ?>
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment:</label>
                    <input type="file" class="form-control" id="attachment" name="attachment">
                    <?php showErrors('attachment'); ?>
                </div>
        </form>
    </div>
</div>
</div>
</body>
</html>