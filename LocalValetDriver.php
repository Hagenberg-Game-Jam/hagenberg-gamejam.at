<?php

use Valet\Drivers\ValetDriver;

class LocalValetDriver extends ValetDriver
{
    public function serves(string $sitePath, string $siteName, string $uri): bool
    {
        // Check if the _site directory exists
        return is_dir($sitePath . '/_site');
    }

    public function isStaticFile(string $sitePath, string $siteName, string $uri): string|false
    {
        $siteRoot = $sitePath . '/_site';

        // 1. Special case: homepage
        if ($uri === '/' || $uri === '') {
            $index = $siteRoot . '/index.html';
            if (file_exists($index)) {
                return $index;
            }
        }

        // 2. Regular static files (images, CSS, JS, etc.)
        // Check directly in the _site directory
        $staticPath = $siteRoot . $uri;
        if (file_exists($staticPath) && !is_dir($staticPath)) {
            return $staticPath;
        }

        // 3. HTML files with an explicit .html extension
        if (preg_match('/\.html$/', $uri)) {
            $htmlPath = $siteRoot . $uri;
            if (file_exists($htmlPath)) {
                return $htmlPath;
            }
        }

        // 4. Pretty URLs without an extension (e.g. /rules -> /rules.html)
        // Only check if the URI has no extension
        $basename = basename($uri);
        if ($basename && strpos($basename, '.') === false) {
            // Try .html file
            $htmlFile = $siteRoot . $uri . '.html';
            if (file_exists($htmlFile)) {
                return $htmlFile;
            }

            // Try index.html within the directory
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

        // If isStaticFile returns false, try again with HTML fallbacks
        // 1. Homepage
        if ($uri === '/' || $uri === '') {
            $index = $siteRoot . '/index.html';
            if (file_exists($index)) {
                return $index;
            }
        }

        // 2. Pretty URL -> HTML
        $htmlFile = $siteRoot . $uri . '.html';
        if (file_exists($htmlFile)) {
            return $htmlFile;
        }

        // 3. Directory with index.html
        $indexHtml = $siteRoot . $uri . '/index.html';
        if (file_exists($indexHtml)) {
            return $indexHtml;
        }

        // 4. 404 page
        if (file_exists($notFound = $siteRoot . '/404.html')) {
            return $notFound;
        }

        // Fallback
        return $siteRoot . '/index.html';
    }
}