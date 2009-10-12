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
 * Source file containing class Tx_Powered_ViewHelpers_Format_ImplodeViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_Format_ImplodeViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_Format_ImplodeViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_Format_ImplodeViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_Format_ImplodeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * Path to the property.
     *
     * @var string
     */
    protected $propertyPath = '';
    
    /**
     * Parts of the path to the property.
     *
     * @var array
     */
    protected $propertyPathParts = array();
    
    /**
     * Initialize this view helper.
     * This method is called before the render() method.
     *
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function initialize()
    {
        
    }
    
    /**
     * Implode the given array with the specified glue.
     * If a property is supplied, the array's values's property's values
     * will be imploded.
     * 
     * @param mixed $array The array to implode
     * @param string $glue The glue to use.
     * @param string $property The property to get on each value.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function render( $array, $glue = ', ', $property = NULL )
    {
        if( is_object( $array ) ) {
            
            $array = $array->toArray();
        }
        
        if( !is_array( $array ) ) {
            
            throw new Tx_Powered_Exception(
                'You must supply an array or an Iterator instance to p:format.implode view helper.'
            );
        }
        
        if( is_string( $property ) && !empty( $property ) ) {
            
            $this->propertyPath      = $property;
            $this->propertyPathParts = explode( '.', $this->propertyPath );
            
            $array = $this->getObjectsPropertyAsArray( $array );
        }
        
        return implode( $glue, $array );
    }
    
    protected function getObjectsPropertyAsArray( $objects )
    {
        foreach( $objects as $key => $object ) {
            
            $objects[ $key ] = $this->getObjectProperty( $object );
        }
        
        return $objects;
    }
    
    protected function getObjectProperty( $object )
    {
        $current = $object;
        
        reset( $this->propertyPathParts );
        
        foreach( $this->propertyPathParts as $part ) {
            
            $current = Tx_Extbase_Reflection_ObjectAccess::getProperty( $current, $part );
        }
        
        return $current;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Format/ImplodeViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/Format/ImplodeViewHelper.php']);
}
