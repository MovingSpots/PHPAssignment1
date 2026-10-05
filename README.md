# PHPAssignment1 — Community Program Directory

## MWD4A PHP and MySQL Development — Assignment 2

This project upgrades Assignment 1 into a complete CRUD application. Users can view, add, update, and delete fictional community programs. Each program belongs to a record in a related `categories` table and can have an uploaded image.

## Rubric mapping

| Requirement | Implementation |
| --- | --- |
| Continue existing `PHPAssignment1` Git repository | This upgrade is placed in the same project and pushed to the same GitHub origin |
| Add capability | `add_program.php` inserts a record with a prepared statement |
| Update capability | `edit_program.php` loads and updates the selected record |
| Delete capability | `delete_program.php` displays a confirmation and deletes through POST |
| Add second table | `categories` table in both Assignment 2 SQL scripts |
| Relate it to first table | `programs.category_id` foreign key references `categories.category_id` |
| Update application accordingly | `index.php` uses an `INNER JOIN`; forms use a category dropdown |
| Image upload | Add/edit forms accept JPG, PNG, GIF, and WebP files up to 2 MB |

## Project files

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
├── index.php
├── program_form.php
├── styles.css
├── sql/
│   ├── full_setup_assignment2.sql
│   └── upgrade_assignment2.sql
└── uploads/
    ├── .gitkeep
    └── .htaccess
```

## Database relationship

One category can have many programs, while each program has one category:

```text
categories                         programs
---------------------              -------------------------
category_id (PK)       1 ───────<  category_id (FK)
category_name                      program_id (PK)
                                   program_name
                                   location, schedule, email
                                   description, image_filename
```

The application uses this join to display the related category name:

```sql
FROM programs AS p
INNER JOIN categories AS c ON p.category_id = c.category_id
```

## Upgrade an existing Assignment 1 installation

1. Keep this folder named `PHPAssignment1` in XAMPP's `htdocs` folder.
   - macOS default: `/Applications/XAMPP/xamppfiles/htdocs/PHPAssignment1`
   - Windows default: `C:\xampp\htdocs\PHPAssignment1`
2. Start **Apache** and **MySQL** in XAMPP.
3. Open `http://localhost/phpmyadmin/`.
4. Before changing the schema, select `community_programs`, choose **Export**, use **Quick**, and save a backup.
5. Select the **Import** tab and import `sql/upgrade_assignment2.sql` exactly once.
6. Open `http://localhost/PHPAssignment1/`.

The upgrade script preserves the Assignment 1 program records. It copies the old text categories to the new `categories` table, connects each program using `category_id`, adds `image_filename`, creates the foreign key, and removes the old duplicate category text column.

Do not import the upgrade script a second time because the columns and foreign-key constraint will already exist.

### Clean-install alternative

If the Assignment 1 database does not exist, or you intentionally want to reset only the project tables, import `sql/full_setup_assignment2.sql`. **This script drops and recreates the `programs` and `categories` tables, so it removes records currently in those two tables.** It then inserts eight sample programs and eight categories.

## Database connection

`database.php` uses the common local XAMPP settings:

```text
host: 127.0.0.1
database: community_programs
username: root
password: empty
```

Change these values locally only if your XAMPP configuration differs. Never commit a real production password to GitHub.

## How to test every rubric feature

1. **Display and relationship:** Load the home page. Confirm that eight program cards and their category names appear.
2. **Add:** Select **Add Program**, complete the form, choose an image under 2 MB, and submit. Confirm that the new card and image appear.
3. **Database proof:** In phpMyAdmin, browse `programs`. Confirm that the new row contains a numeric `category_id` and generated `image_filename`. Browse `categories` to show the related category record.
4. **Update:** Select **Edit** on the new program. Change its name/category and optionally replace its image. Save and confirm the updated card.
5. **Delete:** Select **Delete**, review the confirmation, and choose **Yes, Delete Program**. Confirm that the card disappears.
6. **Validation:** Try submitting a blank field, an invalid email, a file larger than 2 MB, or a non-image file. Confirm that a helpful error appears.
7. **Error page:** Stop MySQL temporarily and refresh. Confirm that `database_error.php` appears, then restart MySQL.

If image upload works in PHP but reports that the file cannot be saved on macOS, Apache may not have write permission for `uploads`. For this local XAMPP classroom project only, open Terminal in the project and run `chmod 777 uploads`, retest the upload, and do not use that broad permission on a public server.

## How the image upload works

- The form uses `method="post"` and `enctype="multipart/form-data"`.
- PHP checks the upload status, size, and actual MIME type with `finfo`.
- The original filename is not trusted. A random server filename is generated.
- Only the generated filename is stored in MySQL; the file is saved in `uploads/`.
- Replaced and deleted images are removed from the upload folder.
- `uploads/.htaccess` blocks PHP-like scripts from executing in the upload directory when Apache allows local `.htaccess` rules.

## Additional implementation quality

- PDO prepared statements are used for insert, update, delete, and ID-based queries.
- Output is escaped with `htmlspecialchars`.
- Add, edit, and delete forms use CSRF tokens stored in the PHP session.
- Delete is completed by POST only and includes a confirmation page.
- Technical database messages are logged instead of shown to visitors.
- The layout is responsive and labels are connected to their form fields.

## Commit and push to the existing repository

Open the VS Code terminal inside `PHPAssignment1` and check the remote:

```bash
git status
git remote -v
```

The expected origin is:

```text
https://github.com/MovingSpots/PHPAssignment1.git
```

Then commit and push Assignment 2:

```bash
git add .
git commit -m "Complete Assignment 2 CRUD relationships and image upload"
git pull origin main --no-rebase
git push origin main
```

If `git pull` reports a conflict, resolve the named file in VS Code, save it, run `git add .`, make the merge commit, and push again. Do not use a force push.

Verify the result at `https://github.com/MovingSpots/PHPAssignment1` and submit:

```text
https://github.com/MovingSpots/PHPAssignment1.git
```

## Suggested message to Professor Jasper

Dear Professor Jasper,

I have completed Assignment 2 for MWD4A — PHP and MySQL Development. I upgraded my Community Program Directory in the existing PHPAssignment1 repository. The application now supports adding, updating, and deleting records; uses a related categories table with a foreign key; and supports validated image uploads.

Repository: https://github.com/MovingSpots/PHPAssignment1.git

Thank you,  
Selvaraj Thyagarajan
