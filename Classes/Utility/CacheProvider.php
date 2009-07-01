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
 * Source file containing class Tx_Powered_Utility_CacheProvider.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @see        Tx_Powered_Utility_CacheProvider
 */

require_once( PATH_t3lib . 'interfaces/interface.t3lib_singleton.php' );
require_once( PATH_t3lib . 'cache/class.t3lib_cache_factory.php' );

/**
 * Class Tx_Powered_Utility_CacheProvider.
 * 
 * Description for class Tx_Powered_Utility_CacheProvider.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id$
 * @todo       Refactorize this class.
 */
class Tx_Powered_Utility_CacheProvider implements t3lib_Singleton
{
    
    /**
     * Is the cache enabled ?
     */
    const CACHE_ENABLED                  = true;
    
    /**
     * The name of the function which will be invoked by the TCE to clear the cache.
     */
    const CLEAR_CACHE_FUNCTION_NAME     = 'user_txPoweredUtilityCacheProvider_clearCache';
    
    /**
     * Cache configurations holder.
     *
     * @var array
     */
    protected $cacheConfigurationsHolder = array();
    
    /**
     * Cache identifiers.
     *
     * @var string[]
     */
    protected $cacheIdentifiers          = array(
        'Tx_Powered',
        'Tx_Extbase_Reflection'
    );
    
    /**
     * Cache factory
     *
     * @var t3lib_cache_Factory
     */
    protected $cacheFactory              = NULL;
    
    /**
     * Cache directories to clear.
     *
     * @var string[]
     */
    protected $cacheDirectories          = array();
    
    /**
     * Constructs a new CacheProvider object.
     *
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function __construct()
    {
        $this->cacheConfigurationsHolder =& $GLOBALS[ 'TYPO3_CONF_VARS' ][ 'SYS' ][ 'caching' ][ 'cacheConfigurations' ];
        $this->cacheFactory              = t3lib_div::makeInstance(
            't3lib_cache_Factory'
        );
    }
    
    /**
     * Add a cache identifier
     *
     * @param string $cacheIdentifier The cache identifier
     * @return Tx_Powered_Utility_CacheProvider This instance.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function addCacheIdentifier( $cacheIdentifier )
    {
        // Check if the supplied identifier is already registered.
        if( !in_array( $cacheIdentifier, $this->cacheIdentifiers, true ) ) {
            
            // If not, register it.
            $this->cacheIdentifiers[] = $cacheIdentifier;
        }
        
        return $this;
    }
    
    /**
     * Get the register cache identifiers.
     *
     * @return string[] The cache identifiers.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function getCacheIdentifiers()
    {
        return $this->cacheIdentifiers;
    }
    
    /**
     * Clear the cache.
     *
     * @param &array $params The parameters.
     * @return boolean TRUE if the cache has successfully been cleared, false otherwise.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function clearCache( &$params )
    {
        // We only clear the cache if "Clear all cache" has been selected.
        if( $params[ 'cacheCmd' ] !== 'all' ) {
            
            return false;
        }
        
        // Build the cache directories index.
        $this->buildCacheDirectoriesIndex();
        
        // Holds the state of the process.
        $status = true;
        
        // For each register cache directory.
        foreach( $this->cacheDirectories as $cacheDirectory ) {
            
            // Recursively remove the directory and update success status.
            $status = $status && ( bool )t3lib_div::rmdir(
                t3lib_div::getFileAbsFileName( $cacheDirectory ),
                true
            );
        }
        
        // Return the status.
        return ( bool )$status;
    }
    
    /**
     * Create a new cache.
     *
     * @param  string $cacheIdentifier The cache identifier.
     * @param  string $frontendName The class name of the cache frontend.
     * @return t3lib_cache_frontend_FrontendInterface The cache frontend.
     * @see    t3lib_cache_Factory::create()
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function createCache( $cacheIdentifier, $frontendName = 't3lib_cache_frontend_VariableFrontend' )
    {
        return $this->cacheFactory->create(
            $cacheIdentifier,
            $frontendName,
            $this->getCacheBackend( $cacheIdentifier ),
            $this->getCacheOptions( $cacheIdentifier )
        );
    }
    
    /**
     * Get the configuration for the supplied cache identifier.
     *
     * @param string $cacheIdentifier The cache identifier.
     * @return array The cache configuration array.
     * @author Romain Ruetschi <romain@kryzalid.com>
     * @throws Tx_Powered_Exception_NoSuchCacheIdentifier If no valid registered cache identifier found.
     */
    protected function getCacheConfiguration( $cacheIdentifier )
    {
        // If the supplied cache identifier is not registered.
        if( !array_key_exists( $cacheIdentifier, $this->cacheConfigurationsHolder ) ) {
            
            throw new Tx_Powered_Exception_NoSuchCacheIdentifier(
                'No cache configuration registered for identifier "' . $cacheIdentifier . '".'
            );
        }
        
        return $this->cacheConfigurationsHolder[ $cacheIdentifier ];
    }
    
    /**
     * Return the cache backend's name by its cache identifier.
     *
     * @param string $cacheIdentifier The cache identifier.
     * @return string The name of the cache backend.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function getCacheBackend( $cacheIdentifier )
    {
        $configuration = $this->getCacheConfiguration( $cacheIdentifier );
        
        return $configuration[ 'backend' ];
    }
    
    /**
     * Return the cache options by them cache identifier.
     *
     * @param string $cacheIdentifier The cache identifier.
     * @return array The options.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function getCacheOptions( $cacheIdentifier )
    {
        $configuration = $this->getCacheConfiguration( $cacheIdentifier );
        
        return $configuration[ 'options' ];
    }
    
    /**
     * Return the cache directory by its cache identifier.
     *
     * @param  string $cacheIdentifier The cache identifier.
     * @return string The relative path to the cache directory.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function getCacheDirectory( $cacheIdentifier )
    {
        $configuration = $this->getCacheConfiguration( $cacheIdentifier );
        
        return $configuration[ 'options' ][ 'cacheDirectory' ];
    }
    
    /**
     * Build the cache directories index.
     *
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function buildCacheDirectoriesIndex()
    {
        // Reset the current index.
        $this->cacheDirectories = array();
        
        // For each registered cache identifier.
        foreach( $this->cacheIdentifiers as $cacheIdentifier ) {
            
            // Try to get its directory and to add it to the index.
            try {
                
                $this->cacheDirectories[] = $this->getCacheDirectory(
                    $cacheIdentifier
                );
            
            // If it failed, just ignore it.
            } catch( Tx_Powered_Exception_NoSuchCacheIdentifier $e ) {}
        }
    }
    
}

// If the function 
if( !function_exists( Tx_Powered_Utility_CacheProvider::CLEAR_CACHE_FUNCTION_NAME ) ) {
    
    function user_txPoweredUtilityCacheProvider_clearCache( &$params )
    {
        return t3lib_div::makeInstance(
            'Tx_Powered_Utility_CacheProvider'
        )->clearCache( $params );
    }
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Utility/CacheProvider.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Utility/CacheProvider.php']);
}
