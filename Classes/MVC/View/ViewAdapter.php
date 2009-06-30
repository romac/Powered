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
 * Source file containing class Tx_Powered_MVC_View_ViewAdapter.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_View_ViewAdapter
 */

/**
 * Class Tx_Powered_MVC_View_ViewAdapter.
 * 
 * Description for class Tx_Powered_MVC_View_ViewAdapter.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 */
class Tx_Powered_MVC_View_ViewAdapter implements Tx_Powered_MVC_View_ViewInterface, Tx_Extbase_MVC_View_ViewInterface
{
    
    /**
     * The original view object to adapt to Tx_Powered_MVC_View_ViewInterface.
     *
     * @var Tx_Extbase_MVC_View_ViewInterface
     */
    protected $view = NULL;
    
    /**
     * Construct a new ViewAdapter.
     *
     * @param Tx_Extbase_MVC_View_ViewInterface $view The View object to adapt.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __construct( Tx_Extbase_MVC_View_ViewInterface $view )
    {
        $this->view = $view;
    }
    
    /**
     * Allows to magically assign a variable to the View by just setting a
     * view's property.
     *
     * @param  string $name  The name of the variable.
     * @param  string $value The value of the variable.
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __set( $name, $value )
    {
        return $this->view->assign( $name, $value );
    }
    
    /**
     * Sets the current controller context.
     *
     * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext The controller context.
     * @return void
     */
    public function setControllerContext( Tx_Extbase_MVC_Controller_ControllerContext $controllerContext )
    {
        return $this->view->setControllerContext( $controllerContext );
    }
    
    /**
     * Renders the view
     *
     * @return string The rendered view
     */
    public function render()
    {
        return $this->view->render();
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewAdapter.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewAdapter.php']);
}
