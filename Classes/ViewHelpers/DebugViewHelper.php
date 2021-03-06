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
 * Source file containing class Tx_Powered_ViewHelpers_DebugViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_DebugViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_DebugViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_DebugViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_DebugViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * Wrapper for tx_apimacmade::debug() or t3lib_dib::debug() if
     * EXT:api_macmade is not loaded.
     *
     * @param string $header The debug output header.
     * @return string The debug output.
     */
    public function render( $header = 'DEBUG' )
    {
        ob_start();
        
        if( class_exists( 'tx_apimacmade' ) )
        {
            tx_apimacmade::debug( $this->renderChildren(), $header );
        }
        else
        {
            t3lib_div::debug( $this->renderChildren(), $header );
        }
        
        $output = ob_get_contents();
        
        ob_end_clean();
        
        return $output;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Object/DebugViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Object/DebugViewHelper.php']);
}
