# GitHub Packages Installation Guide

This Laravel MobilePay Vipps package is available on **GitHub Packages** as an alternative to Packagist.

## 🚀 Quick Installation

### Step 1: Add GitHub Packages Repository

Add the GitHub Packages repository to your project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mrdulal/Vipps-MobilePay.git"
        }
    ]
}
```

> **Note**: GitHub Packages for Composer repositories are primarily for private packages. For public packages like this one, using the VCS repository type is more appropriate.

### Step 2: Authenticate with GitHub

You need a GitHub Personal Access Token with `read:packages` scope.

#### Create Personal Access Token:
1. Go to GitHub Settings → Developer Settings → Personal Access Tokens → Tokens (classic)
2. Click "Generate new token (classic)"
3. Select scopes: `read:packages`
4. Copy the generated token

#### Configure Composer Authentication:
```bash
composer config github-oauth.github.com YOUR_GITHUB_TOKEN
```

Or add to your global composer config:
```bash
composer config --global github-oauth.github.com YOUR_GITHUB_TOKEN
```

### Step 3: Install Package

```bash
composer require mrdulal/laravel-vipps
```

## 🔧 Alternative Authentication Methods

### Using auth.json (Recommended for CI/CD)

Create an `auth.json` file in your project root:
```json
{
    "github-oauth": {
        "github.com": "YOUR_GITHUB_TOKEN"
    }
}
```

**Important**: Add `auth.json` to your `.gitignore` file!

### Environment Variable Authentication

Set the token as an environment variable:
```bash
export COMPOSER_AUTH='{"github-oauth":{"github.com":"YOUR_GITHUB_TOKEN"}}'
```

## 🐳 Docker Installation

For Docker environments, pass the token as a build argument:

```dockerfile
# Dockerfile
FROM php:8.2-fpm

ARG GITHUB_TOKEN
RUN composer config github-oauth.github.com ${GITHUB_TOKEN}
RUN composer require mrdulal/laravel-vipps
```

Build with:
```bash
docker build --build-arg GITHUB_TOKEN=your_token .
```

## 🚀 CI/CD Installation

### GitHub Actions

```yaml
- name: Configure GitHub Packages
  run: composer config github-oauth.github.com ${{ secrets.GITHUB_TOKEN }}

- name: Install package
  run: composer require mrdulal/laravel-vipps
```

### GitLab CI

```yaml
before_script:
  - composer config github-oauth.github.com $GITHUB_TOKEN
  - composer require mrdulal/laravel-vipps
```

## 📋 Version Constraints

You can specify version constraints as usual:

```bash
# Latest version
composer require mrdulal/laravel-vipps

# Specific version
composer require mrdulal/laravel-vipps:^1.1.0

# Development version
composer require mrdulal/laravel-vipps:dev-main
```

## 🆚 GitHub Packages vs Packagist

| Feature | GitHub Packages | Packagist |
|---------|----------------|-----------|
| **Authentication** | Required (GitHub token) | None required |
| **Availability** | Private/public repos | Public repos only |
| **Bandwidth** | GitHub's infrastructure | Global CDN |
| **Integration** | Native GitHub integration | Community standard |
| **Security** | GitHub's security model | Public access |

## 🔍 Troubleshooting

### Authentication Issues
```bash
# Check current auth configuration
composer config github-oauth.github.com

# Clear and reconfigure
composer config --unset github-oauth.github.com
composer config github-oauth.github.com NEW_TOKEN
```

### Package Not Found
Ensure the repository is added to your `composer.json`:
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mrdulal/Vipps-MobilePay.git"
        }
    ]
}
```

### Permission Denied
Verify your GitHub token has the `read:packages` scope and hasn't expired.

## 📚 Next Steps

After installation, follow the main [README.md](README.md) for:
- Configuration setup
- Environment variables
- Usage examples
- API documentation

## 🤝 Support

- **Issues**: [GitHub Issues](https://github.com/mrdulal/Vipps-MobilePay/issues)
- **Documentation**: [Main README](README.md)
- **Repository**: [GitHub Repository](https://github.com/mrdulal/Vipps-MobilePay)

---

**⚠️ Note**: This is an unofficial package developed independently by a solo developer.