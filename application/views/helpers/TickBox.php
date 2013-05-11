<?php

class Application_View_Helper_TickBox extends Zend_View_Helper_Abstract
{
    const ACTIVE_TICKBOX = '/images/Checkbox.png';
    const INACTIVE_TICKBOX = '/images/Checkbox.png';
    const TICKBOX_IMAGE = '/images/Checkbox.png';

    protected $_view;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }
    public function tickBox($flag = false)
    {
        $this->_view->headStyle()->appendStyle($this->_getStyle());
        if ($flag) {
            return $this->_getTickedBox();
        }
        return $this->_getUntickedBox();
    }
    protected function _getTickedBox()
    {
        return '<div class="checked_tickbox tickbox"></div>';
    }
    protected function _getUntickedBox()
    {
        return '<div class="unchecked_tickbox tickbox"></div>';
    }
    protected function _getStyle()
    {
        return <<<EOS
div.tickbox {
    display: inline-block;
    width: 26px;
    height: 26px;
}
div.unchecked_tickbox {
    background-image: url('{$this->_view->baseUrl(self::TICKBOX_IMAGE)}');
    background-position: -22px -36px;
}
div.checked_tickbox {
    background-image: url('{$this->_view->baseUrl(self::TICKBOX_IMAGE)}');
    background-position: -53px -36px;
}
EOS;

    }
}