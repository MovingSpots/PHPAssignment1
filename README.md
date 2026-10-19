# PHPAssignment1 Community Program Directory

## MWD4A PHP and MySQL Development Assignment 4

This project continues the same `PHPAssignment1` repository used for Assignments 1 and 2. Assignment 4 adds image preview before submission, improves image updating and removal, and adds a dedicated details page for each community program.

## Assignment 4 requirements

| Requirement | Implementation |
| --- | --- |
| Continue existing `PHPAssignment1` Git repository | The upgrade retains the original project name, database, CRUD pages, and Git origin |
| Image preview | `image-preview.js` previews a selected image before the add or edit form is submitted |
| Image update | `edit_program.php` and `program_form.php` display the saved image and allow replacement or removal |
| Details page | `program_details.php` retrieves one program and its related category using a prepared query and displays all information |
| Push changes to GitHub | Git instructions below commit Assignment 4 to the existing repository |

## What changed in Assignment 4

### New files

- `image-preview.js` handles instant client-side image preview, size/type feedback, replacement preview, and remove-image preview behaviour.
- `program_details.php` displays the selected program, category, large image, description, location, schedule, contact information, and program ID.

### Updated files

- `program_form.php` now contains the preview panel and loads the preview script.
- `index.php` now provides a **View Details** button for every program.
- `add_program.php` explains that the image can be previewed before saving.
- `edit_program.php` explains image replacement and removal.
- `styles.css` styles the preview panel and responsive details page.
- `README.md` documents Assignment 4 installation, testing, and submission.

## Project structure

```text
PHPAssignment1/
├── add_program.php
├── database.php
├── database_error.php
├── delete_program.php
├── edit_program.php
├── footer.php
├── functions.php
├── header.php
├── image-preview.js          Assignment 4
├── index.php
├── program_details.php       Assignment 4
├── program_form.php
├── styles.css
├── README.md
├── sql/
│   ├── full_setup_assignment2.sql
│   └── upgrade_assignment2.sql
└── uploads/
    ├── .gitkeep
    └── .htaccess
```

## How the new features work

### Image preview

The file input still uses the Assignment 2 upload form:

```html
<input type="file" accept="image/jpeg,image/png,image/gif,image/webp">
```

When an image is selected, `image-preview.js`:

1. Reads the selected browser file.
2. Checks that it is an image and no larger than 2 MB.
3. Creates a temporary browser URL with `URL.createObjectURL()`.
4. Displays the image before anything is uploaded.
5. Revokes the temporary URL when it is no longer needed.

The JavaScript preview improves usability, but it does not replace server validation. `functions.php` continues to verify the upload status, actual MIME type, size, extension mapping, and randomly generated server filename.

### Image update and removal

The Edit Program page initially previews the current saved image. The user can:

- Select a new image and preview the replacement immediately.
- Clear the file selection and return to the saved image.
- Select **Remove the current image when changes are saved**.
- Cancel without modifying the database or saved image.

After a successful update, PHP stores the new random filename in MySQL and deletes the replaced file. If the database update fails, the newly uploaded file is removed and the original image remains referenced.

### Program details page

The home page sends the program ID to:

```text
program_details.php?id=1
```

The details page validates the ID and uses a PDO prepared statement with an `INNER JOIN` between `programs` and `categories`. It returns a friendly 404 page if the record no longer exists. All displayed database text is escaped with `htmlspecialchars` through `escapeHtml()`.

## Install the Assignment 4 upgrade on macOS

### Protect your existing work

Before copying files, open Terminal inside the existing project and run:

```bash
git status
```

If it says `working tree clean`, download the newest GitHub history:

```bash
git pull origin main --no-rebase
```

If you have uncommitted work, commit it before pulling.

### Copy the upgraded project

1. Extract the Assignment 4 ZIP.
2. Back up your existing folder:

   ```text
   /Applications/XAMPP/xamppfiles/htdocs/PHPAssignment1
   ```

