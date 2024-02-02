location ~* oy-have-we-got-a-month-for-you {
	return 308 https://oyvey.nl/en/oy-vey-newsletter/oy-have-we-got-a-month-for-you/;
}

location ~* kislev-dec-what-brings-you-light {
	return 308 https://oyvey.nl/en/oy-vey-newsletter/kislev/;
}

location ~* being-jewish-in-the-netherlands {
	return 308 https://oyvey.nl/en/gen/being-jewish-in-the-netherlands/;
}

location ~* oy-vey-activities-in-shevat-feb {
	return 308 https://oyvey.nl/en/oy-vey-newsletter/oy-vey-activities-in-shevat-feb/;
}

location ~* celebrate-adar{
	return 308 https://oyvey.nl/en/oy-vey-newsletter/celebrate-adar/;
}

location ~* oy-vey-in-january-feb {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/oy-vey-in-january-feb/;
}

location ~* shout-its-nisan {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/shout-its-nisan/;
}

location ~* iyar-a-month-of-counting {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/iyar-a-month-of-counting/;
}

location ~* sivan-events-cheesecake-and-more {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/sivan-events-cheesecake-and-more/;
}

location ~* tamuz-shabbat-discussions-pride {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/tamuz-shabbat-discussions-pride-2/;
}

location ~* mid-tamuz-grief-shabbat-pride-banana-ice {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/mid-tamuz-grief-shabbat-pride-banana-ice-2/;
}

location ~* av-study-shabbat-and-more {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/av-study-shabbat-and-more/;
}

location ~* learn-talmud-make-onion-bread {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/learn-talmud-make-onion-bread/;
}

location ~* elul-a-time-of-reflection-and-vegan-challah {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/elul-a-time-of-reflection-and-vegan-challah/;
}

location ~* tishrei-and-the-101-shofar-blasts {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/tishrei-and-the-101-shofar-blasts/;
}

location ~* oy-vey-says-be-deviant {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/oy-vey-says-be-deviant/;
}

location ~* events-in-november {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/events-in-november/;
}

location ~* chanukah-is-coming {
	return 308  https://oyvey.nl/en/gen/chanukah-is-coming/;
}

location ~* shevat-newsletter {
	return 308  https://oyvey.nl/en/oy-vey-newsletter/shevat-newsletter/;
}

location ~* gezamenlijke-wake {
	return 308  https://oyvey.nl/persbericht/gezamenlijke-wake-palestijnen-israeliers/;
}

location ~* (hub-hours|gallery-hours|death-and-mourning|oy-vey-library|shop-challah|oy-vey-hub|oy-vey-gallery|my-account|shop-tote-bags|shop-event-tickets|under-construction|shop-2|shop-hanukkah-cards|the-oy-vey-calendar) {
	return 301  https://oyvey.nl/en/this-page-is-no-longer-part-of-our-website/;
}

location ~* (board|cart|checkout|jewish-holidays|tours|products|collections) {
	return 308 https://oyvey.nl/en/this-page-is-no-longer-part-of-our-website/;
}

location = https://oyvey.nl/acts/ {
	return 301 https://oyvey.nl/en/this-page-is-no-longer-part-of-our-website/;
}

location ~* home-backup {
	return 301 https://oyvey.nl/;
}

location ~* (home/contact-2|join|get-involved-2) {
	return 301 https://oyvey.nl/en/contact-2/;
}

location ~* (mission-vision-values|oy-vey-as-jcc|library-hours|oy-vey-hub-jewish-creatives|social-justice-tikkun-olam-folks|about-me) {
	return 301 https://oyvey.nl/en/about-oy-vey-foundation-vision-goals-and-principles/;
}

location = https://oyvey.nl/partners {
	return 301 https://oyvey.nl/en/about-oy-vey-foundation-vision-goals-and-principles/;
}

location = https://oyvey.nl/our-team {
	return 308 https://oyvey.nl/team;
}

location ~* (programs-classes|kreuzberg-kollel-talmud-love) {
	return 308 https://oyvey.nl/en/learning-together/;
}

location = https://oyvey.nl/donate-button {
	return 308 https://oyvey.nl/en/donate-to-oy-vey/;
}

location ~* petitie-voor-vrede-in-israel-en-palestine {
	return 308 https://oyvey.nl/petitie-voor-vrede-in-israel-en-palestina;
}

rewrite https://oyvey.nl/teams https://oyvey.nl/team permanent;

location ~* petitie-voor-vrede-in-israel-en-palestine {
	return 308 https://oyvey.nl/petitie-voor-vrede-in-israel-en-palestina;
}

location ~* /(https-oyvey-nl-events|test-event|test-event-placeholder-event-to-check-if-width-and-height-okay) {
	return 308 https://oyvey.nl/event;
}
rewrite ^/events/(.*)$ https://oyvey.nl/en/event/$1 last;
rewrite ^/events$ https://oyvey.nl/event permanent;

location ~* category/(press) {
	return 308 https://oyvey.nl/en/category/press-release/;
}

location ~* category/(rites-and-rituals) {
	return 308 https://oyvey.nl/en/rites-and-rituals/;
}

#ignored: "-" thing used or unknown variable in regex/rew
if (!-f $request_filename){
	set $rule_1 1$rule_1;
}
if (!-d $request_filename){
	set $rule_1 2$rule_1;
}