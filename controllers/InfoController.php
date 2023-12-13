<?php

namespace controllers;

require("../models/InfoModel.php");

use models\InfoModel;

$infoModel = InfoModel::getInfoModel();

class InfoController
{

    function fetchAboutUsDetails()
    {
        global $infoModel;
        $details = $infoModel->fetchAboutUsDetails();
        return $details;
    }
}
