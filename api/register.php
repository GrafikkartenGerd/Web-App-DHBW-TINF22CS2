<?php

include "util.php";
include "AuthController.php";

$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strtoupper($requestMethod) !== 'POST') {
    failWithCode(405);
}

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$name = $_POST['name'] ?? null;
$surname = $_POST['surname'] ?? null;
$birthday = $_POST['birthday'] ?? null;
$gender = $_POST['gender'] ?? null;
$matriculation_number = $_POST['matriculation_number'] ?? null;
$faculty = $_POST['faculty'] ?? null;
$degree = $_POST['degree'] ?? null;
$course = $_POST['course'] ?? null;

if (
    $username === null ||
    $password === null ||
    $name === null ||
    $surname === null ||
    $birthday === null ||
    $gender === null ||
    $matriculation_number === null ||
    $faculty === null ||
    $degree === null ||
    $course === null
) {
    failWithCode(400);
}

if (!in_array($gender, ['m', 'f', 'o'])) {
    failWithCode(400);
}

$birthday = date_create_from_format("Y-m-d", $birthday);
if ($birthday === false) {
    failWithCode(400);
}

$controller = new AuthController();
$result = $controller->register($username, $password, $name, $surname, $birthday, $gender, $matriculation_number, $faculty, $degree, $course);

echo (json_encode(['status' => $result]));
?>
