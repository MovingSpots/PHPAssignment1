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
        'SELECT p.program_id, p.program_name, p.image_filename, c.category_name
         FROM programs AS p
         INNER JOIN categories AS c ON p.category_id = c.category_id
         WHERE p.program_id = :program_id'
    );
    $statement->execute(['program_id' => $programId]);
    $program = $statement->fetch();
} catch (PDOException $exception) {
    error_log('Delete lookup: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

if ($program === false) {
    http_response_code(404);
    exit('Program not found.');
}

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $error = 'Your form session expired. Please try again.';
    } else {
        try {
            $statement = $db->prepare('DELETE FROM programs WHERE program_id = :program_id');
            $statement->execute(['program_id' => $programId]);
            deleteUploadedImage($program['image_filename']);
            redirectWithMessage('Program deleted successfully.');
        } catch (PDOException $exception) {
            error_log('Delete program: ' . $exception->getMessage());
            $error = 'The program could not be deleted. Please try again.';
        }
    }
}

$pageTitle = 'Delete program';
require __DIR__ . '/header.php';
?>
<main class="container narrow">
    <section class="confirm-box">
        <p class="eyebrow">Delete</p>
        <h1>Delete this program?</h1>
        <?php if ($error !== null): ?><p class="errors" role="alert"><?= escapeHtml($error) ?></p><?php endif; ?>
        <p>You are about to permanently delete <strong><?= escapeHtml($program['program_name']) ?></strong> from the <?= escapeHtml($program['category_name']) ?> category.</p>
        <p>This action cannot be undone.</p>
        <form action="delete_program.php?id=<?= $programId ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?= escapeHtml(csrfToken()) ?>">
            <div class="actions">
                <button class="button button-danger" type="submit">Yes, Delete Program</button>
                <a class="button button-secondary" href="index.php">Cancel</a>
            </div>
        </form>
    </section>
</main>
<?php require __DIR__ . '/footer.php'; ?>
