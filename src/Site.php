<?php

namespace MaltGames;

use MaltGames\Mod;
use MaltGames\Theme;
use MaltGames\Route;
use MaltGames\Page;

class Site {

    protected $mods;
    protected $themes;
    protected $currentTheme;
    protected $routes;
    protected $currentRoute;
    protected $pages;
    protected $protocol;
    protected $domain;
    protected $baseUrl;

    public function __construct($config) {

      $this->mods = [];
      $this->themes = [];
      $this->currentTheme = NULL;
      $this->routes = [];
      $this->currentRoute = NULL;
      $this->pages = [];
      $this->pageTemplates = [];
      $this->protocol = mkProtocol();
      $this->domain = mkDomain();
      $this->baseUrl = mkBaseUrl();

    }

    // MODS
    public function getMods() { return $this->mods; }
    public function addMods($mods) {
      foreach ($mods as $id => $mod) {
        $this->addMod($id, $mod);
      }
    }
    public function addMod($id, $mod) {
      $modClass = "{$mod['namespace']}\\{$mod['class']}";
      $this->mods[$id] = new $modClass($id, $mod);
    }
    public function getMod($id) {
      return isset($this->mods[$id]) ? $this->mods[$id] : NULL;
    }
    public function loadMod($id) {
      if (isset($this->mods[$id])) {
        $this->mods[$id]->load();
      }
    }
    public function initMods($mods) {

      // Add mods to site.
      $this->addMods($mods);

      // For each initialized mod on the site...
      foreach ($this->getMods() as $id => $mod) {
        $this->initMod($mod);
      }

    }
    public function initMod($mod) {

      // Load the mod.
      $mod->load();

      // Add its routes to the Site.
      $routes = $mod->getRoutes();
      if ($routes) { $this->addRoutes($routes); }

    }

    // THEMES
    public function getThemes() { return $this->themes; }
    public function addThemes($themes) {
      foreach ($themes as $id => $theme) {
        $this->addTheme($id, $theme);
      }
    }
    public function addTheme($id, $theme) {
      $this->themes[$id] = new Theme($id, $theme);
    }
    public function getTheme($id) {
      return isset($this->themes[$id]) ? $this->themes[$id] : NULL;
    }
    public function getCurrentTheme() {
      return $this->currentTheme;
    }
    public function setCurrentTheme($theme) {
      $this->currentTheme = $theme;
    }

    // ROUTES
    public function getRoutes() { return $this->routes; }
    public function addRoutes($routes) {
      foreach ($routes as $id => $route) {
        $this->addRoute($id, $route);
      }
    }
    public function addRoute($id, $route) {
      $this->routes[$id] = new Route($id, $route);
    }
    public function getRoute($id) {
      return isset($this->routes[$id]) ? $this->routes[$id] : NULL;
    }
    public function getCurrentRoute() {
      return $this->currentRoute;
    }
    public function setCurrentRoute($route) {
      $this->currentRoute = $route;
    }

    public function determineCurrentRoute() {

      $currentPath = mkPath();

      // If there isn't a current path, use the default route.
      if (!$currentPath) {
        return $this->getRoute(mkSiteConfig()['defaultRoute']);
      }

      // For each route, see if its path matches the current path, if so, we've
      // got our route. Set it, and return it.
      $route = NULL;
      $routes = $this->getRoutes();
      foreach ($routes as $key => $route) {
        if ($route->getPath() == $currentPath) {
          $this->setCurrentRoute($route);
          return $route;
        }
      }

      // We didn't find a route...

      // Work backwords through the current path's args to locate a route with
      // a matching path.
      $args = explode('/', $currentPath);
      while (count($args)) {
        array_pop($args);
        $path = implode('/', $args);
        foreach ($routes as $key => $route) {
          if ($route->getPath() == $path) {
            $this->setCurrentRoute($route);
            return $route;
          }
        }
      }

      $this->setCurrentRoute($route);

      return $this->getCurrentRoute();

    }

    // PAGES
    public function addPages($pages) {
      foreach ($pages as $id => $page) {
        $this->addPage($id, $page);
      }
    }
    public function addPage($id, $page) {
      $this->pages[$id] = new Page($id, $page);
    }

    /**
     *
     * @param type $id
     * @return MaltGames\Page
     */
    public function loadPage($id) {
      return isset($this->pages[$id]) ? $this->pages[$id] : NULL;
    }

    public function getProtocol() {
      return $this->protocol;
    }

    public function getDomain() {
      return $this->domain;
    }

    public function getBaseUrl() {
      return $this->baseUrl;
    }

}
