<?php
declare(strict_types=1);

require __DIR__ . '/database.php';
require __DIR__ . '/functions.php';

try {
    $categories = fetchCategories($db);
} catch (PDOException $exception) {
    error_log('Category query: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

$program = ['program_name' => '', 'category_id' => '', 'location' => '', 'schedule' => '', 'contact_email' => '', 'description' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $program = $_POST;
    if (!verifyCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Your form session expired. Please try again.';
    }
    $errors = array_merge($errors, validateProgram($program, $categories));
    $newImage = null;

    if ($errors === []) {
        try {
            $newImage = saveUploadedImage($_FILES['image'] ?? []);
            $statement = $db->prepare(
                'INSERT INTO programs
                    (program_name, category_id, location, schedule, contact_email, description, image_filename)
                 VALUES
                    (:program_name, :category_id, :location, :schedule, :contact_email, :description, :image_filename)'
            );
            $statement->execute([
                'program_name' => trim((string) $program['program_name']),
                'category_id' => (int) $program['category_id'],
                'location' => trim((string) $program['location']),
                'schedule' => trim((string) $program['schedule']),
                'contact_email' => trim((string) $program['contact_email']),
                'description' => trim((string) $program['description']),
                'image_filename' => $newImage,
            ]);
            redirectWithMessage('Program added successfully.');
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        } catch (PDOException $exception) {
            deleteUploadedImage($newImage);
            error_log('Add program: ' . $exception->getMessage());
            $errors[] = 'The program could not be added. Please try again.';
        }
    }
}

$pageTitle = 'Add a program';
$formAction = 'add_program.php';
$submitLabel = 'Add Program';
$currentImage = null;
require __DIR__ . '/header.php';
?>
<main class="container narrow">
    <section class="page-heading">
        <p class="eyebrow">Create</p>
        <h1>Add a community program</h1>
        <p>Complete the fields below. The new record will be saved to MySQL.</p>
    </section>
    <?php require __DIR__ . '/program_form.php'; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
