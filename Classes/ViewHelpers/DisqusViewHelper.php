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
 * Source file containing class Tx_Powered_ViewHelpers_DisqusViewHelper.
 * 
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 * @see        Tx_Powered_ViewHelpers_DisqusViewHelper
 */

/**
 * Class Tx_Powered_ViewHelpers_DisqusViewHelper.
 * 
 * This view helper renders the Disqus comment box.
 *
 * @package    Powered
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2
 * @author     Romain Ruetschi <romain@kryzalid.com>
 */
class Tx_Powered_ViewHelpers_DisqusViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper
{
    
    /**
     * Render the Disqus comment box.
     *
     * @param string $site The name of the site registered in Disqus (alphanumeric and hyphens only.)
     * @param array $options An array of options that'll be rendered as global variables prefixed with disqus_.
     * @return string The Disqus comment box.
     * @author Romain Ruetschi <romain.ruetschi@gmail.com>
     */
    public function render( $site, array $options = array() )
    {
        $content   = array();
        $content[] = '<div id="disqus_thread"></div>';
        $content[] = $this->renderOptions( $options );
        $content[] = '<script type="text/javascript">';
        $content[] = '// <![CDATA[';
        $content[] = '';
        $content[] = '( function()';
        $content[] = '{';
        $content[] = '    var dsq       = document.createElement( \'script\' );';
        $content[] = '        dsq.type  = \'text/javascript\';';
        $content[] = '        dsq.async = true;';
        $content[] = '        dsq.src   = \'http://' . $site . '.disqus.com/embed.js\';';
        $content[] = '';
        $content[] = '    (';
        $content[] = '        document.getElementsByTagName( \'head\' )[ 0 ]';
        $content[] = '        ||';
        $content[] = '        document.getElementsByTagName( \'body\' )[ 0 ]';
        $content[] = '';
        $content[] = '    ).appendChild( dsq );';
        $content[] = '';
        $content[] = '  } )();';
        $content[] = '';
        $content[] = '// ]]>';
        $content[] = '</script>';
        $content[] = '<noscript>';
        $content[] = '    Please enable JavaScript to view the';
        $content[] = '    <a href="http://disqus.com/?ref_noscript=' . $site . '">';
        $content[] = '        comments powered by Disqus.';
        $content[] = '    </a>';
        $content[] = '</noscript>';
        
        return implode( chr( 10 ), $content );
    }
    
    protected function renderOptions( array $options, $prefix = 'disqus_' )
    {
        if( !$options ) {
            
            return '';
        }
        
        $content = array();
        
        $content[] = '<script type="text/javascript" charset="utf-8">';
        $content[] = '// <![CDATA[';
        
        foreach( $options as $label => $value ) {
            
            $content[] = 'var ' . $prefix . $label . ' = ' . $value . ';';
        }
        
        $content[] = '// ]]>';
        $content[] = '</script>';
        
        return implode( chr( 10 ), $content );
    }
    
}