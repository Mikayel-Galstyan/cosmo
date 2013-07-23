<?php
class Miqo_Util_Date {
    const ISO_FORMAT = 'Y-m-d H:i:s';
    private $dateObj;

    public function __construct($date = 'now', $format = null){
        $this->dateObj = ($format) ? date_create_from_format($format, $date) : new dateTime($date);
    }

    /**
     * Returns if the given date is earlier
     *
     * @param  Miqo_Util_Date  $date to compare with
     * @return boolean
     */

    public function isEarlier(Miqo_Util_Date $date) {
        return $this->dateObj < $date->dateObj;
    }

    /**
     *  Returns if the given date or datepart is later or equal
     *
     * @param  Miqo_Util_Date  $date to compare with
     * @return boolean
     */
    public function isEarlierOrEqual(Miqo_Util_Date $date) {
        return $this->dateObj <= $date->dateObj;
    }

    /**
     *  Returns if the given date is later
     *
     * @param  Miqo_Util_Date  $date to compare with
     * @return boolean
     */

    public function isLater(Miqo_Util_Date $date) {
        return $this->dateObj > $date->dateObj;
    }
    /**
     *  Returns if the given date or datepart is later or equal
     *
     * @param  Miqo_Util_Date  $date to compare with
     * @return boolean
     */

    public function isLaterOrEqual(Miqo_Util_Date $date) {
        return $this->dateObj >= $date->dateObj;
    }
    /**
     *  Returns if the given date is equal
     *
     * @param  Miqo_Util_Date  $date to compare with
     * @return boolean
     */

    public function isEqual(Miqo_Util_Date $date) {
        return $this->dateObj == $date->dateObj;
    }

    /**
     * Returns difference of dates by day
     *
     * @param Miqo_Util_Date $date
     * @return integer
     */

    public function differenceByDays(Miqo_Util_Date $date) {
        $thisClone = clone $this->dateObj;
        $dateClone = clone $date->dateObj;
        $thisClone->setTime(0, 0, 0);
        $dateClone->setTime(0, 0, 0);
        $difference = $thisClone->format("U") - $dateClone->format("U");
        return round($difference/60/60/24)+1;
    }

    /**
     * @param
     * @return string
     */
    public function format($format) {
        return $this->dateObj->format($format);
    }
    /**
     * @param
     * @return string
     */
    public function get($format) {
        return $this->format($format);
    }

    /**
     * @param signed integer $dayCount
     * @return Miqo_Util_Date
     */
    public function addDays($dayCount) {
        $thisClone = clone $this;
        $thisClone->dateObj->add( DateInterval::createFromDateString($dayCount.' days'));
        return $thisClone;
    }

    /**
     * @param signed integer $monthCount
     * @return Miqo_Util_Date
     */
    public function addMonths($monthCount) {
        $thisClone = clone $this;
        $thisClone->dateObj->add( DateInterval::createFromDateString($monthCount.' months'));

        return $thisClone;
    }

    /**
     * @param signed integer $monthCount
     * @return Miqo_Util_Date
     */
    public function subMonths($monthCount) {
        $thisClone = clone $this;
        $thisClone->dateObj->sub( DateInterval::createFromDateString($monthCount.' months'));

        return $thisClone;
    }

    /**
     * @param signed integer $dayCount
     * @return Miqo_Util_Date
     */
    public function subDays($dayCount) {
        $thisClone = clone $this;
        $thisClone->dateObj->sub( DateInterval::createFromDateString($dayCount.' days'));

        return $thisClone;
    }
//
    public function getByIsoFormat($clearTime = true) {
        $thisClone = clone $this->dateObj;
        $thisClone->setTime(0, 0, 0);
        if($clearTime) {
            $thisClone->setTime(0, 0, 0);
        }
        return $thisClone->format(self::ISO_FORMAT);
    }

    /**
     * @return Miqo_Util_Date
     */
    public static function &getYesterday() {
        $now = new Miqo_Util_Date();
        $yesterday = $now->subDays(1);
        return $yesterday;
    }

    /**
     * @return Miqo_Util_Date
     */
    public static function &getPreviousMonth() {
        $now = new Miqo_Util_Date();
        $previousMonth = $now->subMonths(1);
        return $previousMonth;
    }

    /**
     * @param  integer $weekday  // 1= Mo, 7 = Su
     * @return Miqo_Util_Date
     */
    public function setWeekday($weekdayName) {
        $thisClone = clone $this;
        $thisClone->dateObj->modify($weekdayName . ' this week');
        return $thisClone;
    }

//    public function __toString() {
//        return $this->getByIsoFormat();
//    }

    public function __clone() {
        $this->dateObj = clone $this->dateObj;
    }
}
?>
