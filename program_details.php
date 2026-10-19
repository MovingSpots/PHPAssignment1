<?php
declare(strict_types=1);

require __DIR__ . '/database.php';
require __DIR__ . '/functions.php';

$programId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($programId === null || $programId === false || $programId < 1) {
    http_response_code(400);
    exit('A valid program ID is required.');
}

try {
    $statement = $db->prepare(
        'SELECT p.program_id, p.program_name, p.location, p.schedule,
                p.contact_email, p.description, p.image_filename,
                c.category_name
         FROM programs AS p
         INNER JOIN categories AS c ON p.category_id = c.category_id
         WHERE p.program_id = :program_id'
    );
    $statement->execute(['program_id' => $programId]);
    $program = $statement->fetch();
} catch (PDOException $exception) {
    error_log('Program details: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

if ($program === false) {
    http_response_code(404);
    $pageTitle = 'Program not found';
    require __DIR__ . '/header.php';
    ?>
    <main class="container narrow">
        <section class="notice" role="alert">
            <h1>Program not found</h1>
            <p>The requested program may have been deleted.</p>
            <a class="button" href="index.php">Return to Programs</a>
        </section>
    </main>
    <?php
    require __DIR__ . '/footer.php';
    exit;
}

$pageTitle = $program['program_name'];
require __DIR__ . '/header.php';
?>
<main class="container details-container">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="index.php">Programs</a><span aria-hidden="true">/</span><span>Details</span></nav>

    <article class="details-card">
        <div class="details-visual">
            <?php if (!empty($program['image_filename'])): ?>
                <img src="uploads/<?= escapeHtml($program['image_filename']) ?>" alt="<?= escapeHtml($program['program_name']) ?>">
            <?php else: ?>
                <div class="details-placeholder" aria-hidden="true">Community Program</div>
            <?php endif; ?>
        </div>

        <div class="details-content">
            <span class="category"><?= escapeHtml($program['category_name']) ?></span>
            <h1><?= escapeHtml($program['program_name']) ?></h1>
            <p class="details-description"><?= nl2br(escapeHtml($program['description'])) ?></p>

            <dl class="details-list">
                <div><dt>Location</dt><dd><?= escapeHtml($program['location']) ?></dd></div>
                <div><dt>Schedule</dt><dd><?= escapeHtml($program['schedule']) ?></dd></div>
                <div><dt>Contact</dt><dd><a href="mailto:<?= escapeHtml($program['contact_email']) ?>"><?= escapeHtml($program['contact_email']) ?></a></dd></div>
                <div><dt>Program ID</dt><dd><?= (int) $program['program_id'] ?></dd></div>
            </dl>

            <div class="actions">
                <a class="button" href="edit_program.php?id=<?= (int) $program['program_id'] ?>">Edit Program</a>
                <a class="button button-secondary" href="index.php">Back to Programs</a>
            </div>
        </div>
    </article>
</main>
<?php require __DIR__ . '/footer.php'; ?>
