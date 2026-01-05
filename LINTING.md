# Linting & Code Quality

This project uses **Laravel Pint** (Code Style) and **PHPStan** (Static Analysis) for code quality.

## CLI Commands

### Code Style (Pint)

```bash
# Check code style (without making changes)
composer lint

# Automatically fix code style
composer lint:fix
```

### Static Analysis (PHPStan)

```bash
# Analyze code
composer analyse
```

### Run Both

```bash
# Run both tools
composer test
```

## Automation

### 1. Git Pre-Commit Hook (Recommended)

Automatic linting before each commit. Prevents committing code with style issues.

#### Installation

Create `.git/hooks/pre-commit`:

```bash
#!/bin/sh
# Pre-commit hook for automatic linting

echo "Running Pint..."
composer lint:fix

echo "Running PHPStan..."
composer analyse

# If PHPStan finds errors, stop the commit
if [ $? -ne 0 ]; then
    echo "❌ PHPStan found errors. Commit aborted."
    exit 1
fi

echo "✅ All checks passed!"
```

**Windows (PowerShell):**

Create `.git/hooks/pre-commit.ps1`:

```powershell
# Pre-commit hook for automatic linting

Write-Host "Running Pint..." -ForegroundColor Cyan
composer lint:fix

Write-Host "Running PHPStan..." -ForegroundColor Cyan
composer analyse

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ PHPStan found errors. Commit aborted." -ForegroundColor Red
    exit 1
}

Write-Host "✅ All checks passed!" -ForegroundColor Green
```

**Activation:**

```bash
# Unix/Mac
chmod +x .git/hooks/pre-commit

# Windows (PowerShell)
# Git will automatically recognize .ps1 files
```

#### Alternative: Husky (Node.js)

If you use Node.js, you can use [Husky](https://typicode.github.io/husky/):

```bash
npm install --save-dev husky
npx husky init
```

Then create `.husky/pre-commit`:

```bash
#!/usr/bin/env sh
. "$(dirname -- "$0")/_/husky.sh"

composer lint:fix
composer analyse
```

### 2. CI/CD Integration

#### GitHub Actions

Create `.github/workflows/lint.yml`:

```yaml
name: Lint & Analyze

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  lint:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v4
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: mbstring, xml, ctype, iconv, intl, pdo, pdo_sqlite
          coverage: none
      
      - name: Install Composer Dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader
      
      - name: Run Pint
        run: composer lint
      
      - name: Run PHPStan
        run: composer analyse
```

#### GitLab CI

Create `.gitlab-ci.yml` (or add to existing):

```yaml
lint:
  stage: test
  image: php:8.2-cli
  before_script:
    - apt-get update -qq && apt-get install -y -qq git unzip
    - curl -sS https://getcomposer.org/installer | php
    - php composer.phar install --no-interaction --prefer-dist --optimize-autoloader
  script:
    - composer lint
    - composer analyse
  only:
    - merge_requests
    - main
    - develop
```

### 3. IDE Integration

#### VS Code

Install the extensions:
- **PHP Intelephense** or **PHP Intelephense**
- **PHPStan** (VS Code extension)

Create `.vscode/settings.json`:

```json
{
    "php.validate.enable": true,
    "php.validate.executablePath": "php",
    "phpstan.enabled": true,
    "phpstan.configPath": "phpstan.neon",
    "editor.formatOnSave": true,
    "editor.codeActionsOnSave": {
        "source.fixAll": "explicit"
    },
    "[php]": {
        "editor.defaultFormatter": "open-southeners.laravel-pint"
    }
}
```

#### PhpStorm

1. **Pint Integration:**
   - Settings → Tools → External Tools
   - Add Tool:
     - Name: `Laravel Pint`
     - Program: `vendor/bin/pint`
     - Arguments: `$FilePath$`
     - Working directory: `$ProjectFileDir$`

2. **PHPStan Integration:**
   - Settings → Languages & Frameworks → PHP → Quality Tools → PHPStan
   - PHPStan executable: `vendor/bin/phpstan`
   - Configuration file: `phpstan.neon`

### 4. EditorConfig

Create `.editorconfig` for consistent formatting:

```ini
root = true

[*]
charset = utf-8
end_of_line = lf
insert_final_newline = true
trim_trailing_whitespace = true

[*.php]
indent_style = space
indent_size = 4

[*.blade.php]
indent_style = space
indent_size = 4

[*.{js,json,yml,yaml}]
indent_style = space
indent_size = 2
```

### 5. Makefile (Optional)

For simpler commands, create `Makefile`:

```makefile
.PHONY: lint lint-fix analyse test

lint:
	composer lint

lint-fix:
	composer lint:fix

analyse:
	composer analyse

test:
	composer test
```

Then you can simply use `make lint-fix` or `make test`.

## Configuration

### Pint (`pint.json`)

- **Preset:** `per` (PER-CS Standard)
- **Excludes:** `vendor`, `_site`, `node_modules`, `storage`, `bootstrap`
- **Finder:** Checks `app/`, `config/`, `resources/views/`, `_pages/`

### PHPStan (`phpstan.neon`)

- **Level:** 5 (medium-strict)
- **Includes:** Larastan Extension for Laravel-specific features
- **Paths:** `app/`, `config/`
- **Excludes:** `vendor`, `_site`, `node_modules`, `storage`, `bootstrap`

## Tips

1. **Run regularly:** Execute `composer lint:fix` before each commit
2. **Adjust level:** PHPStan level can be adjusted in `phpstan.neon` (0-9)
3. **Ignore:** Specific errors can be ignored in `phpstan.neon` under `ignoreErrors`
4. **Incremental:** PHPStan can be optimized for large projects with `--memory-limit=2G`
