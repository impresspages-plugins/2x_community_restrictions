RESTRICTIONS

ImpressPages CMS plugin


INSTALL

1. Upload folder "community" to "ip_plugins" directory of your website.
2. Login to administration area
3. Go to developer > modules and press "install".
4. Refresh web browser (F5).
5. Now you will see a new tab Community -> Restrictions. Here you can add rules to associate them to required pages (Elements), zones or languages.


CONFIGURATION

Please have a look at configuration options in Developer -> Modules Config tab.
- Excluded zones                   Define zones that should be hidden from selection. You can append "*" - asterisk to the end of zone
                                   name to hide all pages of the zone, but not the zone itself.
- Controlled content blocks        Define block of your template that should be hidden on restrictions in affect. By default
                                   it's 'main'. Login form or restriction message will be shown on the first block in the list)
- Show login for anonymous users   Define whether to show login form for anonymous user on restricted page (prints default user login form)
- Show message for logged in users Define message for logged in user on restricted page (language aware)


USAGE

Assign rules to:
- anonymous user (not logged in)
- logged in user (all of them)
- specific user (+/- sign tells your whether user verified or not)

Selection works in a logical order:
- if language is selected all zones and pages will be closed down
- if zone is selected all its pages will be closed down
- if page is selected only the particular page will be close down


This plugin allows you to define as many rules as you want. It means some of them may overlap.
The login comes in the most specific rule order:
- rules for anonymous user are applied straightforward
- rules for logged in user are applied to all logged in users
- rules for specific user are applied only to that user and rules for logged in user are not applied at all
- if multiple rules are defined for the same user only the highest in sorting (the most top) rule will apply


EXAMPLE

if you want to restrict access to some page for all user except particular one. Then add rule for
"Logged in user" and select that page. Then create another rule for specific user and don't select any page.
For that specific user only its own rule will apply. Since no pages are denied all pages will be visible for that user.
