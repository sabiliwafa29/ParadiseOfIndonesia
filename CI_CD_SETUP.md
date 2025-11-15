# GitHub Actions CI/CD Setup

## Overview

This project uses GitHub Actions to automate testing, linting, security checks, and deployment. The workflows ensure code quality, security, and reliability with every push and pull request.

## Workflows

### 1. Test & Lint (`test.yml`)

Runs on every push and pull request to `main` and `dbparadise` branches.

**Jobs:**

- **test**: Full test suite with PostgreSQL and Redis
  - Validates `composer.json` and `composer.lock`
  - Caches Composer dependencies for faster builds
  - Installs dependencies with `composer install`
  - Generates `.env` from `.env.example`
  - Generates application key
  - Runs database migrations on test PostgreSQL instance
  - Executes all PHPUnit tests
  - Generates code coverage report
  - Uploads coverage to Codecov

  **Environment:**
  - PHP 8.2
  - PostgreSQL 15 (test database)
  - Redis 7 (for caching and sessions)
  - GD extension (for image processing tests)
  - Xdebug (for code coverage)

- **lint**: Code style and syntax validation
  - Validates composer configuration
  - Runs Pint (Laravel code style fixer) in test mode
  - Performs PHP syntax check on all app and route files
  - Validates `composer.json` for conflicts

- **migrations**: Database migration verification
  - Runs migrations on a fresh test database
  - Verifies all migrations complete successfully
  - Checks migration status

### 2. Deploy to Production (`deploy.yml`)

Runs only on pushes to the `main` branch after all tests pass.

**Process:**
1. Checks out code
2. Sets up PHP 8.2
3. Installs Composer dependencies (production optimized)
4. Builds frontend assets with npm
5. Deploys via SSH to hosting provider
6. Runs post-deployment commands:
   - `git pull origin main`
   - `composer install --no-dev`
   - `php artisan migrate --force`
   - `php artisan cache:clear`
   - `php artisan config:cache`
7. Notifies Slack of success/failure

**Required Secrets:**
- `DEPLOY_KEY`: Private SSH key for deployment user
- `DEPLOY_HOST`: Deployment server hostname
- `DEPLOY_USER`: SSH user for deployment
- `DEPLOY_PATH`: Path to app on server
- `SLACK_WEBHOOK_URL`: Slack webhook for notifications

### 3. Security Checks (`security.yml`)

Runs on push/PR to both branches and daily at 2 AM UTC.

**Jobs:**

- **security**: General security scanning
  - Composer vulnerability audit
  - Laravel static analysis with PHPStan (level 6)
  - Scans for unsafe PHP functions (exec, eval, etc.)
  - Checks for hardcoded credentials
  - Verifies CSRF tokens in Blade templates

- **dependency-check**: Snyk dependency scanning
  - Scans dependencies for known vulnerabilities
  - Uses Snyk security database
  - Filters high-severity issues
  - Uploads results to GitHub Security tab

**Required Secrets:**
- `SNYK_TOKEN`: Snyk API token (optional, but recommended)

## GitHub Secrets Configuration

To enable the deployment and security workflows, configure these GitHub Secrets:

1. Go to: **Settings → Secrets and variables → Actions**

2. Add the following secrets:

### Deployment Secrets
```
DEPLOY_KEY          → Content of ~/.ssh/deploy_key (private key)
DEPLOY_HOST         → your-server.com
DEPLOY_USER         → deploy-user
DEPLOY_PATH         → /var/www/paradise-of-indonesia
SLACK_WEBHOOK_URL   → https://hooks.slack.com/services/T00000000/B00000000/...
```

### Security Secrets
```
SNYK_TOKEN          → Your Snyk API token from https://app.snyk.io/settings/api
```

## Local Setup

To test workflows locally or troubleshoot, you can use `act`:

```bash
# Install act (CLI tool to run GitHub Actions locally)
# macOS: brew install act
# Linux: Check https://github.com/nektos/act#installation
# Windows: choco install act-cli

# Run test workflow
act push -j test

# Run lint workflow
act push -j lint

# View available jobs
act --list
```

