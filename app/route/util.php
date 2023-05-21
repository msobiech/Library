<?php

//use Carbon\Carbon;

class Util {
    // Method of input value sanitization
    public function testInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = strip_tags($data);

        return $data;
    }
    //convert to null if 'unknown'
    public function unknown2Null($data) {
        if (strcmp($data, "unknown") !== 0) {
            return $data;
        }
        return null;
    }

    //convert to null if 'empty' or 'null'
    public function empty2Null($data) {
        if (strcmp($data, "") !== 0 && strcmp($data, "null") !== 0) {
            return $data;
        }
        return null;
    }

    //convert date
    public function date2Null($data) {
        if (strcmp($data, "") !== 0 && strcmp($data, "null") !== 0) {
            return Carbon::parse($data);
        }
        return null;
    }

    //convert to search
    public function convert2wildCard($data) {
        if (strcmp($data, "") !== 0) {
            $result = '%' . $data . '%';
            return $result;
        }
        return null;
    }

    // Method for displaying Success And Error Message
    public function showMessage($type, $message) {
        return '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
                <strong>' . $message . '</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }

    public function toDate($date){
        $time_input = strtotime($date);
        return date('Y-M-d', $time_input); //todo
    }
}

?>