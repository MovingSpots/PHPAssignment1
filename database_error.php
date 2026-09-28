<?php
declare(strict_types=1);

$pageTitle = 'Database unavailable';
require __DIR__ . '/header.php';
?>
<main class="container">
    <section class="notice" role="alert">
        <h1>We could not load the programs</h1>
        <p>Please make sure Apache and MySQL are running and the sample database has been imported, then refresh this page.</p>
        <a class="button" href="index.php">Try again</a>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
