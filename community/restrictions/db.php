<?php
/**
 * @package     ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license     GNU/GPL, see ip_license.html
 */

namespace Modules\community\restrictions;

if (!defined('CMS')) exit; //this file can't be acessed directly

class Db {
    /**
     * define restriction to the page
     * @param int $userId
     * @return boolean restrict access to current page or not
     */
    public static function restrictPage($userId = null) {
        global $site;

        if ($userId == null) {
            $userId = System::getUserId();
        }

        $ruleId = false;
        $result = self::getRelevantRuleForSpecificUser($userId);
        if ($userId == -1) {
            if ($result && $result['id'] > 0) { // rule exist
                $ruleId = $result['id'];
            }
        } elseif ($userId >= 0) {
            $ruleId = false;
            if ($result && $result['id'] > 0) { // rule exist for specific user
                $ruleId = $result['id'];
            } else {
                $result = self::getRelevantRuleForSpecificUser(0);
                if ($result && $result['id'] > 0) { // rule exist for logged in user
                    $ruleId = $result['id'];
                }
            }
        }
        if ($ruleId) {
            $isLanguageDenied = self::getLanguageRules($ruleId);
            if ($isLanguageDenied) {
                return true;
            }
            $isZoneDenied = self::getZoneRules($ruleId);
            if ($isZoneDenied) {
                return true;
            }
            $isElementDenied = self::getElementRules($ruleId);
            if ($isElementDenied) {
                return true;
            }
        }
        return false;
    }

    public static function getRelevantRuleForSpecificUser($userId) {

        $sql = "
            SELECT
                id, title
            FROM
                " . DB_PREF . "m_community_restrictions r
            WHERE
                r.userId = '" . (int) $userId . "'
            ORDER BY
                row_number asc
            LIMIT 1;
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find rules by " . $sql . ' ' . mysql_error());
            return false;
        }

        if($lock = mysql_fetch_assoc($rs)) {
            return $lock;
        } else {
            return false; // there are no rules for the user
        }
    }

    /**
     * get rules by rule id for specified or current language
     * @param int $ruleId
     * @param int $languageId
     * @return array with languageId or false
     */
    public static function getLanguageRules($ruleId, $languageId = null) {
        global $site;

        if ($languageId == null) {
            $languageId = $site->getCurrentLanguage()->getId();
        }

        $sql = "
            SELECT
                rtp.languageId as languageId
            FROM
                " . DB_PREF . "m_community_restrictions r,
                " . DB_PREF . "m_community_restrictions_to_page rtp
            WHERE
                r.id = '" . (int) $ruleId . "' AND
                r.id = rtp.ruleId AND
                rtp.languageId = '" . (int) $languageId . "' AND
                rtp.zoneName IS NULL AND
                rtp.pageId IS NULL
            LIMIT 1;
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find rules by " . $sql . ' ' . mysql_error());
            return false;
        }

        if($lock = mysql_fetch_assoc($rs)) {
            return $lock;
        } else {
            return false; // there are no rules for the user
        }
    }

    /**
     * get rules by rule id for specified or current language and zone
     * @param int $ruleId
     * @param int $languageId
     * @param string $zoneName
     * @return array with languageId and zoneName or false
     */
    public static function getZoneRules($ruleId, $languageId = null, $zoneName = null) {
        global $site;

        if ($languageId == null) {
          $languageId = $site->getCurrentLanguage()->getId();
        }

        if ($zoneName == null) {
          $zoneName = $site->getCurrentZone()->getName();
        }

        $sql = "
            SELECT
                rtp.languageId as languageId, rtp.zoneName as zoneName
            FROM
                " . DB_PREF . "m_community_restrictions r,
                " . DB_PREF . "m_community_restrictions_to_page rtp
            WHERE
                r.id = '" . (int) $ruleId . "' AND
                r.id = rtp.ruleId AND
                rtp.languageId = '" . (int) $languageId . "' AND 
                rtp.zoneName = '" . mysql_real_escape_string($zoneName) . "' AND
                rtp.pageId IS NULL
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find rules by " . $sql . ' ' . mysql_error());
            return false;
        }

        if($lock = mysql_fetch_assoc($rs)) {
            return $lock;
        } else {
            return false; // there are no rules for the user
        }
    }

    /**
     * get rules by rule id for specified or current element
     * @param int $ruleId
     * @param Element $element
     * @return array with languageId and zoneName and pageId or false
     */
    public static function getElementRules($ruleId, $element = null) {
        global $site;

        if ($element == null) {
            $element = $site->getCurrentElement();
        }

        $sql = "
            SELECT
                rtp.languageId as languageId, rtp.zoneName as zoneName, rtp.pageId as pageId
            FROM
                " . DB_PREF . "m_community_restrictions r,
                " . DB_PREF . "m_community_restrictions_to_page rtp
            WHERE
                r.id = '" . (int) $ruleId . "' AND
                r.id = rtp.ruleId AND
                rtp.pageId = " . (int) $element->getId() . "
        ";

        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error("Can't find rules by " . $sql . ' ' . mysql_error());
            return false;
        }

        if($lock = mysql_fetch_assoc($rs)) {
            return $lock;
        } else {
            return false; // there are no rules for the user
        }
    }

    public static function insertLanguageRule($languageId, $ruleId) {
        $sql = "
            INSERT INTO
                `" . DB_PREF . "m_community_restrictions_to_page`
            SET
                `ruleId` = " . (int) $ruleId . ",
                `languageId` = " . (int) $languageId . ",
                `zoneName` = NULL,
                `pageId` = NULL
            ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }

    public static function insertZoneRule($languageId, $zoneName, $ruleId) {
        $sql = "
            INSERT INTO
                `" . DB_PREF . "m_community_restrictions_to_page`
            SET
                `ruleId` = " . (int) $ruleId . ",
                `languageId` = " . (int) $languageId . ",
                `zoneName` = '" . mysql_real_escape_string($zoneName) . "',
                `pageId` = NULL
            ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }

    public static function insertPageRule($languageId, $zoneName, $pageId, $ruleId) {
        $sql = "
            INSERT INTO
                `" . DB_PREF . "m_community_restrictions_to_page`
            SET
                `ruleId` = " . (int) $ruleId . ",
                `languageId` = " . (int) $languageId . ",
                `zoneName` = '" . mysql_real_escape_string($zoneName) . "',
                `pageId` = " . (int) $pageId . "
        ";
        $rs = mysql_query($sql);
        if (!$rs) {
            trigger_error($sql . ' ' . mysql_error());
        }
    }

}
