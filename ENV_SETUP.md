# Environment Configuration Setup

Dieses Projekt verwendet `.env`-Dateien zur Konfiguration der Umgebung. Es gibt drei Vorlagen:

## Verfügbare .env-Dateien

1. **`.env.example`** - Basis-Vorlage (Standard: localhost:8080)
2. **`.env.local`** - Für lokale Entwicklung mit Herd (hagenberg-gamejam.at.test)
3. **`.env.production`** - Für Produktion (https://hagenberg-gamejam.at)

## Verwendung

### Lokale Entwicklung (Herd)

```bash
# Kopiere die lokale Konfiguration
cp .env.local .env

# Oder unter Windows PowerShell:
Copy-Item .env.local .env
```

### Produktion

```bash
# Kopiere die Produktions-Konfiguration
cp .env.production .env

# Oder unter Windows PowerShell:
Copy-Item .env.production .env
```

### Nach dem Kopieren

Nachdem du die `.env`-Datei erstellt hast, baue die Seite neu:

```bash
php hyde build
```

## Wichtige Konfigurationswerte

- **SITE_URL**: Die Basis-URL deiner Website
  - Lokal: `http://hagenberg-gamejam.at.test`
  - Produktion: `https://hagenberg-gamejam.at`

- **SITE_NAME**: Der Name der Website (wird in Meta-Tags verwendet)

## Hinweis

Die `.env`-Datei ist in `.gitignore` eingetragen und wird nicht ins Repository committet. Stelle sicher, dass du die richtige `.env`-Datei für deine Umgebung verwendest.

