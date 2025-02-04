<?php
include "databaseNew.php";

$data = [
    "name" => "Haris",
    "person" => "Haris Mohammed"
];
echo prepareInsertQuery('myTable', $data);