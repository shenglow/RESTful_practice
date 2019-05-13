<?php
require_once('SimpleRest.php');
require_once('Site.php');

class SiteRestHandler extends SimpleRest {
    public function getAllSites() {
        $site = new Site();
        $rawData = $site->getAllSite();

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');
        } else {
            $statusCode = 200;
        }

        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->response($requestContentType, $statusCode, $rawData);
    }

    public function getSite($id) {
        $site = new Site();
        $rawData = $site->getSite($id);

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No sites found!');
        } else {
            $statusCode = 200;
        }

        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->response($requestContentType, $statusCode, $rawData);
    }

    public function insertSite($newSite) {
        $site = new Site();
        $rawData = $site->insertSite($newSite);

        $statusCode = 200;

        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->response($requestContentType, $statusCode, $rawData);
    }

    private function response($requestContentType, $statusCode, $rawData) {
        if (strpos($requestContentType, 'application/json') !== false) {
            $this->setHttpHeaders('application/json', $statusCode);
            $response = $this->encodeJson($rawData);
            echo $response;
        } else if(strpos($requestContentType, 'text/html') !== false) {
            $this->setHttpHeaders('text/html', $statusCode);
            $response = $this->encodeHtml($rawData);
            echo $response;
        } else if(strpos($requestContentType, 'application/xml') !== false) {
            $this->setHttpHeaders('application/xml', $statusCode);
            $response = $this->encodeXml($rawData);
            echo $response;
        }
    }

    private function encodeJson($rawData) {
        $jsonResponse = json_encode($rawData);
        return $jsonResponse;
    }

    private function encodeHtml($rawData) {
        $htmlResponse = '<table border="1">';
        foreach ($rawData as $key => $value) {
            $htmlResponse .= '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    private function encodeXml($rawData) {
        $xml = new SimpleXMLElement('<?xml version="1.0"?><site></site>');
        foreach ($rawData as $key => $value) {
            $xml->addChild($key, $value);
        }
        return $xml->asXML();
    }
}
?>