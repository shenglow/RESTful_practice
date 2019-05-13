<?php
require_once("SiteRestHandler.php");

// get HTTP method
$method = $_SERVER['REQUEST_METHOD'];

// Perform corresponding operations according to the method
switch ($method) {
    case 'GET':
        $view = "";
        if (isset($_GET['view'])) $view = $_GET['view'];
        switch ($view) {
            case "all":
                $siteRestHandler = new SiteRestHandler();
                $siteRestHandler->getAllSites();
                break;
            case "single":
                $siteRestHandler = new SiteRestHandler();
                $siteRestHandler->getSite($_GET['id']);
                break;
        }
        break;
    case 'POST':
        $siteRestHandler = new SiteRestHandler();
        $siteRestHandler->insertSite($_POST['site']);
        break;
}
?>