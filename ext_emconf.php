<?php

$EM_CONF[ $_EXTKEY ] = array(
    'title' => 'Powered',
    'description' => 'Provides additional features on the top of Extbase and Fluid.',
    'category' => 'fe',
    'author' => 'Romain Ruetschi',
    'author_company' => 'kryzalid.com',
    'author_email' => 'romain.ruetschi@gmail.com',
    'shy' => '',
    'dependencies' => 'extbase,fluid',
    'suggests' => 'pagebrowse,api_macmade',
    'conflicts' => '',
    'priority' => '',
    'module' => '',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '0.2.1',
    'constraints' => array(
        'depends' => array(
            'php' => '5.2.0-0.0.0',
            'typo3' => '4.3.0-4.4.99',
            'extbase' => '1.0.0-',
            'fluid' => '1.0.0-',
            'api_macmade' => '0.4.7-',
        ),
        'conflicts' => array(
        ),
        'suggests' => array(
            'pagebrowse' => '1.0.1',
            'api_macmade' => '0.4.7'
        ),
    ),
);

?>