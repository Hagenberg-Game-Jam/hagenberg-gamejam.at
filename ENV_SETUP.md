# Environment Configuration Setup

This project uses `.env` files to configure the environment. There are three templates:

## Available `.env` files

1. **`.env.example`** - Base template (default: localhost:8080)
2. **`.env.local`** - Local development with Herd (`hagenberg-gamejam.at.test`)
3. **`.env.production`** - Production (`https://hagenberg-gamejam.at`)

## Usage

### Local development (Herd)

```bash
# Copy the local configuration
cp .env.local .env

# Or on Windows PowerShell:
Copy-Item .env.local .env
```

### Production

```bash
# Copy the production configuration
cp .env.production .env

# Or on Windows PowerShell:
Copy-Item .env.production .env
```

### After copying

After creating the `.env` file, rebuild the site:

```bash
php hyde build
```

## Important configuration values

- **SITE_URL**: The base URL of your website
  - Local: `http://hagenberg-gamejam.at.test`
  - Production: `https://hagenberg-gamejam.at`

- **SITE_NAME**: The name of the website (used in meta tags)

## Note

The `.env` file is listed in `.gitignore` and is not committed to the repository. Make sure you use the correct `.env` file for your environment.

