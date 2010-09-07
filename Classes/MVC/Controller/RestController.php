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
 * Source file containing class Tx_Powered_MVC_Controller_RestController.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_Controller_RestController
 */

/**
 * Class Tx_Powered_MVC_Controller_RestController.
 * 
 * Provides an RESTful controller. Handle GET, POST, PUT and DELETE requests.
 *
 * @todo       Handle POST / PUT data.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
abstract class Tx_Powered_MVC_Controller_RestController extends Tx_Extbase_MVC_Controller_ActionController
{
    
    const METHOD_GET         = 'GET';
    const METHOD_POST        = 'POST';
    const METHOD_PUT         = 'PUT';
    const METHOD_DELETE      = 'DELETE';
    
    const GET_ACTION_NAME    = 'get';
    const POST_ACTION_NAME   = 'post';
    const PUT_ACTION_NAME    = 'put';
    const DELETE_ACTION_NAME = 'delete';
    
    /**
     * Determines the action method and assures that the method exists.
     *
     * @return string The action method name
     * @throws Tx_Extbase_MVC_Exception_NoSuchAction if the action specified in the request object does not exist (and if there's no default action either).
     */
    protected function resolveActionMethodName()
    {
        switch( $this->request->getMethod() ) {
            
            case self::METHOD_GET:
                
                return self::GET_ACTION_NAME . 'Action';
                
            case self::METHOD_POST:
                
                return self::POST_ACTION_NAME . 'Action';
                
            case self::METHOD_PUT:
                
                return self::PUT_ACTION_NAME . 'Action';
                
            case self::METHOD_DELETE:
                
                return self::DELETE_ACTION_NAME . 'Action';
                
            default:
            
                throw new Tx_Extbase_MVC_Exception_UnsupportedRequestType(
                    get_class( $this ) . ' does not support requests with method "' .
                    $this->request->getMethod() . '".',
                    1270546784
                );
        }
        
        if( !method_exists( $this, $actionMethodName ) ) {
            
            throw new Tx_Extbase_MVC_Exception_NoSuchAction(
                'An action "' . $actionMethodName .
                '" does not exist in controller "' . get_class( $this ) . '".',
                1186669086
            );
        }
        
        return $actionMethodName;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/RestController.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/RestController.php']);
}
