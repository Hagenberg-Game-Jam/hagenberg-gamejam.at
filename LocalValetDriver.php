<?php

use Valet\Drivers\ValetDriver;

class LocalValetDriver extends ValetDriver
{
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        // Prüfe, ob _site Verzeichnis existiert
        return is_dir($sitePath . '/_site');
    }

    public function isStaticFile(string $sitePath, string $siteName, string $uri): string|false
    {
        $siteRoot = $sitePath . '/_site';

        // 1. SPEZIALFALL: Startseite
        if ($uri === '/' || $uri === '') {
            $index = $siteRoot . '/index.html';
            if (file_exists($index)) {
                return $index;
            }
        }

        // 2. Normale statische Dateien (Bilder, CSS, JS, etc.)
        // Prüfe direkt im _site Verzeichnis
        $staticPath = $siteRoot . $uri;
        if (file_exists($staticPath) && !is_dir($staticPath)) {
            return $staticPath;
        }

        // 3. HTML-Dateien mit expliziter .html Endung
        if (preg_match('/\.html$/', $uri)) {
            $htmlPath = $siteRoot . $uri;
            if (file_exists($htmlPath)) {
                return $htmlPath;
            }
        }

        // 4. Pretty URLs ohne Dateiendung (z.B. /rules -> /rules.html)
        // Nur prüfen, wenn die URI keine Dateiendung hat
        $basename = basename($uri);
        if ($basename && strpos($basename, '.') === false) {
            // Versuche .html Datei
            $htmlFile = $siteRoot . $uri . '.html';
            if (file_exists($htmlFile)) {
                return $htmlFile;
            }

            // Versuche index.html im Ordner
            $indexHtml = $siteRoot . $uri . '/index.html';
            if (file_exists($indexHtml)) {
                return $indexHtml;
            }
        }

        return false;
    }

    public function frontControllerPath(string $sitePath, string $siteName, string $uri): string
    {
        $siteRoot = $sitePath . '/_site';

        // Wenn isStaticFile false zurückgibt, versuchen wir es nochmal mit HTML
        // 1. Startseite
        if ($uri === '/' || $uri === '') {
            $index = $siteRoot . '/index.html';
            if (file_exists($index)) {
                return $index;
            }
        }

        // 2. Pretty URL zu HTML
        $htmlFile = $siteRoot . $uri . '.html';
        if (file_exists($htmlFile)) {
            return $htmlFile;
        }

        // 3. Ordner mit index.html
        $indexHtml = $siteRoot . $uri . '/index.html';
        if (file_exists($indexHtml)) {
            return $indexHtml;
        }

        // 4. 404 Seite
        if (file_exists($notFound = $siteRoot . '/404.html')) {
            return $notFound;
        }

        // Fallback
        return $siteRoot . '/index.html';
    }
}