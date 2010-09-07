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
 * Source file containing class Tx_Powered_Utility_FlexForm_ActionControllerManager.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id: ActionControllerManager.php 88 2009-07-16 08:01:37Z romac $
 * @see        Tx_Powered_Utility_FlexForm_ActionControllerManager
 */

/**
 * Class Tx_Powered_Utility_FlexForm.
 * 
 * Use this class to populate a FlexForm with some controllers and
 * their associated actions.
 * 
 * To use it from your FlexForm, put in this configuration:
 * 
 * <code>
 * <controller>
 *     <TCEforms>
 *         <label>LLL:EXT:powered/Resources/Private/Language/locallang_db.xml:tt_content.flexform_pi1.controller</label>
 *         <onChange>reload</onChange>
 *         <config>
 *             <type>select</type>
 *             <itemsProcFunc>EXT:powered/Classes/Utility/FlexForm/ActionControllerManager.php:user_Tx_Powered_Utility_FlexForm__getControllerItems</itemsProcFunc>
 *             <minitems>0</minitems>
 *             <maxitems>1</maxitems>
 *             <size>1</size>
 *         </config>
 *     </TCEforms>
 * </controller>
 * <action>
 *     <TCEforms>
 *         <label>LLL:EXT:powered/Resources/Private/Language/locallang_db.xml:tt_content.flexform_pi1.action</label>
 *         <config>
 *             <type>select</type>
 *             <itemsProcFunc>EXT:powered/Classes/Utility/FlexForm/ActionControllerManager.php:user_Tx_Powered_Utility_FlexForm__getActionItems</itemsProcFunc>
 *             <minitems>0</minitems>
 *             <maxitems>1</maxitems>
 *             <size>1</size>
 *         </config>
 *     </TCEforms>
 * </action>
 * </code>
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id: ActionControllerManager.php 88 2009-07-16 08:01:37Z romac $
 */
class Tx_Powered_Utility_FlexForm_ActionControllerManager
{
    
    /**
     * Front controller name
     */
    const FRONT_CONTROLLER = 'Front';
    
    /**
     * Controllers
     *
     * @var array
     */
    static protected $controllers = array();
    
    /**
     * Set the controllers selectable from the FlexForm.
     *
     * @param array $controllers
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public static function setControllers( array $controllers )
    {
        self::$controllers = $controllers;
    }
    
    /**
     * Get the controllers selectable from the FlexForm.
     *
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public static function getControllers()
    {
        return self::$controllers;
    }
    
    /**
     * Populate the given FlexForm configuration with the controllers.
     *
     * @param string $conf The FlexForm configuration to populate.
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public static function populateControllerItems( array &$conf )
    {
        $items = array( array( '', '', '' ) );
        
        foreach( array_keys( self::getControllers() ) as $controller ) {
            
            if( $controller === self::FRONT_CONTROLLER ) {
                
                continue;
            }
            
            $items[] = array(
                $controller,
                $controller,
                ''
            );
        }
        
        $conf[ 'items' ] = array_merge( $conf[ 'items' ], $items );
    }
    
    /**
     * Populate the given FlexForm configuration with the actions
     * owned by the previously selected controller.
     *
     * @param string $conf The FlexForm configuration to populate.
     * @return void
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public static function populateActionItems( array &$conf )
    {
        if( !class_exists( 'tx_apimacmade' ) ) {
            
            require_once( t3lib_extMgm::extPath( 'api_macmade' ) . 'class.tx_apimacmade.php' );
        }
        
        $flexForm = tx_apimacmade::getPhp5Class(
            'flexform',
            array( $conf[ 'row' ][ $conf[ 'field' ] ] )
        );
        
        $controller = ( string )$flexForm->controller;
        $items      = array();
        
        foreach( t3lib_div::trimExplode( ',', self::$controllers[ $controller ] ) as $action ) {
            
            $items[] = array(
                $action,
                $action,
                ''
            );
        }
        
        $conf[ 'items' ] = array_merge( $conf[ 'items' ], $items );
    }
    
}

class user_Tx_Powered_Utility_FlexForm_ActionControllerManager extends Tx_Powered_Utility_FlexForm_ActionControllerManager
{
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Utility/FlexForm/ActionControllerManager.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/Utility/FlexForm/ActionControllerManager.php']);
}
