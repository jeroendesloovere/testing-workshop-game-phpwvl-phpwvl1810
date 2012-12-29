<?php
/**
 * Zftest
 * 
 * 
 * This source code is used as example code for presentations I give at several
 * PHP conferences around the world. You're free to use, build on-top of it and
 * share with others. You can find this source code on my public GitHub account
 * {@link https://github.com/DragonBe/zftest} where you can fork this code,
 * provide comments and feedback or just play with it.
 * 
 * @license CreativeCommons-Attribution-ShareAlike
 * @link http://creativecommons.org/licenses/by-sa/3.0/
 * @package In2it
 */
/**
 * Zftest_Validate_Mwop
 * 
 * Validates fullnames so people like Matthew Weier O'Phinney and D. Keith
 * Casey, Jr. won't have any problems providing comments on the website.
 * 
 * @author Michelangelo <dragonbe+github@gmail.com>
 * @package Zftest
 * @category Zftest_Validate
 */
class In2it_Validate_Mwop extends Zend_Validate_Abstract
{
    const MWOP = 'mwop';
    /**
     * @var 	array Error messages used by this validator
     */
    protected $messageTemplates = array (
        self::MWOP => "'%value%' is not MWOP proof",
    );
    /**
     * Validates the provided name if it matches predefined conditions and 
     * returns TRUE if the name is valid, or returns FALSE if the name doesn't
     * match the conditions.
     * 
     * @param string $fullname
     * @return boolean
     * @see Zend_Validate_Interface::isValid()
     */
    public function isValid($fullname)
    {
        $this->_setValue($fullname);
        
        $check = preg_match('([\"\=\*\;\[\]\#\\\?]+)', $fullname);
        if (1 === $check) {
            $this->_error(self::MWOP, $fullname);
            return false;
        }
        return true;
    }
}