<?php
declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Community Program Directory';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore fictional local community programs.">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> | Community Program Directory</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="brand" href="index.php">Community Program Directory</a>
            <span class="tagline">A PHP &amp; MySQL class project</span>
        </div>
    </header>
