<?php
declare(strict_types=1);

require __DIR__ . '/database.php';
require __DIR__ . '/functions.php';

try {
    $statement = $db->query(
        'SELECT p.program_id, p.program_name, p.location, p.schedule,
                p.contact_email, p.description, p.image_filename,
                c.category_name
         FROM programs AS p
         INNER JOIN categories AS c ON p.category_id = c.category_id
         ORDER BY c.category_name ASC, p.program_name ASC'
    );
    $programs = $statement->fetchAll();
} catch (PDOException $exception) {
    error_log('Community Program Directory query: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

$pageTitle = 'Browse programs';
require __DIR__ . '/header.php';
?>
<main class="container">
    <?php if (isset($_GET['message'])): ?>
        <p class="flash" role="status"><?= escapeHtml((string) $_GET['message']) ?></p>
    <?php endif; ?>

    <section class="intro" aria-labelledby="page-heading">
        <p class="eyebrow">Find something new</p>
        <h1 id="page-heading">Programs for every interest</h1>
        <p>This page retrieves program information and its related category from two MySQL tables.</p>
        <p class="count"><?= count($programs) ?> <?= count($programs) === 1 ? 'program' : 'programs' ?> available</p>
    </section>

    <?php if ($programs === []): ?>
        <section class="empty">
            <h2>No programs yet</h2>
            <p>Add the first community program to the database.</p>
            <a class="button" href="add_program.php">Add Program</a>
        </section>
    <?php else: ?>
        <section class="cards" aria-label="Community programs">
            <?php foreach ($programs as $program): ?>
                <article class="card">
                    <?php if (!empty($program['image_filename'])): ?>
                        <img class="program-image" src="uploads/<?= escapeHtml($program['image_filename']) ?>" alt="<?= escapeHtml($program['program_name']) ?>">
                    <?php else: ?>
                        <div class="image-placeholder" aria-hidden="true">Community Program</div>
                    <?php endif; ?>
                    <div class="card-body">
                        <span class="category"><?= escapeHtml($program['category_name']) ?></span>
                        <h2><?= escapeHtml($program['program_name']) ?></h2>
                        <p class="description"><?= escapeHtml($program['description']) ?></p>
                        <dl>
                            <div><dt>Where</dt><dd><?= escapeHtml($program['location']) ?></dd></div>
                            <div><dt>When</dt><dd><?= escapeHtml($program['schedule']) ?></dd></div>
                            <div><dt>Contact</dt><dd><a href="mailto:<?= escapeHtml($program['contact_email']) ?>"><?= escapeHtml($program['contact_email']) ?></a></dd></div>
                        </dl>
                        <div class="actions">
                            <a class="button button-secondary" href="edit_program.php?id=<?= (int) $program['program_id'] ?>">Edit</a>
                            <a class="button button-danger-outline" href="delete_program.php?id=<?= (int) $program['program_id'] ?>">Delete</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
