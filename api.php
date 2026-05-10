<?php

header('Content-Type: application/json');

if(!isset($_GET['number'])){

    echo json_encode([
        "status" => false,
        "message" => "Number required"
    ]);
    exit;
}

$search = trim($_GET['number']);

$file = "data.csv";

if(!file_exists($file)){

    echo json_encode([
        "status" => false,
        "message" => "CSV file not found"
    ]);
    exit;
}

$handle = fopen($file, "r");

$header = fgetcsv($handle);

while(($row = fgetcsv($handle)) !== false){

    $mobile = preg_replace('/[^0-9]/', '', $row[1]);

    if($mobile == $search){

        $data = array_combine($header, $row);

        echo json_encode([
            "status" => true,
            "data" => $data
        ]);

        fclose($handle);
        exit;
    }
}

fclose($handle);

echo json_encode([
    "status" => false,
    "message" => "Number not found"
]);

?>
