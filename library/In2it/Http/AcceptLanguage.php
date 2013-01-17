<?php
/**
 * In2it Framework
 * 
 * Extends Zend Framework with custom functionality or overriding ZF 
 * functionality matching needs of the application
 * 
 * @category    In2it
 * @package     In2it
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
/**
 * In2it_Http_AcceptLanguage
 * 
 * This class provides a way to detect the language of the browser and sets the
 * default language to that specified locale.
 * 
 * @category   In2it
 * @package    In2it_Http
 * @copyright   Copyright (c) 2004 - 2010 In2IT vof. Some rights reserved.
 * @license     http://www.in2it.be/license/new-bsd New-BSD license.
 */
class In2it_Http_AcceptLanguage
{
    const DEF_LANGUAGE = 'en';
    
    /**
     * @var 	Zend_Translate
     */
    protected $_translate;
    public function __construct($translate = null)
    {
        if (null !== $translate 
            && $translate instanceof Zend_Translate) {
            $this->setTranslate($translate);
        }
    }
    /**
     * Sets the translate object to this class
     * 
     * @param Zend_Translate $translate
     * @return Prozf_Http_AcceptLanguage
     */
    public function setTranslate(Zend_Translate $translate)
    {
        $this->_translate = $translate;
        return $this;
    }
    /**
     * Retrieves the translate object from this class
     * 
     * @return Zend_Translate
     */
    public function getTranslate()
    {
        return $this->_translate;
    }
    /**
     * Tries to detect the user preferred settings in the browser,
     * else it defaults to DEF_LANGUAGE
     * 
     * @return string
     */
    public function getUserLanguage()
    {
        $lang = self::DEF_LANGUAGE;
        $languages = $this->detectUserLanguages();
        foreach ($languages as $language) {
            if ($this->getTranslate()
                     ->getAdapter()
                     ->isAvailable($language)) {
                $lang = $language;
                break;
            }
        }
        return $lang;
    }
    /**
     * Looks at the browser settings and returns a list of user
     * preferenced languages or returns an empty list when info
     * is not available.
     * 
     * @return array
     */
    protected function detectUserLanguages()
    {
        $languages = array ();
        if (isset ($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            for ($i = 0; $i < count($languages); $i++) {
                if (false !== strpos($languages[$i], ';')) {
                    $languages[$i] = substr(
                        $languages[$i], 0, strpos($languages[$i], ';'));
                }
                if (false !== strpos($languages[$i], '-')) {
                    $locale = explode('-', $languages[$i]);
                    $languages[$i] = $locale[0] . '_' . strtoupper($locale[1]);
                }
            }
        }
        return $languages;
    }
}