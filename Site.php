<?php
Class Site {
    private $sites;
    private $length;

    function __construct() {
        $this->sites = @include_once('data/site.php');

        if (!is_array($this->sites)) $this->sites = array();

        $this->length = count($this->sites);
    }

    public function getAllSite() {
        return $this->sites;
    }

    public function getSite($id) {
        $site = array($id => ($this->sites[$id]) ? $this->sites[$id] : 'Site not found');
        return $site;
    }

    public function insertSite($site) {
        $id = $this->length + 1;
        $this->sites[$id] = $site;
        file_put_contents('data/site.php', "<?php\n return ".var_export($this->sites, true).";\n?>");

        return array('Result' => 'Insert successed.', 'Id' => $id);
    }
}
?>