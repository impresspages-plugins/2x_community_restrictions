<?php
/**
 * @package     ImpressPages
 * @copyright   Copyright (C) 2011 ImpressPages LTD.
 * @license     GNU/GPL, see ip_license.html
 */

namespace Modules\community\restrictions;

if (!defined('BACKEND')) exit; //this file can't be accessed directly

require_once(BASE_DIR.MODULE_DIR.'developer/std_mod/std_mod.php'); //include standard module to manage data records

class ItemsArea extends \Modules\developer\std_mod\Area{ //extending standard data management module area

    function __construct(){
        global $parametersMod; //global object to get parameters

        parent::__construct(
            array(
                'dbTable' => 'm_community_restrictions', //table of data we need to manage
                'title' => $parametersMod->getValue('community', 'restrictions', 'translations', 'restriction_rules'), //Table title above the table (choose any)
                'dbPrimaryKey' => 'id', //Primary key of that table
                'searchable' => true, //User will have search button or not
                'orderBy' => 'row_number', //Database field, by which the records should be ordered by default
                'sortable' => true, //Does user have a right to change the order of records
                'sortField' => 'row_number' //Database field which is used to sort records
            )
        );

        $element = new \Modules\developer\std_mod\ElementText(
            array(
                'title' => $parametersMod->getValue('community', 'restrictions', 'translations', 'title'), //Field name
                'showOnList' => true, //Show field value in list of all records
                'dbField' => 'title', //Database field name
                'previewLength' => 100,
                'searchable' => true //Allow to search by this field
            )
        );
        $this->addElement($element);

        $values = array();
        $values[] = array(-1, $parametersMod->getValue('community', 'restrictions', 'translations', 'anonymous_user'));
        $values[] = array(0, $parametersMod->getValue('community', 'restrictions', 'translations', 'logged_in_user'));
        $sql = "select id, login, verified from ".DB_PREF."m_community_user";
        $rs = mysql_query($sql);
        if ($rs) {
            while ($lock = mysql_fetch_assoc($rs)) {
                $values[] = array($lock['id'],$lock['login'].($lock['verified']?' (+)':' (-)'));
            }
        } else {
            trigger_error($sql." ".mysql_error());
        }
        $element = new \Modules\developer\std_mod\ElementSelect(
            array(
                'title' => $parametersMod->getValue('community', 'restrictions', 'translations', 'select_user'), //Field name
                'showOnList' => true, //Show field value in list of all records
                'dbField' => 'userId', //Database field name
                'values' => $values,
                'searchable' => true //Allow to search by this field
            )
        );
        $this->addElement($element);

        require_once(__DIR__.'/element_pages.php');
        $element = new ElementPages(
            array (
                'title' => $parametersMod->getValue('community', 'restrictions', 'translations', 'restricted_pages'),
                'showOnList' => false, //Show field value in list of all records
                'searchable' => false
            )
        );
        $this->addElement($element);

    }

}
