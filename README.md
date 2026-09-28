# PHPAssignment1 — Community Program Directory

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

