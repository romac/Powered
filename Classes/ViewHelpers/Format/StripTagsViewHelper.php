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
 * Source file containing class Tx_Powered_ViewHelpers_Format_StripTagsViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_Format_StripTagsViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_Format_StripTagsViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_Format_StripTagsViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_Format_StripTagsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * Just calls PHP's internal function: strip_tags
     * 
     * @param string $allowedTags Allowed tags (comma-separated)
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function render( $allowedTags = '' )
    {
        $tags = t3lib_div::trimExplode( ',', $allowedTags );
        $arg  = '';
        
        foreach( $tags as $tag ) {
            
            $arg .= '<' . $tag . '>';
        }
        
        $html = htmlspecialchars_decode( $this->renderChildren(), ENT_COMPAT );
        $text = strip_tags( $html, $allowedTags );
        
        return htmlspecialchars( $text, ENT_COMPAT );
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Format/StripTagsViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Format/StripTagsViewHelper.php']);
}
