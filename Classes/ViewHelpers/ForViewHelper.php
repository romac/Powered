<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2009 Romain Ruetschi (romain@kryzalid.com)
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
 * Source file containing class Tx_Powered_ViewHelpers_ForViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_ForViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_ForViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_ForViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_ForViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper // Tx_Fluid_ViewHelpers_ForViewHelper
{
    
    /**
     * Iterates through elements of $each and renders child nodes
     *
     * @param array $each The array to be iterated over
     * @param string $as The name of the iteration variable
     * @param string $key The name of the variable to store the current array key
     * @return string Rendered string
     * @author Sebastian Kurfürst <sebastian@typo3.org>
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    public function render( $each, $as, $key = '' )
    {
        // If the supplied array is empty.
        if( empty( $each ) ) {
            
            // Return a empty string.
            return '';
        }
        
        // Initialize the output to an empty string.
        $output = '';
        
        // For each item in the supplied array.
        foreach( $each as $keyValue => $singleElement ) {
            
            // Add its alias to the template variable container.
            $this->templateVariableContainer->add( $as, $singleElement );
            
            // If a key was supplied.
            if( $key !== '' ) {
                
                // Also add its key to the template variable container.
                $this->templateVariableContainer->add( $key, $keyValue );
            }
            
            // Render the children of this tag-based view helper
            // and append the result to the output.
            $output .= $this->renderChildren();
            
            // Remove the item alias from the template variable container.
            $this->templateVariableContainer->remove( $as );
            
            // If a key was supplied.
            if( $key !== '' ) {
                
                // Also remove the item key from the template variable container.
                $this->templateVariableContainer->remove( $key );
            }
        }
        
        // Return the generated output.
        return $output;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/ForViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/ForViewHelper.php']);
}
