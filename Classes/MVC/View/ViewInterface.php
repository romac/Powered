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
 * Source file containing class Tx_Powered_MVC_View_ViewInterface.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_View_ViewInterface
 */

/**
 * Class Tx_Powered_MVC_View_ViewInterface.
 * 
 * This interface defines an augmented interface for the View.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 */
interface Tx_Powered_MVC_View_ViewInterface
{
    
    /**
     * Allows to magically assign a variable to the View by just setting a
     * view's property.
     *
     * @param  string $name  The name of the variable.
     * @param  string $value The value of the variable.
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __set( $name, $value );
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewInterface.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewInterface.php']);
}
