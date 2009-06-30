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
 * Source file containing class Tx_Powered_MVC_Controller_AbstractController.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_Controller_AbstractController
 */

/**
 * Class Tx_Powered_MVC_Controller_AbstractController.
 * 
 * Provides an abstract controller augmented with a repository container which
 * can be used to easily retrieve a repository.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 */
abstract class Tx_Powered_MVC_Controller_AbstractController extends Tx_Extbase_MVC_Controller_ActionController
{
    
    /**
     * Debug mode enabled ?
     * 
     * @todo Remove when production ready.
     */
    const DEBUG_MODE = true;
    
    /**
     * A repository container.
     *
     * @var Tx_Powered_Helper_RepositoryContainer
     */
    protected $repositoryContainer = NULL;
    
    /**
     * Constructs a new controller.
     * 
     * This method calls the initalization methods needed and check for a debug mode.
     * 
     * @todo   Remove the debug part when production ready.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->initializeHelpers();
        
        if( self::DEBUG ) {
            
            require_once(
                t3lib_extMgm::extPath( 'api_macmade' ) . 'class.tx_apimacmade.php'
            );
        }
    }
    
    /**
     * Initializes the helpers.
     *
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function initializeHelpers()
    {
        // Get a repository container.
        $this->repositoryContainer = t3lib_div::makeInstance(
            'Tx_Powered_Helper_RepositoryContainer'
        );
    }
    
    /**
     * Initializes the view before invoking an action method.
     *
     * @param Tx_Extbase_View_ViewInterface $view The view to be initialized
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function initializeView( Tx_Extbase_MVC_View_ViewInterface $view )
    {
        parent::initializeView();
        
        $this->view = t3lib_div::makeInstance(
            'Tx_Powered_View_ViewAdapter',
            $view
        );
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractController.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractController.php']);
}
