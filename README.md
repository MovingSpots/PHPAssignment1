# PHPAssignment1 — Community Program Directory

<<<<<<< HEAD
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

Dear Professor Jasper,

I have completed Assignment 2 for MWD4A — PHP and MySQL Development. I upgraded my Community Program Directory in the existing PHPAssignment1 repository. The application now supports adding, updating, and deleting records; uses a related categories table with a foreign key; and supports validated image uploads.

Repository: https://github.com/MovingSpots/PHPAssignment1.git

Thank you,  
Selvaraj Thyagarajan
=======
A beginner PHP and MySQL application that lists fictional local community programs. It follows the Contact Manager pattern taught in MWD4A Assignment 1: create a database, connect with `database.php`, retrieve rows in `index.php`, and share the page layout through `header.php` and `footer.php`.

## Assignment rubric mapping

| Requirement | Where to find it |
| --- | --- |
| Git repository `PHPAssignment1` with GitHub origin | (https://github.com/MovingSpots/PHPAssignment1.git) |
| Database with fictional data | `sql/community_programs.sql` (one table, eight records) |
| Database connection | `database.php` (PDO connection) |
| Database error page | `database_error.php` |
| Display page | `index.php` |
| Shared header and footer | `header.php`, `footer.php` |
| Retrieve and display data | SQL `SELECT` and card loop in `index.php` |

## How the PHP works

1. The browser requests `index.php` through Apache.
2. `index.php` loads `database.php`; PDO connects to the `community_programs` database.
3. A `SELECT` query reads the `programs` table and sorts by category and name.
4. `header.php` starts the HTML page. The loop in `index.php` renders one card per row. `footer.php` closes the page.
5. If the connection or query fails, the application logs technical details on the server and shows `database_error.php` to the visitor. Data is escaped with `htmlspecialchars` before insertion into HTML.

This assignment demonstrates read and display operations. The `.sql` file is committed so the instructor can reproduce the database, but GitHub does not run PHP or MySQL by itself.


> Dear Professor Jasper,  
> I have completed Assignment 1 for MWD4A (PHP and MySQL Development). My Community Program Directory includes the database script, PHP database connection and error page, shared header and footer, and a page that retrieves and displays fictional program records.  
> Repository: https://github.com/MovingSpots/PHPAssignment1.git  
> Thank you,  
> Selvaraj Thyagarajan

