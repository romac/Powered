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
 * Source file containing class Tx_Powered_Helper_RepositoryContainer.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @see        Tx_Powered_Helper_RepositoryContainer
 */

/**
 * Class Tx_Powered_Helper_RepositoryContainer.
 * 
 * Provides a straight-forward and shorthand syntax to get a repository.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 */
class Tx_Powered_Helper_RepositoryContainer
{
    
    /**
     * The repositories class patterns.
     *
     * @var string
     */
    protected $repositoryClassNamePattern = 'Tx_@extension_Domain_Model_@entityRepository';
    
    /**
     * The pattern which a magically called method's name must match against.
     *
     * @var string
     */
    protected $methodNamePattern          = '/get([a-zA-Z0-9]+)Repository/';
    
    /**
     * Repositories
     *
     * @var Tx_Extbase_Persistence_RepositoryInterface[]
     */
    protected $repositories               = array();
    
    /**
     * The context of the current controller.
     *
     * @var Tx_Extbase_MVC_Controller_ControllerContext
     */
    protected $controllerContext          = NULL;
    
    public function __construct( Tx_Extbase_MVC_Controller_ControllerContext $controllerContext )
    {
        $this->controllerContext = $controllerContext;
    }
    
    /**
     * Allows clients to get a repository by invoking
     * $repositoryContainer->get[CamelCaseEntityName]Repository.
     *
     * @param  string $methodName     The name of the invoked method.
     * @param  string $arguments      The arguments of the invoked method.
     * @return Tx_Extbase_Persistence_RepositoryInterface A repository.
     * @throws BadMethodCallException If the invoked method does not match
     *                                against the method's name pattern.
     * @see    getRepository()
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __call( $methodName, $arguments )
    {
        // If the invoked method's name does not match against the pattern.
        if( !preg_match( $this->methodNamePattern, $methodName, $matches ) ) {
            
            // Throw a exception.
            throw new BadMethodCallException(
                'Call to undefined method ' . get_class() . '::' . $methodName . '()'
            );
        }
        
        // Ask for the supplied repository name.
        return $this->getRepository( $matches[ 1 ] );
    }
    
    /**
     * Retrieves a repository based on the supplied entity's name.
     *
     * @param  string $entityName                         The entity's name-
     * @return Tx_Extbase_Persistence_RepositoryInterface A repository.
     * @throws Tx_Powered_Exception_NoSuchRepository      If the asked repository
     *                                                    can not be found.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function getRepository( $entityName )
    {
        if( !array_key_exists( $entityName, $this->repositories ) ) {
            
            $replacements = array(
                '@extension' => $this->controllerContext->getRequest()->getControllerExtensionName(),
                '@entity'    => ucfirst( $entityName )
            );
            
            $repositoryClassName = str_replace(
                array_keys( $replacements ),
                array_values( $replacements ),
                $this->repositoryClassNamePattern
            );
            
            if( !class_exists( $repositoryClassName ) ) {
                
                throw new Tx_Powered_Exception_NoSuchRepository(
                    'The repository "' . $repositoryClassName . '" cannot be found.'
                );
            }
            
            $this->repositories[ $entityName ] = t3lib_div::makeInstance(
                $repositoryClassName
            );
        }
        
        return $this->repositories[ $entityName ];
    }
    
    /**
     * Provides a property-access style to get a repository.
     * 
     * To take part of it, just get $repositoryContainer->entityName.
     * 
     * @param string $entityName The name of the entity to retrieve the repository.
     * @return Tx_Extbase_Persistence_RepositoryInterface A repository.
     * @see    getRepository()
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __get( $entityName )
    {
        return $this->getRepository( $entityName );
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Helper/RepositoryContainer.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Helper/RepositoryContainer.php']);
}
