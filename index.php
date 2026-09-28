<?php
declare(strict_types=1);

require __DIR__ . '/database.php';

try {
    $statement = $db->query(
        'SELECT program_id, program_name, category, location, schedule, contact_email, description
         FROM programs
         ORDER BY category ASC, program_name ASC'
    );
    $programs = $statement->fetchAll();
} catch (PDOException $exception) {
    error_log('Community Program Directory query: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

function escapeHtml(string $text): string
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$pageTitle = 'Browse programs';
require __DIR__ . '/header.php';
?>
<main class="container">
    <section class="intro" aria-labelledby="page-heading">
        <p class="eyebrow">Find something new</p>
        <h1 id="page-heading">Programs for every interest</h1>
        <p>Explore the sample programs below. The listings are read from the MySQL database each time this page loads.</p>
        <p class="count"><?= count($programs) ?> <?= count($programs) === 1 ? 'program' : 'programs' ?> available</p>
    </section>

    <?php if ($programs === []): ?>
        <p class="empty">There are no programs yet. Import <code>sql/community_programs.sql</code> in phpMyAdmin.</p>
    <?php else: ?>
        <section class="cards" aria-label="Community programs">
            <?php foreach ($programs as $program): ?>
                <article class="card">
                    <span class="category"><?= escapeHtml($program['category']) ?></span>
                    <h2><?= escapeHtml($program['program_name']) ?></h2>
                    <p class="description"><?= escapeHtml($program['description']) ?></p>
                    <dl>
                        <div><dt>Where</dt><dd><?= escapeHtml($program['location']) ?></dd></div>
                        <div><dt>When</dt><dd><?= escapeHtml($program['schedule']) ?></dd></div>
                        <div><dt>Contact</dt><dd><a href="mailto:<?= escapeHtml($program['contact_email']) ?>"><?= escapeHtml($program['contact_email']) ?></a></dd></div>
                    </dl>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
