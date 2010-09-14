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
 * Source file containing class Tx_Powered_MVC_View_ViewAdapter.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_View_ViewAdapter
 */

/**
 * Class Tx_Powered_MVC_View_ViewAdapter.
 * 
 * This class is an adaptator designed to adapt the interface of any class implementing
 * the standard Extbase view interface to the Powered view interface whithout extending it.
 * This to allow the use of any view that implements the standard Extbase view interface,
 * as the Fluid template view does.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
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
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
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
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function __set( $name, $value )
    {
        return $this->view->assign( $name, $value );
    }
    
    public function initializeView()
    {
        $this->view->initializeView();
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
    
    /**
     * Call a method on the wrapped view.
     *
     * @param string $methodName The name of the method to call.
     * @param array $arguments The arguments to supply to the method.
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function &__call( $methodName, array $arguments = array() )
    {
        // Checks for constructor arguments
        switch( count( $arguments ) )
        {
            case 0:
                
                // Return an instance of the class
                return $this->view->$methodName();
            
            case 1:
                
                // Return an instance of the class
                return $this->view->$methodName( $arguments[ 0 ] );
            
            case 2:
                
                // Return an instance of the class
                return $this->view->$methodName( $arguments[ 0 ], $arguments[ 1 ] );
            
            case 3:
                
                // Return an instance of the class
                return $this->view->$methodName( $arguments[ 0 ], $arguments[ 1 ], $arguments[ 2 ] );
            
            case 4:
                
                // Return an instance of the class
                return $this->view->$methodName( $arguments[ 0 ], $arguments[ 1 ], $arguments[ 2 ], $arguments[ 3 ] );
            
            case 5:
                
                // Return an instance of the class
                return $this->view->$methodName( $arguments[ 0 ], $arguments[ 1 ], $arguments[ 2 ], $arguments[ 3 ], $arguments[ 4 ] );
            
            default:
            
                throw new Tx_Powered_Exception(
                    'Calling a method with more than 5 arguments is a bad idea.' .
                    'Therefore this feature is currently disabled.'
                );
        }
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewAdapter.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/View/ViewAdapter.php']);
}
