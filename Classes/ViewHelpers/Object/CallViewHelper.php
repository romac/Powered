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
 * Source file containing class Tx_Powered_ViewHelpers_Object_CallViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_Object_CallViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_Object_CallViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_Object_CallViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_Object_CallViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * The reflection service.
     *
     * @var Tx_Extbase_Reflection_Service
     */
    protected $reflectionService = NULL;
    
    /**
     * Initialize this view helper.
     * This method is called before the render() method.
     *
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function initialize()
    {
        $this->reflectionService = t3lib_div::makeInstance(
            'Tx_Extbase_Reflection_Service'
        );
    }
    
    /**
     * Invoke a method (with arguments) on the given object and returns its output.
     * 
     * @param GenericObject $object The object to invoke the method on.
     * @param string $mehod The name of the method to invoke.
     * @param array $arguments The arguments to supply to the method.
     * @return string The output of the method's invocation.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function render( $object, $method, array $arguments = array() )
    {
        if( !method_exists( $object, $method ) ) {
            
            throw new Tx_Powered_Exception_NoSuchObjectMethod(
                'The given object of type "' . get_class( $object ) . '" does ' . 
                'not have method "' . $method . '()".'
            );
        }
        
        $methodReflection = t3lib_div::makeInstance(
            'Tx_Extbase_Reflection_MethodReflection',
            get_class( $object ),
            $method
        );
        
        $result = $methodReflection->invokeArgs( $object, $arguments );
        
        return $result;
        
    } // CHANGME: Type check ?
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Object/CallViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Object/CallViewHelper.php']);
}
