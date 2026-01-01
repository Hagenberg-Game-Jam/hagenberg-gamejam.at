# Hagenberg Game Jam Website (HydePHP)

This repository contains the source for the **Hagenberg Game Jam** website, built with **HydePHP** (a Laravel-powered static site generator).

The site is **data-driven**: Jam year pages and individual game detail pages are generated automatically during the build from files in `_data/`.

## Requirements

### PHP + Composer

- **PHP**: 8.2+ (see `composer.json`)
- **Composer**: latest stable

**Easy option (recommended): Laravel Herd**

- Herd installs and manages PHP for you and works great on **Windows** and **macOS**.
- If you use Herd, you can either run Hyde’s dev server (`php hyde serve`) or serve the site through Herd using a custom driver.

Alternative options:

- Windows: install PHP via Herd, or via `winget`/Chocolatey, or manual install from `windows.php.net`.
- macOS: install PHP via Herd, Homebrew (`brew install php`), or similar.

### Node.js + npm

- **Node.js** (LTS recommended) and **npm**

Node is used for the frontend build pipeline (Vite + TailwindCSS + JS dependencies). You only need it when:

- You change CSS/JS assets, Tailwind config, or add new Tailwind utility classes used in templates.
- You want the live-reload frontend dev experience.

## Setup

1) Install PHP + Composer (see above)  
2) Install Node.js + npm  
3) Install PHP dependencies:

```bash
composer install
```

4) Install Node dependencies:

```bash
npm install
```

5) Environment configuration  
This project uses environment files for local vs production URLs and metadata. See `ENV_SETUP.md` for details.

## Development

### Option A: Hyde dev server (works everywhere)

```bash
php hyde serve
```

This starts Hyde’s local dev server (with the Hyde realtime compiler enabled in dev).

### Option B: Laravel Herd (no Hyde server needed)

If you have Herd set up with a custom driver for HydePHP, you can open the site directly via your Herd domain
(for example: `http://hagenberg-gamejam.at.test`) without running `php hyde serve`.

For the correct `.env` file to use with Herd, see `ENV_SETUP.md`.

### When do I need npm during development?

- If you only change content/data (YAML/Markdown), you can usually stick to `php hyde serve` (or Herd) without rebuilding assets.
- If you change styles/scripts or introduce new Tailwind classes, rebuild frontend assets:

```bash
npm run build
```

If you want a frontend dev watcher (Vite), you can run:

```bash
npm run dev
```

## Building the site

The static site output is generated into `_site/`:

```bash
php hyde build
```

### Automatic page generation (Jam years & games)

During `php hyde build`, a pre-build task generates pages automatically:

- For every Jam year file in `_data/jams/YYYY.yaml` a year overview page `YYYY.html` is generated.
- For every game entry in `_data/games/gamesYYYY.yaml` a game detail page under `YYYY/<game-slug>.html` is generated.

You do **not** need to create `_pages/` files for years/games. The build task is implemented in:

- `app/Actions/GenerateGameJamPagesBuildTask.php`

## Upgrading dependencies

### PHP (Composer) dependencies

Update packages:

```bash
composer update
```

If you want to upgrade HydePHP major versions, do it intentionally:

- Check `hyde/framework` constraints in `composer.json`
- Read Hyde’s upgrade notes in their docs/releases
- Run `php hyde build` afterwards and verify output

### Node dependencies

Update packages:

```bash
npm update
```

For more thorough upgrades (including major versions), consider using:

```bash
npx npm-check-updates -u
npm install
```

Then rebuild assets:

```bash
npm run build
```

## Content management (how to add/update a new Game Jam)

This project provides interactive Hyde commands to streamline adding new Game Jams and games. These commands handle image processing, file management, and YAML generation automatically.

### Quick start: Using the commands

**1. Create a new Game Jam year:**
```bash
php hyde gamejam:create-jam
```

**2. Add games to a year:**
```bash
php hyde gamejam:add-game
```

**3. Update checksums for game downloads:**
```bash
php hyde gamejam:update-checksums --year=2024
```

### Detailed workflow

#### Step 1: Create a new Game Jam year

Run the interactive command:

```bash
php hyde gamejam:create-jam
```

