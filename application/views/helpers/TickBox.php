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
}