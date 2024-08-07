<?php
    class Controller {

        public function loadView($viewName, $params = array()) {
            extract($params);
            include("views/header.php");
            require "views/".$viewName.".php";
            include("views/footer.php");
        }
    }

?>