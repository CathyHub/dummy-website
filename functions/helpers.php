<?php

class Helpers {

    public function is_page($path, $output = 'active') {
        if (strpos($_SERVER['REQUEST_URI'], $path) && $path !== '/') {
            return $output;
        }
        else if ($path === '/' && $_SERVER['REQUEST_URI'] === '/') {
            return $output;
        }
    }


    public function is_not_page($path, $output = 'inactive') {
        if (strpos($_SERVER['REQUEST_URI'], $path) === false) {
            return $output;
        }

        else if ($path === '/' && $_SERVER['REQUEST_URI'] !== '/') {
            return $output;
        }
    }

}

?>