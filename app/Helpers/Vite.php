<?php
namespace App\Helpers;
class Vite
{
  static function getDevHost(){
    return env("VITE_URL", "http://localhost:5173");
  }

  static function getProdPath($file){
    return env("VITE_PROD_PATH", base_path('public/dist/'.$file));
  }

  // For a real-world example check here:
  // https://github.com/wp-bond/bond/blob/master/src/Tooling/Vite.php
  // https://github.com/wp-bond/boilerplate/tree/master/app/themes/boilerplate

  // you might check @vitejs/plugin-legacy if you need to support older browsers
  // https://github.com/vitejs/vite/tree/main/packages/plugin-legacy

  // Prints all the html entries needed for Vite
  static function assets(string $entry): string
  {
    $assets = "";
    if(self::isDev($entry))
      $assets .= "\n" . self::reactRefreshDependency();

    $assets .= "\n" . self::jsTag($entry);
    $assets .= "\n" . self::jsPreloadImports($entry);
    $assets .= "\n" . self::cssTag($entry);
    return $assets;
  }


  // Some dev/prod mechanism would exist in your project

  static function isDev(string $entry): bool
  {
    // This method is very useful for the local server
    // if we try to access it, and by any means, didn't started Vite yet
    // it will fallback to load the production files from manifest
    // so you still navigate your site as you intended!

    static $exists = null;
    if ($exists !== null) {
      return $exists;
    }
    $handle = curl_init(self::getDevHost() . '/' . $entry);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_NOBODY, true);

    curl_exec($handle);
    $error = curl_errno($handle);
    curl_close($handle);

    return $exists = !$error;
  }

  static function reactRefreshDependency(){
    return '<script type="module">
      import RefreshRuntime from "'.self::getDevHost().'/@react-refresh"
      RefreshRuntime.injectIntoGlobalHook(window)
      window.$RefreshReg$ = () => {}
      window.$RefreshSig$ = () => (type) => type
      window.__vite_plugin_react_preamble_installed__ = true
    </script>';
  }

  // Helpers to print tags
  static function jsTag(string $entry): string
  {
    $url = self::isDev($entry)
    ? self::getDevHost() . '/' . $entry
    : self::assetUrl($entry);

    if (!$url) {
      return '';
    }
    return '<script type="module" crossorigin src="'
    . $url
    . '"></script>';
  }

  static function jsPreloadImports(string $entry): string
  {
    if (self::isDev($entry)) {
      return '';
    }

    $res = '';
    foreach (self::importsUrls($entry) as $url) {
      $res .= '<link rel="modulepreload" href="'
      . $url
      . '">';
    }
    return $res;
  }

  static function cssTag(string $entry): string
  {
    // not needed on dev, it's inject by Vite
    if (self::isDev($entry)) {
      return '';
    }

    $tags = '';
    foreach (self::cssUrls($entry) as $url) {
      $tags .= '<link rel="stylesheet" href="'
      . $url
      . '">';
    }
    return $tags;
  }


  // Helpers to locate files

  static function getManifest(): array
  {
    $content = file_get_contents(self::getProdPath('manifest.json'));
    return json_decode($content, true);
  }

  static function assetUrl(string $entry): string
  {
    $manifest = self::getManifest();

    return isset($manifest[$entry])
    ? '/dist/' . $manifest[$entry]['file']
    : '';
  }

  static function importsUrls(string $entry): array
  {
    $urls = [];
    $manifest = self::getManifest();

    if (!empty($manifest[$entry]['imports'])) {
      foreach ($manifest[$entry]['imports'] as $imports) {
        $urls[] = '/dist/' . $manifest[$imports]['file'];
      }
    }
    return $urls;
  }

  static function cssUrls(string $entry): array
  {
    $urls = [];
    $manifest = self::getManifest();

    if (!empty($manifest[$entry]['css'])) {
      foreach ($manifest[$entry]['css'] as $file) {
        $urls[] = '/dist/' . $file;
      }
    }
    return $urls;
  }
}
