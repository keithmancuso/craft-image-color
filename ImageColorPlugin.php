<?php
namespace Craft;

class ImageColorPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Image Color');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Familiar';
    }

    function getDeveloperUrl()
    {
        return 'http://familiar-studio.com';
    }
	
	public function init()
    {
    
    	/*
craft()->on('assets.onSaveFileContent', function(Event $event) {
	
			craft()->imageColor->saveColors($event->params['asset']);
		});
		
*/
    
    }
	
    public function hookAddTwigExtension()
    {
        Craft::import('plugins.imagecolor.twigextensions.ImageColorTwigExtension');
        return new ImageColorTwigExtension();
    }
}