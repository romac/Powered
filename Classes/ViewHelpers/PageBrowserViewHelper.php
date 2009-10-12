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
 * Source file containing class Tx_Powered_ViewHelpers_PageBrowserViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id: PageBrowserViewHelper.php 13 2009-07-07 08:33:48Z romac $
 * @see        Tx_Powered_ViewHelpers_PageBrowserViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_PageBrowserViewHelper.
 * 
 * This view helper renders a page browser built using the Universal Page Browser
 * extension made by Dmitry Dulepov.
 *
 * @see        http://dmitry-dulepov.com/article/do-you-need-a-page-browser-for-your-typo3-extension.html
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @version    $Id: PageBrowserViewHelper.php 13 2009-07-07 08:33:48Z romac $
 */
class Tx_Powered_ViewHelpers_PageBrowserViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * The name of the extension to get the settings from.
     *
     * @var string
     */
    protected $extensionName         = 'pagebrowse_pi1';
    
    /**
     * undocumented class variable
     *
     * @var string
     */
    protected $defaultParameterName  = 'page';
    
    /**
     * The character which separe the prefix and the parameter.
     *
     * @var string
     */
    protected $separator             = '|';
    
    /**
     * Default settings.
     *
     * @var array
     */
    protected $settings               = array();
    
    /**
     * Content object.
     *
     * @var tslib_cObj
     */
    protected $cObj                   = NULL;
    
    /**
     * Initialize this view helper.
     * This method is called before the render() method.
     *
     * @return void
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function initialize()
    {
        // First call the parent class's "initialize" method.
        parent::initialize();
        
        // Get the configuration manager.
        $configurationManager = t3lib_div::makeInstance(
            'Tx_Extbase_Configuration_Manager'
        );
        
        // Get the default settings from the extension.
        $defaultSettings      = $configurationManager->getSettings(
            $this->extensionName
        );
        
        //  Build the extra query string.
        $extraQueryString = http_build_query(
            array(
                'controller' => $this->controllerContext->getRequest()->getControllerName(),
                'action'     => $this->controllerContext->getRequest()->getControllerActionName()
            ),
            $this->getPrefixIdentifier(),
            '&'
        );
        
        // Override them with some predefined ones.
        $this->settings       = t3lib_div::array_merge_recursive_overrule(
            $defaultSettings,
            array(
                'pageParameterName' => $this->getPageParameterName(),
                'extraQueryString'  => $extraQueryString
            )
        );
        
        // Get a new content object.
        $this->cObj = t3lib_div::makeInstance( 'tslib_cObj' );
        $this->cObj->start( array(), '' );
    }
    
    /**
     * Render a page browser using the Universal Page Browser (EXT:pagebrowse)
     * made by Dmitry Dulepov.
     * 
     * @see   http://dmitry-dulepov.com/article/do-you-need-a-page-browser-for-your-typo3-extension.html
     * @param integer $numberOfPages The number of pages to show.
     * @param array $settings The settings which override the default one.
     * @return string The HTML page browser.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    public function render( $numberOfPages, array $settings = array() )
    {
        // Add the number of pages to show in the configuration.
        $settings[ 'numberOfPages' ] = intval( $numberOfPages );
        
        // Recursively merge the predefined settings with the
        // supplied ones.
        $settings = t3lib_div::array_merge_recursive_overrule(
            $this->settings,
            $settings
        );
        
        // Return the resulting code.
        return $this->cObj->cObjGetSingle( 'USER', $settings );
    }
    
    /**
     * Return a prefix identifier built from a concatenation of the following:
     * 
     * 1. tx_
     * 2. The extension name
     * 3. The plugin name
     * 
     * The result is converted to lowercase.
     * 
     * @return string The prefix identifier.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function getPrefixIdentifier()
    {
        // Get the request from the controller context.
        $request       = $this->controllerContext->getRequest();
        
        // Get the extension name from the request.
        $extensionName = $request->getControllerExtensionName();
        
        // Get the plugin name from the request.
        $pluginName    = $request->getPluginName();
        
        // Concatenate them with tx_ and then convert the result to lowercase.
        return strtolower( 'tx_' . $extensionName . '_' . $pluginName );
    }
    
    /**
     * Return the page parameter name built from a concatenation of the following:
     * 
     * 1. The prefix identifier
     * 2. The separator
     * 3. The default parameter name
     * 
     * @see getPrefixIdentifier()
     * @return string The page parameter name.
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function getPageParameterName()
    {
        return $this->getPrefixIdentifier() . $this->separator
                                            . $this->defaultParameterName;
    }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/PageBrowserViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/PageBrowserViewHelper.php']);
}
