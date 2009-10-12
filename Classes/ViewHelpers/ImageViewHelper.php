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
 * Source file containing class Tx_Powered_ViewHelpers_ImageViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 * @see        Tx_Powered_ViewHelpers_ImageViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_ImageViewHelper.
 * 
 * Description for class Tx_Powered_ViewHelpers_ImageViewHelper.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @version    $Id$
 */
class Tx_Powered_ViewHelpers_ImageViewHelper extends Tx_Fluid_ViewHelpers_ImageViewHelper
{
    
    // /**
    //  * Initialize arguments.
    //  *
    //  * @return void
    //  */
    // public function initializeArguments()
    // {
    //     parent::initializeArguments();
    //     
    //     $this->registerUniversalTagAttributes();
    //     
    //     $this->registerTagAttribute(
    //         'alt',
    //         'string',
    //         'Specifies an alternate text for an image',
    //         FALSE
    //     );
    //     
    //     $this->registerTagAttribute(
    //         'ismap',
    //         'string',
    //         'Specifies an image as a server-side image-map. Rarely used. Look at usemap instead',
    //         FALSE
    //     );
    //     
    //     $this->registerTagAttribute(
    //         'longdesc',
    //         'string',
    //         'Specifies the URL to a document that contains a long description of an image',
    //         FALSE
    //     );
    //     
    //     $this->registerTagAttribute(
    //         'usemap',
    //         'string',
    //         'Specifies an image as a client-side image-map',
    //         FALSE
    //     );
    // }
    
}

/**
 * XCLASS inclusion
 */
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/ImageViewHelper.php']) {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/powered/Classes/ViewHelpers/ImageViewHelper.php']);
}
