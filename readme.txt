
Simple Helpdesk Web App (PHP + MySQL)

How to use:
1. Place the project folder in your web server's document root (e.g., XAMPP htdocs).
2. Create a MySQL user or use root with blank password. Update db.php credentials if needed.
3. Import the SQL file init_db.sql into your MySQL. Before importing, replace {PASSWORD_HASH} with a real hash:
   - To generate the password hash for 'admin123' you can use PHP:
     <?php echo password_hash('admin123', PASSWORD_DEFAULT); ?>
   or use the provided helper script.
4. Open login.php in browser. Default admin email: admin@example.com (password: admin123 if you used that hash).
5. Uploads are stored in uploads/ directory.

Notes:
- This is a minimal starter app. For production you must harden security (validate uploads, CSRF tokens, stronger auth).
