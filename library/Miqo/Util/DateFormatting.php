<?php
class Miqo_Util_DateFormatting {

    public static function dateDifference($date1, $date2)
    {
        if ($date1 != '0000-00-00 00:00:00' and $date2 != '0000-00-00 00:00:00') {
            return round(((strtotime($date2) - strtotime($date1)) / (60 * 60 * 24))) + 1;
        }
    }    
    
    public static function dateYesterday() {
        return date("Y-m-d", mktime(0,0,0,(date('m')), (date('d') - 1), date('Y')));
    }
    
    public static function today() {
        return date("Y-m-d", mktime(0,0,0,(date('m')), date('d'), date('Y')));
    }
    
    public static function addDays($date, $day) {
        $tabDate = explode(' ', $date);
        $tabDate = explode('-', $tabDate[0]);
        return date('Y-m-d H:i:s', mktime(0, 0, 0, $tabDate[1], ($tabDate[2] + ($day)), $tabDate[0]));
    }
    
    public static function convertDate($date) {
        return    date('Y-m-d', strtotime($date));
    }
    
}
?>