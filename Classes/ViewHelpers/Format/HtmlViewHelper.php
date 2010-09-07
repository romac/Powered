<?php

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */

/**
 * @package Powered
 * @subpackage ViewHelpers
 */

/*
 * @package Powered
 * @subpackage ViewHelpers
 */
class Tx_Powered_ViewHelpers_Format_HtmlViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * @var tslib_cObj
     */
    protected $contentObject;
    
    /**
     * If the ObjectAccessorPostProcessor should be disabled inside this ViewHelper, then set this value to FALSE.
     * This is internal and NO part of the API. It is very likely to change.
     *
     * @var boolean
     * @internal
     */
    protected $objectAccessorPostProcessorEnabled = FALSE;
    
    /**
     * Constructor. Used to create an instance of tslib_cObj used by the render() method.
     * @param tslib_cObj $contentObject injector for tslib_cObj (optional)
     * @return void
     */
    public function __construct( $contentObject = NULL )
    {
        $this->contentObject = $contentObject !== NULL
                             ? $contentObject
                             : t3lib_div::makeInstance( 'tslib_cObj' );
    }
    
    /**
     * @param string $parseFuncTSPath path to TypoScript parseFunc setup.
     * @return the parsed string.
     * @author Bastian Waidelich <bastian@typo3.org>
     * @author Niels Pardon <mail@niels-pardon.de>
     */
    public function render( $parseFuncTSPath = 'lib.parseFunc_RTE' )
    {
        $value = $this->renderChildren();
        
        return html_entity_decode( $value, ENT_COMPAT, 'UTF-8' );
    }
}

?>