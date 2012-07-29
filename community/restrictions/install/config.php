<?php
//language description
$languageCode = "en"; //RFC 4646 code
$languageShort = "EN"; //Short description
$languageLong = "English"; //Long title
$languageUrl = "en";


$moduleTitle["community"]["restrictions"] = "Restrictions";
  
  $parameterGroupTitle["community"]["restrictions"]["options"] = "Options";
  $parameterGroupAdmin["community"]["restrictions"]["options"] = "1";

    $parameterTitle["community"]["restrictions"]["options"]["excluded_zones"] = "Excluded zones";
    $parameterValue["community"]["restrictions"]["options"]["excluded_zones"] = "";
    $parameterAdmin["community"]["restrictions"]["options"]["excluded_zones"] = "0";
    $parameterType["community"]["restrictions"]["options"]["excluded_zones"] = "textarea";

    $parameterTitle["community"]["restrictions"]["options"]["controlled_blocks"] = "Controlled content blocks";
    $parameterValue["community"]["restrictions"]["options"]["controlled_blocks"] = "main";
    $parameterAdmin["community"]["restrictions"]["options"]["controlled_blocks"] = "0";
    $parameterType["community"]["restrictions"]["options"]["controlled_blocks"] = "textarea";

    $parameterTitle["community"]["restrictions"]["options"]["show_login"] = "Show login for anonymous users";
    $parameterValue["community"]["restrictions"]["options"]["show_login"] = "1";
    $parameterAdmin["community"]["restrictions"]["options"]["show_login"] = "0";
    $parameterType["community"]["restrictions"]["options"]["show_login"] = "bool";

    $parameterTitle["community"]["restrictions"]["options"]["show_message"] = "Show message for logged in users";
    $parameterValue["community"]["restrictions"]["options"]["show_message"] = "<p>You are not allowed to access the content of this page.</p>";
    $parameterAdmin["community"]["restrictions"]["options"]["show_message"] = "0";
    $parameterType["community"]["restrictions"]["options"]["show_message"] = "lang_wysiwyg";

  $parameterGroupTitle["community"]["restrictions"]["translations"] = "Translations";
  $parameterGroupAdmin["community"]["restrictions"]["translations"] = "1";

    $parameterTitle["community"]["restrictions"]["translations"]["restriction_rules"] = "Restriction rules";
    $parameterValue["community"]["restrictions"]["translations"]["restriction_rules"] = "Restriction rules";
    $parameterAdmin["community"]["restrictions"]["translations"]["restriction_rules"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["restriction_rules"] = "string";

    $parameterTitle["community"]["restrictions"]["translations"]["title"] = "Rule title";
    $parameterValue["community"]["restrictions"]["translations"]["title"] = "Rule title";
    $parameterAdmin["community"]["restrictions"]["translations"]["title"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["title"] = "string";

    $parameterTitle["community"]["restrictions"]["translations"]["select_user"] = "Select user";
    $parameterValue["community"]["restrictions"]["translations"]["select_user"] = "Select user";
    $parameterAdmin["community"]["restrictions"]["translations"]["select_user"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["select_user"] = "string";

    $parameterTitle["community"]["restrictions"]["translations"]["anonymous_user"] = "Anonymous user";
    $parameterValue["community"]["restrictions"]["translations"]["anonymous_user"] = " * Anonymous user * ";
    $parameterAdmin["community"]["restrictions"]["translations"]["anonymous_user"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["anonymous_user"] = "string";

    $parameterTitle["community"]["restrictions"]["translations"]["logged_in_user"] = "Logged in user";
    $parameterValue["community"]["restrictions"]["translations"]["logged_in_user"] = " * Logged in user * ";
    $parameterAdmin["community"]["restrictions"]["translations"]["logged_in_user"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["logged_in_user"] = "string";

    $parameterTitle["community"]["restrictions"]["translations"]["restricted_pages"] = "Restricted pages";
    $parameterValue["community"]["restrictions"]["translations"]["restricted_pages"] = "Restricted pages";
    $parameterAdmin["community"]["restrictions"]["translations"]["restricted_pages"] = "0";
    $parameterType["community"]["restrictions"]["translations"]["restricted_pages"] = "string";
