<?php

// probably there's a smarter way to do this, but I'm doing it like this for now.
$day_no = $_POST["dayNo"];
if($day_no < 10) {
    $day_no = "0" . $day_no;
}
include "./day".$day_no."/solver.php";

function print_main() {
    if(isset($_POST["dayNo"]) && isset($_FILES["data"])) {
        if(!print_puzzle_solution()) {
            print_error();
        }
    }
    print_input_form();
}

function print_puzzle_solution() {
    // sanity checks
    if(!function_exists("solve")) {
        return false;
    }
    if ($_FILES['uploadedfile']['error'] != UPLOAD_ERR_OK) {
        return false;
    }
    if(!is_uploaded_file($_FILES['data']['tmp_name'])) {
        return false;
    }
    // do stuff
    $data = file_get_contents($_FILES['data']['tmp_name']);
    $solution = solve($data);
    ?>
        <div class="two-col-grid">
            <span>Solution to part 1:&nbsp;</span>
            <span><?php echo($solution["Part1"]); ?></span>
            <span>Solution to part 2:&nbsp;</span>
            <span><?php echo($solution["Part2"]); ?></span>
        </div>
        <hr>
        <details>
            <summary>Debug Log:</summary>
            <?php
                foreach($solution["Debug"] as $row) {
                    print($row);
                    print("<br>");
                }
            ?>
        </details>
        <hr>
    <?php
    return true;
}

function print_error() {
    //TODO
}

function print_input_form() {
    ?>
        <form method="POST" action="." enctype="multipart/form-data" class="two-col-grid">
            <label for="dayNo">Day Number:</label>
            <input type="number" id="dayNo" name="dayNo">
            <label for="data">Puzzle Data:</label>
            <input type="file" id="data" name="data">
            <button type="submit">Go!</button>
        </form>
    <?php
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Advent of Code 2025</title>
        <style>
            .two-col-grid {
                display: inline-grid;
                grid-template-columns: 1fr 1fr;
            }
        </style>
    </head>
    <body>
        <h1>Advent of Code 2025</h1>
        <?php print_main() ?>
    </body>
</html>