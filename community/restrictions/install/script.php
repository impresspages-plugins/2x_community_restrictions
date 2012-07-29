<?php
/**
 * @package     ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license     GNU/GPL, see ip_license.html
 */

namespace Modules\community\restrictions;

if (!defined('CMS')) exit; //this file can't bee accessed directly

require_once(BASE_DIR.MODULE_DIR.'developer/zones/manager.php');

class Install
{

    public function execute()
    {
        global $site;


        $sql = "
            CREATE TABLE IF NOT EXISTS `" . DB_PREF . "m_community_restrictions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `row_number` int(11) NOT NULL,
                `title` varchar(255) DEFAULT NULL,
                `userId` varchar(255) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . " " . mysql_error());
        }

        $sql = "
            CREATE TABLE IF NOT EXISTS `" . DB_PREF . "m_community_restrictions_to_page` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `ruleId` int(11) NOT NULL,
                `languageId` int(11) NOT NULL,
                `zoneName` varchar(50) DEFAULT NULL,
                `pageId` varchar(50) DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . " " . mysql_error());
        }


        $userZone = $site->getZoneByModule('community', 'user');

        if (!$userZone) {
            $this->createUserZone('User');
        }

    }

    private function createUserZone($title)
    {

        global $site;
        $name = preg_replace("/[^a-zA-Z0-9\s]/", "", $title);
        $name = strtolower($name);
        if ($name == '') {
            $name = 'news';
        }

        $i = null;
        while ($site->getZone($name . $i)) {
            $i++;
        }

        $name = $name . $i;

        $sql = "
        INSERT INTO `" . DB_PREF . "zone` SET
        `row_number` = '" . (int)$this->newRowNumber() . "',
        `name` = '" . mysql_real_escape_string($name) . "',
        `template` = '" . mysql_real_escape_string($this->getTemplate()) . "',
        `translation` = '" . mysql_real_escape_string($title) . "',
        `associated_group` = 'community',
        `associated_module` = 'user'
        ";

        $rs = mysql_query($sql);
        $zoneId = mysql_insert_id();
        if ($rs) {
            $zonesModule = new \Modules\developer\zones\ZonesArea();
            $zonesModule->after_insert($zoneId);
        } else {
            trigger_error($sql . " " . mysql_error());
        }
    }

    private function newRowNumber()
    {
        $sql = "
        SELECT max(row_number) as max_row_number FROM `" . DB_PREF . "zone` WHERE 1";

        $rs = mysql_query($sql);
        if ($rs) {
            if ($lock = mysql_fetch_assoc($rs)) {
                return $lock['max_row_number'] + 1;
            } else {
                return false;
            }
        } else {
            trigger_error($sql . " " . mysql_error());
            return false;
        }


    }

    private function getTemplate() {
        global $site;
        $contentManagementZone = $site->getZoneByModule('standard', 'content_management');
        if ($contentManagementZone) {
            return $contentManagementZone->getLayout();
        }

        require_once(BASE_DIR.MODULE_DIR.'developer/zones/db.php');
        $db = new \Modules\developer\zones\Db();

        return $db->getDefaultTemplate();
        if (count($templates)) {
            return array_pop($templates);
        }

        return '';
    }

}
