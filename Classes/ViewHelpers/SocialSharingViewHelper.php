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
 * Source file containing class Tx_Powered_ViewHelpers_SocialSharingViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @see        Tx_Powered_ViewHelpers_SocialSharingViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_SocialSharingViewHelper.
 * 
 * This view helper renders the SocialSharing comment box.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 */
class Tx_Powered_ViewHelpers_SocialSharingViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * The name of the extension to get the settings from.
     *
     * @var string
     */
    protected $extensionName         = 'spsocialbookmarks_pi1';
    
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
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function initialize()
    {
        // First call the parent class's "initialize" method.
        parent::initialize();
        
        $defaultSettings = $GLOBALS[ 'TSFE' ]->tmpl->setup[ 'plugin.' ][ 'tx_' . $this->extensionName . '.' ];
        
        // Override them with some predefined ones.
        $this->settings       = t3lib_div::array_merge_recursive_overrule(
            $defaultSettings,
            array(
                'serviceList'        => 'delicious, digg, facebook, twitter',
                'useDefaultTemplate' => TRUE,
                'useStats'           => TRUE,
                'useTinyURL'         => FALSE,
                'useTSTitle'         => TRUE,
                'pageTitle.'         => array(
                    'field'          => 'title'
                )
            )
        );
        
        // Get a new content object.
        $this->cObj = t3lib_div::makeInstance( 'tslib_cObj' );
        $this->cObj->start( array(), '' );
    }
    
    /**
     * Render the sp_socialsharing plug-in.
     *
     * @param string $pageTitle The value of ###TITLE###.
     * @param string $services The list of services.
     * @param array $settings The settings which override the default one.
     * @return string The SocialSharing plugin-in.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function render( $pageTitle = '', $services = '', array $settings = array() )
    {
        // Recursively merge the predefined settings with the
        // supplied ones.
        $settings = t3lib_div::array_merge_recursive_overrule(
            $this->settings,
            $settings
        );
        
        if( trim( $pageTitle ) )
        {
            $settings[ 'pageTitle.' ] = array(
                'value' => trim( $pageTitle )
            );
        }
        
        if( trim( $services ) )
        {
            $settings[ 'serviceList' ] = trim( $services );
        }
        
        // Return the resulting code.
        return $this->cObj->cObjGetSingle( 'USER', $settings );
    }
}