## Workflow Status

Check workflow status in GitHub UI:
1. Go to your repository
2. Click **Actions** tab
3. Select workflow to view runs
4. Click on a specific run to see logs

## Environment Variables

The workflows use these environment variables configured in CI:

| Variable | Test Value | Production Value |
|----------|-----------|-----------------|
| `DB_CONNECTION` | pgsql | pgsql |
| `DB_HOST` | 127.0.0.1 | ${{ secrets.DB_HOST }} |
| `DB_DATABASE` | paradise_db_test | paradise_db |
| `CACHE_DRIVER` | redis | redis |
| `SESSION_DRIVER` | redis | redis |
| `APP_ENV` | testing | production |
| `LOG_CHANNEL` | stderr | single |

**Note:** Production environment variables should be set in your hosting provider's control panel or environment configuration.

## Troubleshooting

### Tests fail with database connection error
- Ensure PostgreSQL service is running in CI
- Check database credentials in workflow match test setup
- Verify database exists before migrations run

### Deployment fails with SSH error
- Verify `DEPLOY_KEY` is a valid private SSH key
- Ensure deployment user has SSH access to server
- Check `DEPLOY_HOST` and `DEPLOY_PATH` are correct
- Verify firewall allows SSH connections

### Pint linting fails
- Run locally: `vendor/bin/pint` to fix auto-fixable issues
- Commit changes: `git add . && git commit -m "Apply Pint formatting"`
- Push again to rerun workflow

### Coverage upload fails
- Codecov token optional; workflow continues on failure
- To enable: Add `CODECOV_TOKEN` secret to GitHub
- Coverage reports still available in artifact

## Best Practices

1. **Always create branches for features:**
   ```bash
   git checkout -b feature/my-feature
   ```

2. **Run tests locally before pushing:**
   ```bash
   php artisan test
   vendor/bin/pint --test
   ```

3. **Use meaningful commit messages:**
   ```
   fix: resolve image upload validation issue
   feat: add responsive image derivatives
   docs: update deployment guide
   ```

4. **Monitor test failures:**
   - GitHub sends email notifications for workflow failures
   - Check Actions tab regularly for status
   - Review logs to understand failures

5. **Keep dependencies updated:**
   - Composer audit runs daily
   - Address vulnerabilities promptly
   - Use `composer outdated` to check for updates

## Continuous Integration Flow

```
Developer Push
    ↓
GitHub Actions Triggered
    ├─ Lint & Style Check (Pint, PHP syntax)
    ├─ Unit & Feature Tests (PHPUnit)
    ├─ Database Migrations (Flyway)
    └─ Security Scan (Composer audit, Snyk)
         ↓
    All checks pass?
         ├─ Yes → Merge allowed, Deploy to main triggers production deployment
         └─ No → Block merge, Show error logs to developer
```

## Future Enhancements

- [ ] Add API contract testing (OpenAPI/Swagger)
- [ ] Performance regression testing (load tests on staging)
- [ ] Automated dependency updates (Dependabot)
- [ ] Mobile app builds (Flutter/React Native if applicable)
- [ ] Database backup before deployment
- [ ] Smoke tests on production after deployment
- [ ] Rollback automation on deployment failure

## Support

For CI/CD issues:
1. Check [GitHub Actions documentation](https://docs.github.com/en/actions)
2. Review workflow logs in Actions tab
3. Test locally with `act` tool
4. Check for environment variable misconfigurations
5. Verify all required secrets are set

## Related Documentation

- [IMAGE_PIPELINE.md](../IMAGE_PIPELINE.md) - Image optimization and CDN setup
- [SESSION_AND_DEPLOYMENT.md](../SESSION_AND_DEPLOYMENT.md) - Session management and deployment
- [.github/workflows/test.yml](.github/workflows/test.yml) - Test workflow details
- [.github/workflows/deploy.yml](.github/workflows/deploy.yml) - Deployment workflow details
- [.github/workflows/security.yml](.github/workflows/security.yml) - Security checks details
