<?php

class In2it_View_Helper_GoogleTracker extends Zend_View_Helper_Abstract
{
    public $view;
    
    public function setView(Zend_View_Interface $view)
    {
        return parent::setView($view);
    }
    
    public function googleTracker($trackingId)
    {
        return $this->view->inlineScript()->appendScript(<<<EOS
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '{$trackingId}']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
EOS
        );
    }
}