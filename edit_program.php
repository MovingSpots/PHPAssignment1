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
    $categories = fetchCategories($db);
    $statement = $db->prepare('SELECT * FROM programs WHERE program_id = :program_id');
    $statement->execute(['program_id' => $programId]);
    $program = $statement->fetch();
} catch (PDOException $exception) {
    error_log('Edit lookup: ' . $exception->getMessage());
    http_response_code(500);
    require __DIR__ . '/database_error.php';
    exit;
}

if ($program === false) {
    http_response_code(404);
    exit('Program not found.');
}

$currentImage = $program['image_filename'];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = $_POST;
    if (!verifyCsrfToken((string) ($_POST['csrf_token'] ?? ''))) {
        $errors[] = 'Your form session expired. Please try again.';
    }
    $errors = array_merge($errors, validateProgram($submitted, $categories));
    $newImage = null;

    if ($errors === []) {
        try {
            $newImage = saveUploadedImage($_FILES['image'] ?? []);
            $removeImage = isset($_POST['remove_image']);
            $finalImage = $newImage ?? ($removeImage ? null : $currentImage);
            $statement = $db->prepare(
                'UPDATE programs
                 SET program_name = :program_name, category_id = :category_id,
                     location = :location, schedule = :schedule,
                     contact_email = :contact_email, description = :description,
                     image_filename = :image_filename
                 WHERE program_id = :program_id'
            );
            $statement->execute([
                'program_name' => trim((string) $submitted['program_name']),
                'category_id' => (int) $submitted['category_id'],
                'location' => trim((string) $submitted['location']),
                'schedule' => trim((string) $submitted['schedule']),
                'contact_email' => trim((string) $submitted['contact_email']),
                'description' => trim((string) $submitted['description']),
                'image_filename' => $finalImage,
                'program_id' => $programId,
            ]);
            if (($newImage !== null || $removeImage) && $currentImage !== null) {
                deleteUploadedImage($currentImage);
            }
            redirectWithMessage('Program updated successfully.');
        } catch (RuntimeException $exception) {
            $errors[] = $exception->getMessage();
        } catch (PDOException $exception) {
            deleteUploadedImage($newImage);
            error_log('Update program: ' . $exception->getMessage());
            $errors[] = 'The program could not be updated. Please try again.';
        }
    }
    $program = array_merge($program, $submitted);
}

$pageTitle = 'Edit program';
$formAction = 'edit_program.php?id=' . $programId;
$submitLabel = 'Save Changes';
require __DIR__ . '/header.php';
?>
<main class="container narrow">
    <section class="page-heading">
        <p class="eyebrow">Update</p>
        <h1>Edit community program</h1>
        <p>Change the information or replace the program image.</p>
    </section>
    <?php require __DIR__ . '/program_form.php'; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
