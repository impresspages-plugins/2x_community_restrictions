<?php
/**
 * @package     ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license     GNU/GPL, see ip_license.html
 */

namespace Modules\community\restrictions;

if (!defined('CMS')) exit;

class Uninstall{

    public function execute(){

        $sql="
        DROP TABLE IF EXISTS `".DB_PREF."m_community_restrictions`;
        ";

        $rs = mysql_query($sql);
        if(!$rs){
            trigger_error($sql." ".mysql_error());
        }

        $sql="
        DROP TABLE IF EXISTS `".DB_PREF."m_community_restrictions_to_page`;
        ";

        $rs = mysql_query($sql);
        if(!$rs){
            trigger_error($sql." ".mysql_error());
        }
    }
}
