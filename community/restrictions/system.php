<?php
/**
 * @package     ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license     GNU/GPL, see ip_license.html
 */

namespace Modules\community\restrictions;

if (!defined('CMS')) exit;

class System{

    function init(){
        global $dispatcher;
        $dispatcher->bind('site.generateBlock', __NAMESPACE__ .'\System::restrictContent');
    }

    public static function restrictContent (\Ip\Event $event) {
        global $site;
        global $parametersMod;

        if (!$site->managementState()) { // denying access only if not in management state
            $controlledBlocks = explode("\n", $parametersMod->getValue('community', 'restrictions', 'options', 'controlled_blocks'));
            foreach ($controlledBlocks as $block) {
                if ( $block == $event->getValue('blockName') ) {
                    $isFirstBlock = $controlledBlocks[0] == $block ? true : false;
                    if (self::getUserId() == -1 && Db::restrictPage()) { // not logged in user
                        if ($isFirstBlock && $parametersMod->getValue('community', 'restrictions', 'options', 'show_login')) {
                            $userZone = $site->getZoneByModule('community', 'user');
                            $content = $userZone->generateLogin();
                            $event->setValue('content', $content);
                        } else {
                            $event->setValue('content', '');
                        }
                        $event->addProcessed();
                    } elseif (self::getUserId() >= 0 && Db::restrictPage()) { // logged in user
                        if ($isFirstBlock) { // printing content only to the first block
                            $content = $parametersMod->getValue('community', 'restrictions', 'options', 'show_message');
                            $event->setValue('content', $content);
                        } else {
                            $event->setValue('content', '');
                        }
                        $event->addProcessed();
                    }
                }
            }
        }
    }

    public static function getUserId() {
        global $session;
        if($session->loggedIn()){
            return $session->userId();
        } else {
            return -1; // not logged in user identifier; look at items_area.php
        }
    }
}