This command will:
- Ask for year, title, topic, dates, duration, and logo filename
- Create `_data/jams/YYYY.yaml` with jam metadata
- Create an empty `_data/games/gamesYYYY.yaml` file

**Example:**
```
Year: 2025
Title: 2025
Topic: Future Worlds
Start date: 2025-12-12
End date: 2025-12-14
Duration in hours: 36
Logo filename: gamejam2025.svg
```

#### Step 2: Prepare game assets

Before adding a game, prepare the assets in the `_input/` directory:

**Directory structure:**
```
_input/
  header/          # Place the header image here (one image)
  screenshots/     # Place all screenshot images here
  download/        # Place game download ZIP files here (optional)
```

**Image requirements:**
- Header image: One image file (JPG, PNG) - will be cropped to 16:9 and resized to 1920x1080
- Screenshots: Multiple images (JPG, PNG) - will be cropped to 16:9, resized to 1920x1080 (full) and 400x225 (thumb)
- All images are automatically converted to WebP format

**Download file naming:**
- Single platform: `GameName.zip` (defaults to Windows)
- Multiple platforms: `GameNameWin.zip`, `GameNameMac.zip`, `GameNameLinux.zip`, `GameNameWeb.zip`

#### Step 3: Add a game

Run the interactive command:

```bash
php hyde gamejam:add-game
# Or specify year directly:
php hyde gamejam:add-game --year=2024
```

This command will:

1. **Ask for game data:**
   - Game name (used to generate URL slug)
   - Number of players
   - Controls (keyboard, mouse, gamepad, touch - multi-select)
   - Description (multiline input - type `---END---` when finished)
   - Team name
   - Team members (comma/semicolon/line-separated - intelligent parsing with preview)
   - Winner status (yes/no + optional placement)

2. **Process images:**
   - Validates that header and screenshots exist in `_input/`
   - Processes header image: crops to 16:9, resizes to 1920x1080, converts to WebP
   - Processes screenshots: crops to 16:9, creates full (1920x1080) and thumb (400x225) versions
   - Moves processed images to `_media/YYYY/` with proper naming: `{slug}_header.webp`, `{slug}_image1_full.webp`, `{slug}_image1_thumb.webp`, etc.

3. **Process downloads:**
   - Finds ZIP files in `_input/download/`
   - Copies them to `games/YYYY/`
   - Calculates SHA256 checksums
   - Detects platform from filename (Win/Mac/Linux/Web)

4. **Add to YAML:**
   - Creates game entry in `_data/games/gamesYYYY.yaml`
   - Uses proper YAML formatting with literal blocks for descriptions
   - Checks for duplicate game names (asks to overwrite if exists)

5. **Cleanup:**
   - On success: Removes processed files from `_input/` directories (keeps directory structure)
   - On error: Keeps source files so you can fix issues and re-run

**Example interaction:**
```
Select year: 2024
Game name: My Awesome Game
Number of players: 1
Controls: keyboard, mouse
Description: [multiline input, type ---END--- when done]
Team name: Awesome Team
Team members: John Doe, Jane Smith, Bob Johnson
Is this a winning game? [y/N]: y
Placement: 1st
```

**Team members parsing:**
The command intelligently parses team members from various formats:
- Comma-separated: `"John Doe, Jane Smith, Bob Johnson"`
- Semicolon-separated: `"John Doe; Jane Smith; Bob Johnson"`
- Line-separated: One per line
- Mixed formats are supported

After parsing, you'll see a preview and can confirm or correct.

#### Step 4: Mark the latest Jam (navigation + homepage CTA)

Update:

- `config/gamejam.php` → `latest_jam`

This controls which year is shown as "latest" in the navigation and which years go under the "Archive" dropdown.

#### Step 5: Update the homepage content (annual)

Edit:

- `_data/homepage.yaml`

This file is intended to be updated yearly and contains:

- `about` (text + image filename)
- `video` (YouTube ID + copy)
- `sponsors` (name, url, logo filename)

Note: In templates, `/media/` is prepended automatically for homepage images and sponsor logos.

#### Step 6: Update registration/voting state (optional)

If needed, update:

- `config/gamejam.php` → `registration.*` and `voting.*`

#### Step 7: Build & verify

```bash
php hyde build
```

Open `_site/index.html` and the new `YYYY.html` page to verify everything renders correctly.

### Manual workflow (alternative)

