<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2010 Romain Ruetschi (romain.ruetschi@gmail.com)
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
 * Source file containing class Tx_Powered_MVC_View_TemplateView.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_MVC_View_TemplateView
 */

/**
 * Class Tx_Powered_MVC_View_TemplateView.
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
class Tx_Powered_MVC_View_TemplateView extends Tx_Fluid_View_TemplateView
{
    
    const CACHE_IDENTIFIER = 'cache_powered_fluidsyntaxtree';
    
    /**
     * Cache Manager
     *
     * @var t3lib_cache_Manager
     */
    protected $cacheManager = NULL;
    
    /**
     * Cache frontend
     *
     * @var t3lib_cache_frontend_VariableFrontend
     */
    protected $cache        = NULL;
    
    /**
     * Create a new Tx_Powered_MVC_View_TemplateView object.
     *
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->initializeCache();
    }
    
    /**
     * Initializes the cache framework
     *
     * @return void
     */
    protected function initializeCache()
    {
        $this->cacheManager = $GLOBALS[ 'typo3CacheManager' ];
        
        try
        {
            $this->cache = $this->cacheManager->getCache( self::CACHE_IDENTIFIER );
        }
        catch( t3lib_cache_exception_NoSuchCache $exception )
        {
            $this->cache = $GLOBALS[ 'typo3CacheFactory']->create(
                self::CACHE_IDENTIFIER,
                't3lib_cache_frontend_VariableFrontend',
                't3lib_cache_backend_FileBackend',
                array(
                    'cacheDirectory' => 'typo3temp/tx_powered/cache',
                )
            );
        }
    }
    
    /**
     * Parse the given template and return it.
     *
     * Will cache the results for one call.
     *
     * @param string $templatePathAndFilename absolute filename of the template to be parsed
     * @return Tx_Fluid_Core_Parser_ParsedTemplateInterface the parsed template tree
     * @throws Tx_Fluid_View_Exception_InvalidTemplateResourceException
     * @author Sebastian Kurfürst <sebastian@typo3.org>
     */
    protected function parseTemplate( $templatePathAndFilename )
    {
        $cacheIdentifier = md5( $templatePathAndFilename );
        
        if( !$this->cache->has( $cacheIdentifier ) )
        {
            $parsedTemplate = parent::parseTemplate( $templatePathAndFilename );
            
            $this->cache->set( $cacheIdentifier, $parsedTemplate );
        }
        else
        {
            $parsedTemplate = $this->cache->get( $cacheIdentifier );
        }
        
        return $parsedTemplate;
    }
    
}
