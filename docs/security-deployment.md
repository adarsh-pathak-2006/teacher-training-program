# Security Deployment Manual (Production Launch)

Because this platform is currently running in a local Windows environment (`Local Sites`), certain operating-system-level security configurations cannot be executed. 

**The absolute moment you deploy this site to a live Linux server (e.g., Ubuntu/Nginx on AWS, DigitalOcean, or Hostinger), you MUST execute the following instructions.**

---

## 1. File Permissions Lockdown
By default, some migration tools restore WordPress files with excessively loose permissions (like `777`), which allows hackers to inject malicious code into your server.

Access your server via SSH, navigate to your `public_html` (or `htdocs`) root directory, and execute these exact commands to lock down the file structure:

```bash
# 1. Reset ownership to the web server user (usually www-data)
chown -R www-data:www-data .

# 2. Set all directories to 755 (Owner can read/write/execute, others can only read/execute)
find . -type d -exec chmod 755 {} \;

# 3. Set all files to 644 (Owner can read/write, others can only read)
find . -type f -exec chmod 644 {} \;

# 4. CRITICAL: Lock down wp-config.php so ONLY the server can read it (600 or 400)
chmod 600 wp-config.php

# 5. Lock down the .htaccess file (if using Apache)
chmod 644 .htaccess
```

---

## 2. Google reCAPTCHA v3 Integration
Wordfence currently handles Brute Force login protection, but to prevent automated bots from creating thousands of fake student accounts or spamming the contact forms, you must configure Google reCAPTCHA v3.

### Step 1: Generate Keys
1. Go to the [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin).
2. Register a new site. **You MUST select "reCAPTCHA v3"** (Invisible).
3. Copy your **Site Key** and **Secret Key**.

### Step 2: Secure the Registration Form (Ultimate Member)
1. Log into your WordPress Admin.
2. Navigate to **Ultimate Member > Settings > Extensions > Google reCAPTCHA**.
3. Paste your **Site Key** and **Secret Key**.
4. Set the Type to **v3**.
5. Enable it on the "Registration" form.

### Step 3: Secure the Contact Forms (Fluent Forms)
1. Navigate to **Fluent Forms > Global Settings > reCAPTCHA**.
2. Select **reCAPTCHA v3**.
3. Paste the keys and save.

---

## 3. Database Prefix Security (Optional but Recommended)
If your database tables currently begin with the default `wp_` prefix (e.g., `wp_users`), automated SQL injection bots can easily guess your table structure.

Before going live, use a plugin like **Brozzme DB Prefix** or manually run SQL queries to change the prefix to something randomized (e.g., `ttp_u8v2_users`). *Note: If you do this manually, you must also update the `$table_prefix` variable in `wp-config.php` and update the `wp_options` and `wp_usermeta` tables where the old prefix is hardcoded in specific rows.*

---

## What is Already Active?
The following security measures are **already active and permanently hardcoded** into your platform via the `mu-plugins/ttp-security.php` script:
*   **Web Application Firewall**: Wordfence is active.
*   **Automated Backups**: UpdraftPlus is active.
*   **Strict Security Headers**: (HSTS, X-Frame-Options, X-Content-Type-Options) are forcefully injected into every request.
*   **XML-RPC Disabled**: The biggest vector for WordPress DDoS attacks is permanently disabled.
*   **Author Enumeration Blocked**: Hackers cannot guess your admin usernames.
*   **WP Generator Hidden**: Hackers cannot see what version of WordPress you are running.
