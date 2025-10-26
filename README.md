# FortiPass - Password Manager Application

**⚠️ IMPORTANT: Educational/CTF Use Only**

This project is designed for educational and CTF (Capture The Flag) training purposes only. It contains intentional vulnerabilities and should never be used in production environments.

## Local Development Setup

### Prerequisites
- Docker
- Docker Compose

### Running the Application
1. Clone this repository
2. Run the following command:
```bash
docker compose up
```
3. Access the application at `http://localhost:8080`

### Seed Credentials
- Email: user@example.com
- Password: password123

## Vulnerability Documentation

This application contains the following intentional vulnerabilities for educational purposes:

1. **XML External Entity (XXE) Injection**
   - Location: Password import feature
   - PoC Hint: Try uploading a specially crafted XML file with external entity references

2. **SQL Injection**
   - Location: Password search functionality
   - PoC Hint: The search parameter is vulnerable to SQL injection via the 'q' GET parameter

3. **Unrestricted File Upload**
   - Location: Profile picture upload
   - PoC Hint: Try uploading a .phtml file as your profile picture

4. **Directory Listing**
   - Location: /uploads/profile_images/
   - PoC Hint: Direct browser access to the uploads directory is possible

5. **Server-Side Template Injection**
   - Location: Add Password form (name field)
   - PoC Hint: The name field is vulnerable to template injection attacks

6. **Stored XSS**
   - Location: Login History (User-Agent)
   - PoC Hint: Custom User-Agent headers are stored and displayed without sanitization

## ⚠️ Security Notice

- This application is intentionally vulnerable
- Run ONLY in isolated, local development environments
- NEVER deploy to production or expose to the internet
- All vulnerabilities are marked with `// INTENTIONAL VULN:` comments in the code

## Project Structure

```
.
├── src/
│   ├── uploads/
│   │   └── profile_images/    # Profile image uploads
│   └── backups/              # Backup files
├── docker-compose.yml        # Docker configuration
├── Dockerfile               # PHP Apache configuration
└── init.sql                # Database initialization
```

## Safety Considerations

This application:
- Is designed to run locally only
- Contains no external network callbacks
- Includes no analytics or telemetry
- All resources are served locally

## License

This project is for educational purposes only. Use responsibly in controlled environments.