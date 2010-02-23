<?php

/**
 * TYPO3 extension manager configuration.
 *
 * @author    Romain Ruetschi <romain@kryzalid.com>
 * @version   $Id$
 * @copyright kryzalid, 19 June, 2009
 * @package   Powered
 */

/**
 * Fill the configuration array for this extension.
 **/
$EM_CONF[ $_EXTKEY ] = array(
    'title'                         => 'Powered',
    'description'                   => 'Provides additional features on the top of Extbase and Fluid.',
    'category'                      => 'fe',
    'author'                        => 'Romain Ruetschi',
    'author_company'                => 'kryzalid',
    'author_email'                  => 'romain@kryzalid.com',
    'shy'                           => '',
    'dependencies'                  => 'api_macmade, extbase, fluid',
    'suggests'                      => 'pagebrowse',
    'conflicts'                     => '',
    'priority'                      => '',
    'module'                        => '',
    'state'                         => 'alpha',
    'internal'                      => '',
    'uploadfolder'                  => false,
    'createDirs'                    => '',
    'modify_tables'                 => '',
    'clearCacheOnLoad'              => true,
    'lockType'                      => '',
    'version'                       => '0.1.0',
    'constraints'                   => array(
        'depends'   => array(
            'php'         => '5.2.0-0.0.0',
            'typo3'       => '4.3.0-4.3.99',
            'extbase'     => '1.0.0-',
            'fluid'       => '1.0.0-',
            'api_macmade' => '0.4.7-0.5.0'
        ),
        'conflicts' => array(),
        'suggests'  => array(
            'pagebrowse' => '1.0.1'
        ),
    ),
    '_md5_values_when_last_written' => ''
);

?>