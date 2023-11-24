<?php

namespace models;

require_once 'BaseModel.php';

class InfoModel extends BaseModel {

    function fetchAboutUsDetails() {

        try {
            $cxn = parent::connectToDB();
            $sql = "SELECT * FROM contactinfotable LIMIT 1";
            $query = $cxn->prepare($sql);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
        
    }

}