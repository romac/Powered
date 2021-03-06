<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2009 Romain Ruetschi (romain.ruetschi@gmail.com)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is 
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Source file containing class Tx_Powered_Validation_Validator_URLValidator.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_Validation_Validator_URLValidator
 */

/**
 * Class Tx_Powered_Validation_Validator_URLValidator.
 * 
 * Description for class Tx_Powered_Validation_Validator_URLValidator.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_Validation_Validator_URLValidator extends Tx_Extbase_Validation_Validator_AbstractValidator
{
    
    /**
     * Checks if the given value is a valid URL.
     * If at least one error occurred, the result is FALSE.
     *
     * @param mixed $value The value that should be validated
     * @return boolean TRUE if the value is valid, FALSE if an error occured
     */
    public function isValid( $value )
    {
        $this->errors = array();
        
        if( $value !== filter_var( $value, FILTER_VALIDATE_URL ) )
        {
            $this->addError( 'The given subject was not a valid URL.', 1256637565 );
            
            return FALSE;
        }
        
        return TRUE;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Validation/Validator/URLValidator.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Validation/Validator/URLValidator.php']);
}
