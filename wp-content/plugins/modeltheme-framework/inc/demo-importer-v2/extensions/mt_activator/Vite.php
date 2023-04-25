<?php
if(!defined(ABSPATH)){
    include_once(ABSPATH.'/wp-load.php');
}
/**
 * Usage:
 *
 * with defaults:
 * echo Mta_Vite();
 *
 * change settings as needed:
 * echo Mta_Vite()
 *     ->entry('admin.js')
 *     ->port(3001)
 *     ->outDir('dist-wp-admin');
 *
 */

if (!class_exists("Mta_Vite")) {
    class Mta_Vite
    {
        protected $hostname = 'http://localhost'; // or internal ip
        protected $virtualIP = 'http://10.0.2.2'; // or internal ip
        protected $port = 3000;
        protected $entry = 'main.ts';
        protected $out_dir = 'assets';
        protected $devMode = true;

        public function __toString()
        {
            return $this->preloadAssets('woff2')
                . $this->jsTag()
                . $this->jsPreloadImports()
                . $this->cssTag();
        }

        public function iframeLoad()
        {
            return $this->preloadAssets('woff2')
                . $this->jsTag()
                . $this->jsPreloadImports()
                . $this->cssTagRaw();
        }

        public function entry($entry)
        {
            $this->entry = $entry;
            return $this;
        }

        public function hostname($hostname)
        {
            $this->hostname = $hostname;
            return $this;
        }

        public function virtualIP($virtualIP)
        {
            $this->virtualIP = $virtualIP;
            return $this;
        }

        public function port($port)
        {
            $this->port = $port;
            return $this;
        }

        public function outDir($dir)
        {
            $this->out_dir = $dir;
            return $this;
        }

        public function jsUrl()
        {
            return $this->assetUrl($this->entry);
        }

        public function cssUrls()
        {
            return $this->assetsUrls($this->entry, 'css');
        }

        public function assetUrl($entry)
        {
            $manifest = $this->manifest();

            if (!isset($manifest[$entry])) {
                return '';
            }

            return plugin_dir_url(__FILE__)
                . $this->out_dir
                . '/' . ($manifest[$entry]['file']);
        }

        public function assetsUrls($entry, $path = 'assets')
        {
            $urls = [];
            $manifest = $this->manifest();
            echo "<pre>";
            if (!empty($manifest)) {
                foreach ($manifest as $entry) {
                    foreach ($entry[$path] as $file) {
                        $url = plugin_dir_url(__FILE__)
                            . $this->out_dir
                            . '/' . $file;
                        if (!in_array($url, $urls))
                            $urls[] = $url;
                    }
                }
            }
            return $urls;
        }

        public function importsUrls($entry)
        {
            $urls = [];
            $manifest = $this->manifest();

            if (!empty($manifest[$entry]['imports'])) {
                foreach ($manifest[$entry]['imports'] as $imports) {
                    $urls[] = plugin_dir_url(__FILE__)
                        . $this->out_dir
                        . '/' . $manifest[$imports]['file'];
                }
            }

            return $urls;
        }

        // Helper to output the script tag
        protected function jsTag()
        {
            $url = $this->isDev()
                ? $this->host() . '/' . $this->entry
                : $this->jsUrl();

            if (!$url) {
                return '';
            }
            return '<script type="module" crossorigin src="'
                . $url
                . '"></script>';
        }

        protected function jsPreloadImports()
        {
            if ($this->isDev()) {
                return '';
            }

            $res = '';
            foreach ($this->importsUrls($this->entry) as $url) {
                $res .= '<link rel="modulepreload" href="'
                    . $url
                    . '">';
            }
            return $res;
        }

        // Helper to output style tag
        protected function cssTag()
        {
            // not needed on dev, it's inject by Vite
            if ($this->isDev()) {
                return '';
            }
            $tags = '';
            foreach ($this->cssUrls() as $url) {
                wp_enqueue_style('mt-activator-' . random_int(0, PHP_INT_MAX), $url, true);
            }

            return $tags;
        }

        protected function cssTagRaw()
        {
            // not needed on dev, it's inject by Vite
            if ($this->isDev()) {
                return '';
            }
            $tags = '';
            foreach ($this->cssUrls() as $url) {
                $tags .= '<link href="' . $url . '" rel="stylesheet">';
            }

            return $tags;
        }

        protected function preloadAssets($type)
        {
            if ($this->isDev()) {
                return '';
            }
            return '';
        }

        public function legacy()
        {
            if ($this->isDev()) {
                return '';
            }

            $url = $this->assetUrl(str_replace(
                '.js',
                '-legacy.js',
                $this->entry
            ));

            $polyfill_url = $this->assetUrl('vite/legacy-polyfills');
            if (!$polyfill_url) {
                $polyfill_url = $this->assetUrl('../vite/legacy-polyfills');
            }

            if (!$url || !$polyfill_url) {
                return '';
            }

            $script = '<script nomodule>!function(){var e=document,t=e.createElement("script");if(!("noModule"in t)&&"onbeforeload"in t){var n=!1;e.addEventListener("beforeload",(function(e){if(e.target===t)n=!0;else if(!e.target.hasAttribute("nomodule")||!n)return;e.preventDefault()}),!0),t.type="module",t.src=".",e.head.appendChild(t),t.remove()}}();</script>';

            $script .= '<script nomodule src="' . $polyfill_url . '"></script>';

            $script .= '<script nomodule id="vite-legacy-entry" data-src="' . $url . '">System.import(document.getElementById(\'vite-legacy-entry\').getAttribute(\'data-src\'))</script>';

            return $script;
        }

        protected function isDev()
        {
            return $this->devMode && $this->entryExists();
        }

        protected function host()
        {
            return $this->hostname . ':' . $this->port;
        }

        protected function virtualHost()
        {
            return $this->virtualIP . ':' . $this->port;
        }

        protected function manifest()
        {
            $path = plugin_dir_path(__FILE__) . $this->out_dir . '/manifest.json';

            return file_exists($path)
                ? json_decode(file_get_contents($path), true)
                : [];
        }

        // This method is very useful for the local server
        // if we try to access it, and by any means, didn't started Vite yet
        // it will fallback to load the production files from manifest
        // so you still navigate your site as you intended
        protected function entryExists()
        {
            if (get_option("siteurl") === "http://wp.local") {
                static $exists = null;
                if ($exists !== null) {
                    return $exists;
                }
                $link = $this->virtualHost() . '/' . $this->entry;
                $handle = curl_init($link);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_NOBODY, true);

                curl_exec($handle);
                $error = curl_errno($handle);
                curl_close($handle);
                return $exists = !$error;
            }
            return false;
        }
    }
}
