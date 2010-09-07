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
 * Source file containing class Tx_Powered_MVC_Controller_ActionController.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_Controller_ActionController
 */

/**
 * Class Tx_Powered_MVC_Controller_ActionController.
 * 
 * Provides an abstract controller augmented with a repository container which
 * can be used to easily retrieve a repository.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
abstract class Tx_Powered_MVC_Controller_ActionController extends Tx_Extbase_MVC_Controller_ActionController
{
    
    /**
     * A repository container.
     *
     * @var Tx_Powered_Helper_RepositoryContainer
     */
    protected $repositoryContainer              = NULL;
    
    /**
     * Public Resources Web Path
     *
     * @var string
     */
    protected $publicResourcesWebPath           = '';
    
    /**
     * Public Resources Path
     *
     * @var string
     */
    protected $publicResourcesPath              = '';
    
    /**
     * Extension name
     *
     * @var string
     */
    protected $lowerCasedExtensionName          = '';
    
    /**
     * View adapter class name.
     *
     * @var string
     */
    protected $viewAdapterClassName             = 'Tx_Powered_MVC_View_ViewAdapter';
    
    /**
     * Repository container class name.
     *
     * @var string
     */
    protected $repositoryContainerClassName     = 'Tx_Powered_Helper_RepositoryContainer';
    
    /**
     * This method is called just before the action method is launched.
     * It can be used to do generic stuff that all actions need.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function initializeAction()
    {
        parent::initializeAction();
        
        $this->initializeHelpers();
        $this->initializeResourcesPaths();
    }
    
    /**
     * Initialize the resources paths.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function initializeResourcesPaths()
    {
        $extKey                       = $this->getLowerCasedExtensionName();
        $relPath                      = substr( t3lib_extMgm::extPath( $extKey ), strlen( PATH_site ) );
        
        $this->publicResourcesWebPath = $relPath  . 'Resources/Public/';
        $this->publicResourcesPath    = t3lib_extMgm::extPath( $extKey ) . 'Resources/Public/';
    }
    
    /**
     * Initializes the helpers.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function initializeHelpers()
    {
        // Get a repository container.
        $this->repositoryContainer = t3lib_div::makeInstance(
            $this->repositoryContainerClassName,
            $this->buildControllerContext()
        );
    }
    
    /**
     * Initializes the view before invoking an action method.
     *
     * @param Tx_Extbase_View_ViewInterface $view The view to be initialized
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function initializeView( Tx_Extbase_MVC_View_ViewInterface $view )
    {
        parent::initializeView( $view );
        
        $this->view = t3lib_div::makeInstance(
            $this->viewAdapterClassName,
            $this->view
        );
    }
    
    /**
     * Get the loweredcased extension's name this controller belongs to.
     *
     * @return string The lowercased underscored extension name.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function getLowerCasedExtensionName()
    {
        if( !$this->lowerCasedExtensionName ) {
            
            $this->lowerCasedExtensionName = Tx_Extbase_Utility_Extension::convertCamelCaseToLowerCaseUnderscored(
                $this->request->getControllerExtensionName()
            );
        }
        
        return $this->lowerCasedExtensionName;
    }
    
    /**
     * Include a stylesheet corresponding to the current action.
     * File is supposed to be found at:
     * EXT:{extKey}/Resources/Public/CSS/{controller}/{lowerCasedAction}.css
     *
     * @return boolean True if the file was found and included, false otherwise.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function addStyleSheetForCurrentAction()
    {
        $controller     = $this->request->getControllerName();
        $action         = $this->request->getControllerActionName();
        $controllerDir  = $this->publicResourcesPath . 'CSS/' . $controller . '/';
        $actionFile     = strtolower( $action ) . '.css';
        
        if( !is_dir( $controllerDir ) ) {
            
            return FALSE;
        }
        
        if( !file_exists( $controllerDir . $actionFile ) ) {
            
            return FALSE;
        }
        
        $html = '<link href="' . $this->publicResourcesWebPath
              . 'CSS/' . $controller . '/' . $actionFile
              . '" rel="stylesheet" type="text/css" media="screen" charset="utf-8" />';
        
        $this->response->addAdditionalHeaderData( $html );
        
        return TRUE;
    }
    
    /**
     * Include a JavaScript file corresponding to the current action.
     * File is supposed to be found at:
     * EXT:{extKey}/Resources/Public/JavaScripts/{controller}/{action}.js
     *
     * @return boolean True if the file was found and included, false otherwise.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    protected function addJavaScriptForCurrentAction()
    {
        $controller     = $this->request->getControllerName();
        $action         = $this->request->getControllerActionName();
        $controllerDir  = $this->publicResourcesPath . 'JavaScripts/' . $controller . '/';
        $actionFile     = strtolower( $action ) . '.js';
        
        if( !is_dir( $controllerDir ) ) {
            
            return FALSE;
        }
        
        if( !file_exists( $controllerDir . $actionFile ) ) {
            
            return FALSE;
        }
        
        $html = '<script src="' . $this->publicResourcesWebPath
              . 'JavaScripts/' . $controller . '/' . $actionFile
              . '" type="text/javascript"></script>';
        
        $this->response->addAdditionalHeaderData( $html );
        
        return TRUE;
    }
    
    /**
     * Allows to retrieve a repository by just asking for:
     * $this->[entityName]Repository.
     *
     * @param string $propertyName The name of the getted property.
     * @return mixed
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function __get( $propertyName )
    {
        // If the asked property's name ends with "Repository".
        if( substr( $propertyName, -10 ) === 'Repository' ) {
            
            // Assign a repository to the property.
            $this->$propertyName = $this->repositoryContainer->getRepository(
                substr( $propertyName, 0, -10 )
            );
        }
        
        // Return it.
        return $this->$propertyName;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractController.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractController.php']);
}
