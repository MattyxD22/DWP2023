<?php 

namespace controllers;

require("../models/InfoModel.php");

use models\InfoModel;

$infoModel = new InfoModel();

class InfoController {
    
    function fetchAboutUsDetails() {
        global $infoModel;
        $details = $infoModel->fetchAboutUsDetails();
        return $details;
    }
}