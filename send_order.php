<?php
$host = 'localhost';
$dbname = 'cb082986_profivdel';      // ← исправлено
$username = 'cb082986_profivdel';    // ← исправлено
$password = '6rUy5Nf1';    // ← исправлено

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$name = trim($_POST['user_name'] ?? '');
$phone = trim($_POST['user_phone'] ?? '');
$message = trim($_POST['user_message'] ?? '');

if ($name === '' || $phone === '') {
    echo 'Заполните все поля';
    exit;
}

$calcArea = trim($_POST['calc_area'] ?? '');
$calcType = trim($_POST['calc_type'] ?? '');
$calcPrice = trim($_POST['calc_price'] ?? '');
$calcCalculator = trim($_POST['is_calculator'] ?? '');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("INSERT INTO orders (user_name, user_phone, user_message, calc_area, calc_type, calc_price) 
        VALUES (:name, :phone, :message, :area, :type, :price)");
    $stmt->execute([
        'name' => $name,
        'phone' => $phone,
        'message' => $message ?: null,
        'area' => $calcArea ?: null,
        'type' => $calcType ?: null,
        'price' => $calcPrice ?: null
    ]);

    header('Location: index.html?success=1');
    exit;
    
} catch (PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
}
?>