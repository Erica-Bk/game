# ant grid — PHP MVC login demo

## Structure
```
ant_grid/
├── index.php                 # entry point, redirects to views/login.php
├── login_process.php         # handles login form POST (calls AuthController)
├── register_process.php      # handles signup form POST
├── logout.php
├── config/
│   └── Database.php           # PDO connection (root/root, db "work")
├── models/
│   └── User.php                # queries against the `users` table
├── controllers/
│   └── AuthController.php     # login/register logic
├── views/
│   ├── login.php
│   ├── signin.php
│   └── home.php                # your supplied design, protected by session
└── sql/
    └── create_tables.sql
```

## Setup (XAMPP / WAMP / MAMP example)
1. Copy the `ant_grid` folder into your server's document root, e.g.
   `C:\xampp\htdocs\ant_grid` or `/Applications/MAMP/htdocs/ant_grid`.
2. Start Apache + MySQL.
3. Open phpMyAdmin (or the mysql CLI) and run `sql/create_tables.sql`.
   This creates the `work` database and the `users` table.
4. Visit `http://localhost/ant_grid/index.php` in your browser.

## Login flow
- `index.php` → redirects to `views/login.php`
- Submitting the login form posts to `login_process.php`, which uses
  `AuthController::login()`:
  - username **Erica** / password **mdp** → `views/home.php`
  - any other username/password checked against the `users` table
    (bcrypt-verified) → `views/home.php` on success
  - no match → `views/signin.php` to create an account
- `views/signin.php` posts to `register_process.php`, which inserts a
  new row into `users` (password stored with `password_hash()`), then
  sends you back to `views/login.php`.
- `logout.php` clears the session and returns to the login page.

## Notes
- Passwords for newly registered users are hashed with `password_hash()`
  / verified with `password_verify()` — never stored in plain text.
- The `Erica` / `mdp` shortcut is intentionally hardcoded in
  `AuthController::login()` per the spec; it does not need a DB row.
- `views/home.php` checks `$_SESSION['user']` and bounces back to the
  login page if you're not authenticated.