3. Copy the contents of the extracted `PHPAssignment1` folder into the existing XAMPP `PHPAssignment1` folder.
4. Choose **Replace** when macOS asks about matching project files.
5. Do not delete the hidden `.git` folder in your existing project.
6. Existing uploaded images can remain in `uploads/`; copying the upgrade does not require deleting them.

### Start and open the application

1. Start **Apache** and **MySQL** in XAMPP Manager.
2. Open:

   ```text
   http://localhost/PHPAssignment1/
   ```

No new SQL import is required if the Assignment 2 database is working. Assignment 4 uses the existing `community_programs` database, `programs.image_filename`, and `categories` relationship.

For a completely new installation only, import `sql/full_setup_assignment2.sql` through phpMyAdmin. That script resets the two project tables and their sample records.

## Complete Assignment 4 test checklist

### Test image preview while adding

1. Select **Add Program**.
2. Complete the required fields.
3. Choose a JPG, PNG, GIF, or WebP file under 2 MB.
4. Confirm that the picture appears in **Image preview** before submission.
5. Confirm that the selected filename is shown.
6. Submit the form and confirm that the image appears on the program card.

### Test image update

1. Select **Edit** for a program with an image.
2. Confirm that the current saved image appears in the preview panel.
3. Choose another image.
4. Confirm that the preview changes immediately.
5. Select **Save Changes**.
6. Confirm that the replacement appears on the home and details pages.

### Test image removal

1. Edit a program with an image.
2. Select **Remove the current image when changes are saved**.
3. Confirm that the preview reports that the image will be removed.
4. Save changes.
5. Confirm that the program displays the standard placeholder.

### Test the details page

1. Select **View Details** on a program card.
2. Confirm that the page displays the category, name, full description, location, schedule, email, program ID, and large image or placeholder.
3. Select **Edit Program** and confirm it opens the correct record.
4. Select **Back to Programs** and confirm it returns to the list.
5. Try `program_details.php?id=999999` and confirm the Program Not Found page appears.

### Test validation and accessibility

1. Select a file larger than 2 MB and confirm the preview status rejects it.
2. Try a non-image file and confirm it is not previewed.
3. Confirm the server also rejects an invalid upload if JavaScript is disabled.
4. Resize the browser and confirm the details page changes from two columns to one column.
5. Use the Tab key to confirm buttons, form controls, and links receive visible focus.

### macOS upload permission troubleshooting

If PHP reports that an otherwise valid image cannot be saved, open Terminal inside `PHPAssignment1` and, for this local XAMPP classroom project only, run:

```bash
chmod 777 uploads
```

Do not use permission `777` on a public production server.

## Commit and push to the existing GitHub repository

From the existing `PHPAssignment1` project terminal, verify the remote:

```bash
git status
git remote -v
```

The expected origin is:

```text
https://github.com/MovingSpots/PHPAssignment1.git
```

Commit Assignment 4:

```bash
git add .
git commit -m "Complete Assignment 4 image preview update and details page"
git push origin main
```

If `origin` is missing, add it:

```bash
git remote add origin https://github.com/MovingSpots/PHPAssignment1.git
```

If `origin` exists but has the wrong address:

```bash
git remote set-url origin https://github.com/MovingSpots/PHPAssignment1.git
```

Do not force-push. If Git reports a conflict, finish or abort the current merge before starting another pull.

Verify the uploaded files at:

```text
https://github.com/MovingSpots/PHPAssignment1
```

Submit:

```text
https://github.com/MovingSpots/PHPAssignment1.git
```

## Suggested submission message

Dear Professor Jasper,

I have completed MWD4A Assignment 4 by upgrading my existing PHPAssignment1 Community Program Directory. The application now provides image preview before submission, image replacement and removal during updates, and a dedicated responsive details page for each program.

Repository: https://github.com/MovingSpots/PHPAssignment1.git

Thank you,  
Selvaraj Thyagarajan
