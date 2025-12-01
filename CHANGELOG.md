# Changelog

## 1.2.0 (2025-01-XX) - CodeCanyon Ready
- **Security Enhancements**:
  - Added comprehensive security configuration
  - Implemented security headers (X-Frame-Options, CSP, etc.)
  - Added rate limiting protection
  - Enhanced file upload validation
  - Secure session management
  - Protected sensitive directories and files
- **Configuration**:
  - Added .env.example file for easy setup
  - Removed hardcoded credentials from config
  - Added environment variable support
- **Documentation**:
  - Added detailed INSTALLATION.md guide
  - Updated README with better instructions
  - Added security recommendations
- **Code Quality**:
  - Disabled debug mode in production files
  - Improved error handling
  - Enhanced CORS configuration
  - Better file organization

## 1.1.0 (2025-09-11)
- Security: Migrated all SQL to PDO prepared statements
- Auth: password_hash/password_verify with md5 fallback + auto-rehash
- Config: Optional .env loader for DB configuration
- Docs: Added README, LICENSE, CHANGELOG

## 1.0.0
- Initial release
