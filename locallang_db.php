<?php
/**
 * Language labels for database tables/fields belonging to extension "julle_events"
 * 
 * This file is detected by the translation tool.
 */

$LOCAL_LANG = Array (
	'default' => Array (
		'tt_content.tx_julleevents_type.I.0' => 'Full listing',
		'tt_content.tx_julleevents_type.I.1' => 'Frontpage teaser',
		'tt_content.tx_julleevents_type' => 'Listing type',
		'tx_julleevents_participants' => 'Participants',
		'tx_julleevents_participants.firstname' => 'Firstname',
		'tx_julleevents_participants.lastname' => 'Lastname',
		'tx_julleevents_participants.position' => 'Position',
		'tx_julleevents_participants.company' => 'Company name',
		'tx_julleevents_participants.address' => 'Address',
		'tx_julleevents_participants.zip' => 'Postcode',
		'tx_julleevents_participants.city' => 'City',
		'tx_julleevents_participants.country' => 'Country',
		'tx_julleevents_participants.billing_address' => 'Billing address (if different from address above)',
		'tx_julleevents_participants.email' => 'E-mail address',
		'tx_julleevents_participants.phone' => 'Phone',
		'tx_julleevents_participants.partner_code' => 'Partner code (if provided)',
		'tx_julleevents_events' => 'Events',
		'tx_julleevents_events.title' => 'Title',
		'tx_julleevents_events.date' => 'Startdate',
		'tx_julleevents_events.enddate' => 'Enddate (if different from startdate)',
		'tx_julleevents_events.city' => 'City',
		'tx_julleevents_events.city_rel' => 'City (db relation, has precedencs if set)',
		'tx_julleevents_events.teaser' => 'Front page teaser text',
		'tx_julleevents_events.regtext' => 'Text shown in top of the registration page',
		'tx_julleevents_events.regstart' => 'Registration start',
		'tx_julleevents_events.regend' => 'Registration end',
		'tx_julleevents_events.priority' => 'Priority in front end listing (10 is highest, 0 normal and -10 lowest)',
		'tx_julleevents_events.show_participants' => 'Number of registered particpants before showing list (default: never)',
		'tx_julleevents_events.max_participants' => 'Maximum number of particpants (default: unlimited)',
		'tx_julleevents_events.max_page' => 'Page to show when registration is over. (by time or number of participants)',
		'tx_julleevents_events.pages' => 'Pages',
		'tx_julleevents_events.participants' => 'Participants',
		'tx_julleevents_events.notify_email' => 'Notify on registration (comma seperated email addresses)',
		'tx_julleevents_partners' => 'Conference Partners',
		'tx_julleevents_partners.name' => 'Companyname',
		'tx_julleevents_partners.link' => 'Link',
		'tx_julleevents_partners.logo' => 'logo',
		'tx_julleevents_partners.sponsors' => 'Sponsors',
		"tx_julleevents_events.category" => "Category",    
		"tx_julleevents_categories" => "Categories",    
		"tx_julleevents_categories.category" => "Category",    
		"tx_julleevents_cities" => "Cities",    
		"tx_julleevents_cities.city" => "City",    
		'tt_content.list_type_pi1' => 'Events',
		'tt_content.list_type_pi2' => 'Event sponsors',
		"tt_content.tx_julleevents_category" => "Default category",    
		"tt_content.tx_julleevents_city" => "Default city",    
		"tt_content.tx_julleevents_dontshow" => "Dont show category selectorbox",
	),
	'dk' => Array (
	),
	'de' => Array (
		'tt_content.tx_julleevents_type.I.0' => 'Gesamtliste',
		'tt_content.tx_julleevents_type.I.1' => 'Frontpage teaser',
		'tt_content.tx_julleevents_type' => 'Art der Liste',
		'tx_julleevents_participants' => 'Teilnehmer',
		'tx_julleevents_participants.firstname' => 'Vorname',
		'tx_julleevents_participants.lastname' => 'Nachname',
		'tx_julleevents_participants.position' => 'Position',
		'tx_julleevents_participants.company' => 'Firma',
		'tx_julleevents_participants.address' => 'Adresse',
		'tx_julleevents_participants.zip' => 'PLZ',
		'tx_julleevents_participants.city' => 'Ort',
		'tx_julleevents_participants.country' => 'Land',
		'tx_julleevents_participants.billing_address' => 'Rechnungsanschrift (falls abweichend)',
		'tx_julleevents_participants.email' => 'E-mail',
		'tx_julleevents_participants.phone' => 'Telefon',
		'tx_julleevents_participants.partner_code' => 'Partner-Code (falls vorhanden)',
		'tx_julleevents_events' => 'Veranstaltung',
		'tx_julleevents_events.title' => 'Titel',
		'tx_julleevents_events.date' => 'Datum Beginn',
		'tx_julleevents_events.enddate' => 'Datum Ende (falls abweichend vom Beginn)',
		'tx_julleevents_events.city' => 'Ort',
		'tx_julleevents_events.city_rel' => 'Ort (Auswahl aus Datenbank, hat Vorrang)',
		'tx_julleevents_events.teaser' => 'Text für Frontpage Teaser',
		'tx_julleevents_events.regtext' => 'Text oben auf der Anmeldeseite',
		'tx_julleevents_events.regstart' => 'Beginn der Registrierung',
		'tx_julleevents_events.regend' => 'Ende der Registrierung',
		'tx_julleevents_events.priority' => 'Priorität bei der Anzeige (10 is höchste, 0 normal and -10 niedrigste)',
		'tx_julleevents_events.show_participants' => 'Min. Teilnehmerzahl um Liste anzuzeigen (default: keine Anzeige)',
		'tx_julleevents_events.max_participants' => 'Max. Teilnehmerzahl (default: unbegrenzt)',
		'tx_julleevents_events.max_page' => 'Seite die nach Schliessen der Registrierung angezeigt wird (Datum oder Teilnehmerzahl)',
		'tx_julleevents_events.pages' => 'Seiten',
		'tx_julleevents_events.participants' => 'Teilnehmer',
		'tx_julleevents_events.notify_email' => 'Benachrichtigen bei Anmeldung (Email Adressen, mehrere durch Komma getrennt)',
		'tx_julleevents_partners' => 'Sponsoren',
		'tx_julleevents_partners.name' => 'Firma',
		'tx_julleevents_partners.link' => 'Link',
		'tx_julleevents_partners.logo' => 'Logo',
		'tx_julleevents_partners.sponsors' => 'Sponsoren',
		"tx_julleevents_events.category" => "Kategorie",    
		"tx_julleevents_categories" => "Kategorien",    
		"tx_julleevents_categories.category" => "Kategorie",    
		"tx_julleevents_cities" => "Orte",    
		"tx_julleevents_cities.city" => "Ort",    
		'tt_content.list_type_pi1' => 'Veranstaltungen',
		'tt_content.list_type_pi2' => 'Sponsoren von Veranstaltungen',
		"tt_content.tx_julleevents_category" => "Standardkategorie",    
		"tt_content.tx_julleevents_city" => "Ort",    
		"tt_content.tx_julleevents_dontshow" => "Kategorieauswahl nicht anzeigen",
	),
	'no' => Array (
	),
	'it' => Array (
	),
	'fr' => Array (
	),
	'es' => Array (
	),
	'nl' => Array (
	),
	'cz' => Array (
	),
	'pl' => Array (
	),
	'si' => Array (
	),
	'fi' => Array (
		'tt_content.tx_julleevents_type.I.0' => 'Täysi listaus',
		'tt_content.tx_julleevents_type.I.1' => 'Etusivu houkutin',
		'tt_content.tx_julleevents_type' => 'Listaus tyyppi',
		'tx_julleevents_participants' => 'Osallistujat',
		'tx_julleevents_participants.firstname' => 'Etunimi',
		'tx_julleevents_participants.lastname' => 'Sukunimi',
		'tx_julleevents_participants.position' => 'Asema',
		'tx_julleevents_participants.company' => 'Yrityksen nimi',
		'tx_julleevents_participants.address' => 'Osoite',
		'tx_julleevents_participants.zip' => 'Postinumero',
		'tx_julleevents_participants.city' => 'Kaupunki',
		'tx_julleevents_participants.country' => 'Maa',
		'tx_julleevents_participants.billing_address' => 'Laskutusosoite (jos eri kuin yllä)',
		'tx_julleevents_participants.email' => 'Sähköpostiosoite',
		'tx_julleevents_participants.phone' => 'Puhelin',
		'tx_julleevents_participants.partner_code' => 'Partner numero (jos olemassa)',
		'tx_julleevents_events' => 'Tapahtumat',
		'tx_julleevents_events.title' => 'Otsikko',
		'tx_julleevents_events.date' => 'Alkamispäivä',
		'tx_julleevents_events.enddate' => 'Loppumispäivä (jos eri kuin alku)',
		'tx_julleevents_events.city' => 'Kaupunki',
		'tx_julleevents_events.teaser' => 'Etusivu houkuttimen teksti',
		'tx_julleevents_events.regstart' => 'Rekisteröinnin alkuu',
		'tx_julleevents_events.regend' => 'Rekisteröinnin loppu',
		'tx_julleevents_events.priority' => 'Prioriteetti etusivun listalla (10 on korkein, 0 normaali ja -10 alhaisin)',
		'tx_julleevents_events.show_participants' => 'Rekisteröituneiden osallsitujien lukumäärä ennekuin näytetään lista (0 = ei koskaan)',
		'tx_julleevents_events.pages' => 'Sivuja',
		'tx_julleevents_events.participants' => 'Osallistujat',
		'tx_julleevents_events.notify_email' => 'Huomatus rekisteröinnistä (pilkuin erolteltu email osoite lista)',
		'tx_julleevents_partners' => 'Kokouksen partnerit',
		'tx_julleevents_partners.name' => 'Yrityksen nimi',
		'tx_julleevents_partners.link' => 'Linkki',
		'tx_julleevents_partners.logo' => 'logo',
		'tx_julleevents_partners.sponsors' => 'Sponsorit',
		'tt_content.list_type_pi1' => 'Tapahtumat',
		'tt_content.list_type_pi2' => 'Tapahtuman sponsorit',
	),
	'tr' => Array (
	),
	'se' => Array (
	),
	'pt' => Array (
	),
	'ru' => Array (
	),
	'ro' => Array (
	),
	'ch' => Array (
	),
	'sk' => Array (
	),
	'lt' => Array (
	),
	'is' => Array (
	),
	'hr' => Array (
	),
	'hu' => Array (
	),
	'gl' => Array (
	),
	'th' => Array (
	),
	'gr' => Array (
	),
	'hk' => Array (
	),
	'eu' => Array (
	),
	'bg' => Array (
	),
	'br' => Array (
	),
	'et' => Array (
	),
);
?>