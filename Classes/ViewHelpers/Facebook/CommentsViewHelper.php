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
 * Source file containing class Tx_Powered_ViewHelpers_Facebook_CommentsViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 * @see        Tx_Powered_ViewHelpers_Facebook_CommentsViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_Facebook_CommentsViewHelper.
 * 
 * This view helper renders the Facebook comment box.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain.ruetschi@gmail.com>
 */
class Tx_Powered_ViewHelpers_Facebook_CommentsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * Render the Facebook comment box.
     *
     * @param string $identifier A unique identifier for the thread.
     * @param integer $numberOfPosts The number of comments to show.
     * @param integer $width The width of the comment box.
     * @return string The Facebook comment box.
     */
    public function render( $identifier = '', $numberOfPosts = 10, $width = 550 )
    {
        $arguments = array();
        
        if( $identifier )
        {
            $arguments[ 'xid' ]      = $identifier;
        }
        
        if( $numberOfPosts = ( int )$numberOfPosts )
        {
            $arguments[ 'numposts' ] = $numberOfPosts;
        }
        
        if( $width = ( int )$width )
        {
            $arguments[ 'width' ]    = $width;
        }
        
        $attributes = ( $arguments ) ? $this->renderArguments( $arguments ) : '';
        
        $html = '<script type="text/javascript">'
              . 'window.fbAsyncInit = function()' . "\n"
              . '{' . "\n"
              . '    FB.init( {' . "\n"
              . '        appId  : \'YOUR APP ID\',' . "\n"
              . '        status : true,' . "\n"
              . '        cookie : true,' . "\n"
              . '        xfbml  : true' . "\n"
              . '    } );' . "\n"
              . '}' . "\n"
              . '' . "\n"
              . '( function()' . "\n"
              . '{' . "\n"
              . '    var e   = document.createElement( \'script\' );' . "\n"
              . '    e.src   = document.location.protocol + \'//connect.facebook.net/fr_FR/all.js\';' . "\n"
              . '    e.async = true;' . "\n"
              . '' . "\n"
              . '    document.body.appendChild( e );' . "\n"
              . '' . "\n"
              . '}() );' . "\n"
              . '</script>' . "\n"
              . '<fb:comments' . $attributes . '></fb:comments>' . "\n";
                
        return $html;
    }
    
    /**
     * Render the tag arguments.
     *
     * @param  array $arguments The arguments
     * @return string
     * @author Romain Ruetschi <romain@kryzalid.com>
     */
    protected function renderArguments( array $arguments )
    {
        $str = '';
        
        foreach( $arguments as $attribute => $value )
        {
            $str .= ' ' . $attribute . '="' . $value . '"';
        }
        
        return $str;
    }
    
}