<?php

class Zend_View_Helper_MapContainer extends Zend_View_Helper_Abstract {
    public function mapcontainer() {
        $html = 
        '<div id="cord">
            <label class="fl">' . $this->view->translate('lat') .' : <span id="cord_x"></span></label>
            <label class="fr">' . $this->view->translate('long') .' : <span id="cord_y"></span></label>
        </div>
        <div id="contextMenu">
            <ul>
                <li class="active point" onclick="Polygon.add(\'point\')"><span class="ico_add_16"></span><span class="ml5">' . $this->view->translate('add.polygon.point') .'</span></li>
                <li class="active poi" onclick="Polygon.add(\'poi\')"><span class="ico_add_16"></span><span class="ml5">' . $this->view->translate('add.polygon.poi') .'</span></li>
                <li class="active hole" onclick="Polygon.add(\'hole\')"><span class="ico_add_16"></span><span class="ml5">' . $this->view->translate('add.polygon.hole') .'</span></li>
                <li class="active create" onclick="Polygon.create()"><span class="ico_save_16"></span><span class="ml5">'. $this->view->translate('create.polygon') .'</span></li>
                <li class="active clean" onclick="Polygon.clean()"><span class="ico_clean_16"></span><span class="ml5">'. $this->view->translate('clean.points') .'</span></li>
            </ul>
            <div class="split"></div>
            <ul>
                <li><span class="ico_rul_16"></span><span class="ml5 coord_lat">'. $this->view->translate('lat') .' : <i></i></span></li>
                <li><span class="ico_rul_16"></span><span class="ml5 coord_long">'. $this->view->translate('long') .' : <i></i></span></li>
            </ul>
        </div>';
        return $html;
    }
}