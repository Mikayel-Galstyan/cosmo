<?php

class Zend_View_Helper_MapControl extends Zend_View_Helper_Abstract {
    public function mapControl() {
        $html = 
        '<div class="map-control type1">
            <a href="" onclick="Polygon.move(\'left\')" class="left">Left</a>
            <a href="" onclick="Polygon.move(\'right\')" class="right">Right</a>
            <a href="" onclick="Polygon.move(\'up\')" class="up">Up</a>
            <a href="" onclick="Polygon.move(\'down\')" class="down">Down</a>
            <a href="" onclick="Polygon.zoom(\'in\')" class="zoom-in">Zoom</a>
            <a href="" onclick="Polygon.zoom(\'out\')" class="zoom-out">Back</a>
        </div>';
        return $html;
    }
}