If you prefer to work manually instead of using the commands:

1. **Add the new Jam year metadata**

   Create a new YAML file:

   - `_data/jams/YYYY.yaml`

   This file contains jam metadata (title, topic, dates, duration, etc.) used for the year page.

2. **Add the games list for that year**

   Create a new YAML file:

   - `_data/games/gamesYYYY.yaml`

   Each entry should include the game name and all metadata needed for the year overview and game detail pages.

3. **Add media assets**

   Put year-specific assets under:

   - `_media/YYYY/` (screenshots, etc.)

   Global shared assets (logos, homepage images, sponsor logos) live directly under:

   - `_media/`

### Requirements for image processing

The `gamejam:add-game` and `gamejam:convert-images` commands require **ImageMagick** to be installed and available in your system PATH.

- **Windows**: Install from [ImageMagick website](https://imagemagick.org/script/download.php) or via package manager
- **macOS**: `brew install imagemagick`
- **Linux**: Usually available via package manager (`apt-get install imagemagick`, `yum install ImageMagick`, etc.)

Verify installation:
```bash
magick --version
```

#### Converting existing images to a different format

The `gamejam:convert-images` command allows you to convert all pixel images to any format supported by ImageMagick (WebP, AVIF, JPG, PNG, etc.) across your entire site. This is useful for:

- Converting older JPG/PNG images to modern formats like WebP or AVIF for better performance
- Standardizing image formats across all years
- Batch conversion of images without manual processing
- Future-proof: works with any format ImageMagick supports

**Usage:**

```bash
# Preview what would be converted (dry-run mode, defaults to WebP)
php hyde gamejam:convert-images --dry-run

# Convert all images to WebP (default format)
php hyde gamejam:convert-images

# Explicitly specify WebP format
php hyde gamejam:convert-images --format=webp

# Convert only images for a specific year
php hyde gamejam:convert-images --format=webp --year=2015

# Convert to a different format (e.g., AVIF, PNG, JPG)
php hyde gamejam:convert-images --format=avif
php hyde gamejam:convert-images --format=png
php hyde gamejam:convert-images --format=jpg
```

**What it does:**

1. **Scans all image files** in `_media/YYYY/` directories and root `_media/` directory
2. **Converts pixel images** to the target format using ImageMagick (supports all ImageMagick formats: WebP, AVIF, HEIC, JXL, JPG, PNG, GIF, etc.)
3. **Automatically validates** that ImageMagick supports the target format before conversion
4. **Skips SVG files** (vector graphics are preserved as-is)
5. **Skips favicons and app icons** (favicon-16x16.png, favicon-32x32.png, apple-touch-icon.png, android-chrome-*.png are preserved as PNG for browser compatibility)
6. **Skips already converted images** (if an image is already in the target format, it's not re-converted)
7. **Updates all YAML references** automatically:
   - `_data/games/games*.yaml` files (headerimage, images[].file, images[].thumb)
   - `_data/homepage.yaml` (hero images, about image, sponsor logos - only pixel images, SVG logos are preserved)
8. **Updates Blade template references** automatically (image references in template files)
9. **Deletes old files** after successful conversion

**Notes:**

- **Default format**: If no `--format` is specified, the command defaults to **WebP**
- Always use `--dry-run` first to preview what will be converted
- The command preserves image quality (uses quality 90 for lossy formats like WebP, AVIF, JPG)
- **SVG files are never converted** (vector graphics remain as SVG)
- **Favicons and app icons are never converted** (favicon-*.png, apple-touch-icon.png, android-chrome-*.png remain as PNG for browser compatibility)
- The command is safe to run multiple times (skips already converted images)
- **Future-proof**: Works with any format ImageMagick supports, including future formats like AVIF, HEIC, JXL, etc.
- To see all supported formats, run: `magick -list format`

### Available commands

- `php hyde gamejam:create-jam` - Create a new Game Jam year with metadata files
- `php hyde gamejam:add-game [--year=YYYY]` - Add a new game to a Game Jam year with automatic image processing
- `php hyde gamejam:update-checksums [--year=YYYY]` - Calculate and update SHA256 checksums for game download files
- `php hyde gamejam:convert-images [--format=webp] [--year=YYYY] [--dry-run]` - Convert all pixel images to a target format and update references
