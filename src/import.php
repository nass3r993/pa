<?php
require_once 'config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['import_file'])) {
    $file = $_FILES['import_file'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if ($ext === 'xml') {
        // INTENTIONAL VULN: XXE
        libxml_disable_entity_loader(false);
        $xml = file_get_contents($file['tmp_name']);
        
        $dom = new DOMDocument();
        $dom->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
        
        $xpath = new DOMXPath($dom);
        $passwords = $xpath->query('//password');
        
        foreach ($passwords as $password) {
            $name = $xpath->evaluate('string(./name)', $password);
            $username = $xpath->evaluate('string(./username)', $password);
            $pass = $xpath->evaluate('string(./value)', $password);
            $notes = $xpath->evaluate('string(./notes)', $password);

            $stmt = $pdo->prepare("INSERT INTO passwords (user_id, name, username, password, notes) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $name, $username, $pass, $notes]);
        }
    } else if ($ext === 'csv') {
        $handle = fopen($file['tmp_name'], 'r');
        
        // Skip header row
        fgetcsv($handle);
        
        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($data) >= 3) {
                $stmt = $pdo->prepare("INSERT INTO passwords (user_id, name, username, password, notes) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$_SESSION['user_id'], $data[0], $data[1], $data[2], $data[3] ?? '']);
            }
        }
        
        fclose($handle);
    }

    header('Location: passwords.php');
    exit();
}

header('Location: settings.php');
exit();