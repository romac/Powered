<?php

/***************************************************************
 * Copyright notice
 *
 * (c) 2010 Nikolas Hagelstein, Romain Ruetschi (romain.ruetschi@gmail.com)
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
 * Source file containing class Tx_Powered_MVC_Controller_AbstractMultiStepFormController.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Nikolas Hagelstein, Romain Ruetschi <romain.ruetschi@gmail.com>
 * @see        Tx_Powered_MVC_Controller_AbstractMultiStepFormController
 */

/**
 * Class Tx_Powered_MVC_Controller_AbstractMultiStepFormController.
 * 
 * An abstract multi-step form controller.
 * 
 * @link       http://typo3blogger.de/extbasefluid-multi-step-form-controller-1/
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Nikolas Hagelstein, Romain Ruetschi <romain.ruetschi@gmail.com>
 */
abstract class  Tx_Powered_MVC_Controller_AbstractMultiStepFormController
extends         Tx_Extbase_MVC_Controller_ActionController
{
    
    /**
	 * Session storage key used.
	 *
	 * @var string
	 */
	protected $sessionDataStorageKey;
 
	/**
	 * The session data container.
	 *
	 * @var array
	 */
	protected $sessionData = array();
 
	/**
	 * The actual form data.
	 *
	 * @var array
	 */
	protected $formData;
 
	/**
	 * A list of action names that have been passed successfully.
	 *
	 * @var array
	 */
	protected $passedActionMethodNames;
 
	/**
	 * A list of action names that have to be passed before the final action can be executed.
	 *
	 * @var array
	 */
	protected $mandatoryActionMethodNames;
 
	/**
	 * The action methode name of the first action.
	 *
	 * @var string
	 */
	protected $firstActionMethodName;
 
	/**
	 * The action methode name of the first action.
	 *
	 * @var string
	 */
	protected $finalActionMethodName;
 
	/**
	 * Handles session/argument interaction to ensure correct validation. Furthermore
	 * takes care of mandatory actions.
	 *
	 * @return void
	 */
	protected function initializeAction()
	{
		$this->loadSessionData();
 
		if( $this->isFinalAction() && !$this->passedMandatoryActions() )
		{
			$this->redirect( $this->firstActionMethodName );
		}
 
		if( $this->formData === NULL )
		{
			if( !$this->isFirstAction() ) 
		    {
				$this->redirect( $this->firstActionMethodName );
			}
			else
			{
				$this->formData = array();
			}
		}
 
		$requestArguments = $this->request->getArguments();
 
		foreach( $this->arguments->getArgumentNames() as $argumentName )
		{
			if( array_key_exists( $argumentName, $requestArguments ) )
			{
				$this->formData[ $argumentName ] = $requestArguments[ $argumentName ];
			}
			else
			{
				if( array_key_exists( $argumentName, $this->formData ) )
				{
					$requestArguments[ $argumentName ] = ( string )$this->formData[ $argumentName ];
					
					$key = 'tx_' . strtolower( $this->extensionName )
					     . '_'   . strtolower( $this->request->getPluginName() );
					     
					$_POST[ $key ][ $argumentName ] = ( string )$this->formData[ $argumentName ];
				}
			}
		}
 
		$this->request->setArguments( $requestArguments );
 
		$this->storeSessionData();
	}
 
	/**
	 * We use initializeView to determin if a certain action has been reached
	 * and all it's validation has been passed successful.
	 *
	 * @return void
	 */
	protected function initializeView()
	{
		$this->passedActionMethodNames[ $this->actionMethodName ] = TRUE;
		
		$this->storeSessionData();
 
	}
 
	/**
	 * Returns if this is the first action.
	 *
	 * @return boolean
	 */
	protected function isFirstAction()
	{
		return $this->actionMethodName === $this->firstActionMethodName;
	}
 
	/**
	 * Returns if this is the final action.
	 *
	 * @return boolean
	 */
	protected function isFinalAction()
	{
		return $this->actionMethodName === $this->finalActionMethodName;
	}
 
	/**
	 * Checks if all mandatory actions have been passed.
	 *
	 * @return boolean
	 */
	protected function passedMandatoryActions()
	{
		foreach( $this->mandatoryActionMethodNames as $mandatoryActionMethodeName )
		{
			if( $this->passedActionMethodNames[ $mandatoryActionMethodeName ] === NULL )
			{
				return FALSE;
			}
		}
		
		return TRUE;
	}
 
	/**
	 * Loads data from session and populates formData and passedActionMethodeNames.
	 *
	 * @return void
	 */
	protected function loadSessionData()
	{
		$this->sessionData = $GLOBALS[ 'TSFE' ]->fe_user->getKey( 'ses', $this->sessionDataStorageKey );
		$this->formData    = $this->sessionData[ 'formData' ];
		
		$this->passedActionMethodNames = $this->sessionData[ 'passedActionMethodNames' ];
	}
 
	/**
	 * Stores data to session. Including formData and passedActionMethodeNames.
	 *
	 * @return void
	 */
	protected function storeSessionData()
	{
		$this->sessionData[ 'formData' ]                = $this->formData;
		$this->sessionData[ 'passedActionMethodNames' ] = $this->passedActionMethodNames;
 
		$GLOBALS[ 'TSFE' ]->fe_user->setKey( 'ses', $this->sessionDataStorageKey, $this->sessionData );
		$GLOBALS[ 'TSFE' ]->fe_user->storeSessionData();
	}
 
	protected function clearSessionData()
	{
		$this->sessionData = array();
 
		$GLOBALS[ 'TSFE' ]->fe_user->setKey( 'ses', $this->sessionDataStorageKey, $this->sessionData );
		$GLOBALS[ 'TSFE' ]->fe_user->storeSessionData();
	}
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractMultiStepFormController.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/MVC/Controller/AbstractMultiStepFormController.php']);
}
