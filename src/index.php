<?php

$doc = new DOMDocument();
$doc->loadHTMLFile("../public/index.html");
echo $doc->saveHTML();

?>