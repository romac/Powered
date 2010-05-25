<?php

########################################################################
# Extension Manager/Repository config file for ext "powered".
#
# Auto generated 19-04-2010 09:27
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Powered',
	'description' => 'Provides additional features on the top of Extbase and Fluid.',
	'category' => 'fe',
	'author' => 'Romain Ruetschi',
	'author_company' => 'kryzalid.com',
	'author_email' => 'romain@kryzalid.com',
	'shy' => '',
	'dependencies' => 'extbase,fluid,api_macmade',
	'suggests' => 'pagebrowse',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.3.0-4.3.99',
			'extbase' => '1.0.0-',
			'fluid' => '1.0.0-',
			'api_macmade' => '0.4.7-0.5.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'pagebrowse' => '1.0.1',
		),
	),
	'_md5_values_when_last_written' => 'a:29:{s:12:"README.mdown";s:4:"2b40";s:12:"ext_icon.gif";s:4:"7edc";s:17:"ext_localconf.php";s:4:"3686";s:21:"Classes/Exception.php";s:4:"b2c1";s:43:"Classes/Exception/NoSuchCacheIdentifier.php";s:4:"630b";s:40:"Classes/Exception/NoSuchObjectMethod.php";s:4:"57f9";s:38:"Classes/Exception/NoSuchRepository.php";s:4:"7069";s:38:"Classes/Helper/RepositoryContainer.php";s:4:"956a";s:43:"Classes/MVC/Controller/ActionController.php";s:4:"5814";s:41:"Classes/MVC/Controller/RestController.php";s:4:"d2ca";s:32:"Classes/MVC/View/ViewAdapter.php";s:4:"86ce";s:34:"Classes/MVC/View/ViewInterface.php";s:4:"51ea";s:34:"Classes/Persistence/Repository.php";s:4:"05ba";s:33:"Classes/Utility/CacheProvider.php";s:4:"6463";s:52:"Classes/Utility/FlexForm/ActionControllerManager.php";s:4:"245c";s:45:"Classes/Validation/Validator/URLValidator.php";s:4:"ae31";s:40:"Classes/ViewHelpers/AssignViewHelper.php";s:4:"e3d4";s:39:"Classes/ViewHelpers/DebugViewHelper.php";s:4:"7189";s:40:"Classes/ViewHelpers/DisqusViewHelper.php";s:4:"4238";s:37:"Classes/ViewHelpers/ForViewHelper.php";s:4:"ee83";s:36:"Classes/ViewHelpers/IfViewHelper.php";s:4:"d94f";s:39:"Classes/ViewHelpers/ImageViewHelper.php";s:4:"193e";s:37:"Classes/ViewHelpers/Md5ViewHelper.php";s:4:"de8c";s:45:"Classes/ViewHelpers/PageBrowserViewHelper.php";s:4:"f36d";s:45:"Classes/ViewHelpers/Format/HtmlViewHelper.php";s:4:"3fbb";s:48:"Classes/ViewHelpers/Format/ImplodeViewHelper.php";s:4:"2603";s:50:"Classes/ViewHelpers/Format/StripTagsViewHelper.php";s:4:"76fe";s:45:"Classes/ViewHelpers/Format/TrimViewHelper.php";s:4:"0f77";s:45:"Classes/ViewHelpers/Object/CallViewHelper.php";s:4:"d5b6";}',
);

?>