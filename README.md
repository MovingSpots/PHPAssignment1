# PHPAssignment1 — Community Program Directory

A beginner PHP and MySQL application that lists fictional local community programs. It follows the Contact Manager pattern taught in MWD4A Assignment 1: create a database, connect with `database.php`, retrieve rows in `index.php`, and share the page layout through `header.php` and `footer.php`.

## Assignment rubric mapping

| Requirement | Where to find it |
| --- | --- |
| Git repository `PHPAssignment1` with GitHub origin | Git setup instructions below; create it in your own GitHub account |
| Database with fictional data | `sql/community_programs.sql` (one table, eight records) |
| Database connection | `database.php` (PDO connection) |
| Database error page | `database_error.php` |
| Display page | `index.php` |
| Shared header and footer | `header.php`, `footer.php` |
| Retrieve and display data | SQL `SELECT` and card loop in `index.php` |

## Requirements

- A computer with XAMPP (Apache, PHP, and MySQL or MariaDB) and phpMyAdmin.
- Visual Studio Code and Git.
- A GitHub account for submission.

## Windows setup with XAMPP

1. Extract this ZIP. Move the **inner `PHPAssignment1` folder** into `C:\xampp\htdocs\`. The result should be `C:\xampp\htdocs\PHPAssignment1\index.php`.
2. Open the XAMPP Control Panel. Start **Apache** and **MySQL**. Their rows should indicate that they are running.
3. In a browser open `http://localhost/phpmyadmin/`. Choose **Import**, select `C:\xampp\htdocs\PHPAssignment1\sql\community_programs.sql`, and click **Import/Go**. The script creates the `community_programs` database, `programs` table, and eight sample records. It can be imported again without duplicating those records.
4. In VS Code choose **File → Open Folder** and open `C:\xampp\htdocs\PHPAssignment1`.
5. Open `http://localhost/PHPAssignment1/`. You should see **8 programs available** and eight cards. Refresh to confirm the page still loads.

The project assumes the common local XAMPP MySQL account `root` with an empty password. If your local MySQL account has a password or uses a different username or port, edit the values in `database.php` locally. Do not put a real password in a public GitHub repository. For a course project, a local-only empty password should never be used for an internet-facing server.

If Apache uses another port, include that port in both URLs; for example, `http://localhost:8080/phpmyadmin/` and `http://localhost:8080/PHPAssignment1/`.

## How the PHP works

1. The browser requests `index.php` through Apache.
2. `index.php` loads `database.php`; PDO connects to the `community_programs` database.
3. A `SELECT` query reads the `programs` table and sorts by category and name.
4. `header.php` starts the HTML page. The loop in `index.php` renders one card per row. `footer.php` closes the page.
5. If the connection or query fails, the application logs technical details on the server and shows `database_error.php` to the visitor. Data is escaped with `htmlspecialchars` before insertion into HTML.

This assignment demonstrates read and display operations; it does not include add, edit, or delete screens because they are not part of the supplied Assignment 1 rubric. The `.sql` file is committed so the instructor can reproduce the database, but GitHub does not run PHP or MySQL by itself.

## Check your work

| Test | Expected result |
| --- | --- |
| Open `http://localhost/PHPAssignment1/` | 8 programs and the shared header/footer |
| Open phpMyAdmin → `community_programs` → `programs` → Browse | 8 fictional rows |
| Temporarily stop MySQL, refresh the app, then start it again | Friendly database error page, then normal listings |
| Change a program name in phpMyAdmin and refresh | Updated name appears, showing the app reads the database |

Do not use VS Code Live Server or open `index.php` as a `file://` page: PHP must run through Apache. If there is a database error, confirm MySQL is running, the import succeeded, and the account values in `database.php` match your local setup. If `localhost` cannot connect, check Apache and its port in XAMPP.

## Create the GitHub repository and submit

1. Sign in to GitHub as **MovingSpots**. Create a new **empty** repository named `PHPAssignment1`. Leave **Add a README**, **.gitignore**, and **license** unchecked because these files are already local. Choose Public if your instructor needs to open the link without access being granted.
2. In the VS Code terminal, opened at `C:\xampp\htdocs\PHPAssignment1`, run the commands below one line at a time:

   ```bash
   git init
   git branch -M main
   git add .
   git commit -m "Complete PHP and MySQL community program directory"
   git remote add origin https://github.com/MovingSpots/PHPAssignment1.git
   git push -u origin main
   ```

3. If Git asks for your identity, configure it and retry the commit:

   ```bash
   git config --global user.name "Selvaraj Thyagarajan"
   git config --global user.email "YOUR_GITHUB_EMAIL"
   ```

4. Visit `https://github.com/MovingSpots/PHPAssignment1` and verify that `index.php`, `database.php`, `database_error.php`, `header.php`, `footer.php`, and `sql/community_programs.sql` appear. Check that **Settings → General** displays the correct visibility for the instructor. Send your instructor `https://github.com/MovingSpots/PHPAssignment1.git` via Teams or email.

If the remote already exists, inspect `git remote -v` before changing it. If you initialized the GitHub repository with its own README and Git reports a non-fast-forward push, do not force push; the simplest clean route is to start with an empty repository, or pull and resolve the differing history with care.

### Suggested submission message

> Dear Professor Jasper,  
> I have completed Assignment 1 for MWD4A (PHP and MySQL Development). My Community Program Directory includes the database script, PHP database connection and error page, shared header and footer, and a page that retrieves and displays fictional program records.  
> Repository: https://github.com/MovingSpots/PHPAssignment1.git  
> Thank you,  
> Selvaraj Thyagarajan

## File layout

```text
PHPAssignment1/
├── .gitignore
├── README.md
├── database.php
├── database_error.php
├── footer.php
├── header.php
├── index.php
├── styles.css
└── sql/
    └── community_programs.sql
```
