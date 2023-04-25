<?php
/*------------------------------------------------------------------
[SHORTCODES - FOR VISUAL COMPOSER PLUGIN]

[Table of contents]

Recent Tweets
Google map
Contact Form
Testimonials Slider V1
Services style 1
Subscribe form
Jumbotron
Alert
Progress bars
Responsive YouTube Video
Featured post
Service style 2
Skill counter
Pricing table
Heading with border
Clients slider
Testimonials  Slider V2
Social icons
List group
Heading with bottom border
Call to Action
Section Heading with Title and Subtitle
Section Heading with Title
Blog Posts
Products by Category
Quotes
Banner
Contact form 2
Contact locations
Sermons
Simple list of Sermons V1
Simple list of Sermons V2
Our Services

-------------------------------------------------------------------*/

add_action('init','pomana_vc_shortcodes');   
function pomana_vc_shortcodes(){
  #FontAwesome icons list
  $fa_list = array(
    'fa fa-angellist' => 'fa fa-angellist',
    'fa fa-area-chart' => 'fa fa-area-chart',
    'fa fa-at' => 'fa fa-at',
    'fa fa-bell-slash' => 'fa fa-bell-slash',
    'fa fa-bell-slash-o' => 'fa fa-bell-slash-o',
    'fa fa-bicycle' => 'fa fa-bicycle',
    'fa fa-binoculars' => 'fa fa-binoculars',
    'fa fa-birthday-cake' => 'fa fa-birthday-cake',
    'fa fa-bus' => 'fa fa-bus',
    'fa fa-calculator' => 'fa fa-calculator',
    'fa fa-cc' => 'fa fa-cc',
    'fa fa-cc-amex' => 'fa fa-cc-amex',
    'fa fa-cc-discover' => 'fa fa-cc-discover',
    'fa fa-cc-mastercard' => 'fa fa-cc-mastercard',
    'fa fa-cc-paypal' => 'fa fa-cc-paypal',
    'fa fa-cc-stripe' => 'fa fa-cc-stripe',
    'fa fa-cc-visa' => 'fa fa-cc-visa',
    'fa fa-copyright' => 'fa fa-copyright',
    'fa fa-eyedropper' => 'fa fa-eyedropper',
    'fa fa-futbol-o' => 'fa fa-futbol-o',
    'fa fa-google-wallet' => 'fa fa-google-wallet',
    'fa fa-ils' => 'fa fa-ils',
    'fa fa-ioxhost' => 'fa fa-ioxhost',
    'fa fa-lastfm' => 'fa fa-lastfm',
    'fa fa-lastfm-square' => 'fa fa-lastfm-square',
    'fa fa-line-chart' => 'fa fa-line-chart',
    'fa fa-meanpath' => 'fa fa-meanpath',
    'fa fa-newspaper-o' => 'fa fa-newspaper-o',
    'fa fa-paint-brush' => 'fa fa-paint-brush',
    'fa fa-paypal' => 'fa fa-paypal',
    'fa fa-pie-chart' => 'fa fa-pie-chart',
    'fa fa-plug' => 'fa fa-plug',
    'fa fa-shekel' => 'fa fa-shekel',
    'fa fa-sheqel' => 'fa fa-sheqel',
    'fa fa-slideshare' => 'fa fa-slideshare',
    'fa fa-soccer-ball-o' => 'fa fa-soccer-ball-o',
    'fa fa-toggle-off' => 'fa fa-toggle-off',
    'fa fa-toggle-on' => 'fa fa-toggle-on',
    'fa fa-trash' => 'fa fa-trash',
    'fa fa-tty' => 'fa fa-tty',
    'fa fa-twitch' => 'fa fa-twitch',
    'fa fa-wifi' => 'fa fa-wifi',
    'fa fa-yelp' => 'fa fa-yelp',
    'fa fa-adjust' => 'fa fa-adjust',
    'fa fa-anchor' => 'fa fa-anchor',
    'fa fa-archive' => 'fa fa-archive',
    'fa fa-arrows' => 'fa fa-arrows',
    'fa fa-arrows-h' => 'fa fa-arrows-h',
    'fa fa-arrows-v' => 'fa fa-arrows-v',
    'fa fa-asterisk' => 'fa fa-asterisk',
    'fa fa-automobile' => 'fa fa-automobile',
    'fa fa-ban' => 'fa fa-ban',
    'fa fa-bank' => 'fa fa-bank',
    'fa fa-bar-chart' => 'fa fa-bar-chart',
    'fa fa-bar-chart-o' => 'fa fa-bar-chart-o',
    'fa fa-barcode' => 'fa fa-barcode',
    'fa fa-bars' => 'fa fa-bars',
    'fa fa-beer' => 'fa fa-beer',
    'fa fa-bell' => 'fa fa-bell',
    'fa fa-bell-o' => 'fa fa-bell-o',
    'fa fa-bolt' => 'fa fa-bolt',
    'fa fa-bomb' => 'fa fa-bomb',
    'fa fa-book' => 'fa fa-book',
    'fa fa-bookmark' => 'fa fa-bookmark',
    'fa fa-bookmark-o' => 'fa fa-bookmark-o',
    'fa fa-briefcase' => 'fa fa-briefcase',
    'fa fa-bug' => 'fa fa-bug',
    'fa fa-building' => 'fa fa-building',
    'fa fa-building-o' => 'fa fa-building-o',
    'fa fa-bullhorn' => 'fa fa-bullhorn',
    'fa fa-bullseye' => 'fa fa-bullseye',
    'fa fa-cab' => 'fa fa-cab',
    'fa fa-calendar' => 'fa fa-calendar',
    'fa fa-calendar-o' => 'fa fa-calendar-o',
    'fa fa-camera' => 'fa fa-camera',
    'fa fa-camera-retro' => 'fa fa-camera-retro',
    'fa fa-car' => 'fa fa-car',
    'fa fa-caret-square-o-down' => 'fa fa-caret-square-o-down',
    'fa fa-caret-square-o-left' => 'fa fa-caret-square-o-left',
    'fa fa-caret-square-o-right' => 'fa fa-caret-square-o-right',
    'fa fa-caret-square-o-up' => 'fa fa-caret-square-o-up',
    'fa fa-certificate' => 'fa fa-certificate',
    'fa fa-check' => 'fa fa-check',
    'fa fa-check-circle' => 'fa fa-check-circle',
    'fa fa-check-circle-o' => 'fa fa-check-circle-o',
    'fa fa-check-square' => 'fa fa-check-square',
    'fa fa-check-square-o' => 'fa fa-check-square-o',
    'fa fa-child' => 'fa fa-child',
    'fa fa-circle' => 'fa fa-circle',
    'fa fa-circle-o' => 'fa fa-circle-o',
    'fa fa-circle-o-notch' => 'fa fa-circle-o-notch',
    'fa fa-circle-thin' => 'fa fa-circle-thin',
    'fa fa-clock-o' => 'fa fa-clock-o',
    'fa fa-close' => 'fa fa-close',
    'fa fa-cloud' => 'fa fa-cloud',
    'fa fa-cloud-download' => 'fa fa-cloud-download',
    'fa fa-cloud-upload' => 'fa fa-cloud-upload',
    'fa fa-code' => 'fa fa-code',
    'fa fa-code-fork' => 'fa fa-code-fork',
    'fa fa-coffee' => 'fa fa-coffee',
    'fa fa-cog' => 'fa fa-cog',
    'fa fa-cogs' => 'fa fa-cogs',
    'fa fa-comment' => 'fa fa-comment',
    'fa fa-comment-o' => 'fa fa-comment-o',
    'fa fa-comments' => 'fa fa-comments',
    'fa fa-comments-o' => 'fa fa-comments-o',
    'fa fa-compass' => 'fa fa-compass',
    'fa fa-credit-card' => 'fa fa-credit-card',
    'fa fa-crop' => 'fa fa-crop',
    'fa fa-crosshairs' => 'fa fa-crosshairs',
    'fa fa-cube' => 'fa fa-cube',
    'fa fa-cubes' => 'fa fa-cubes',
    'fa fa-cutlery' => 'fa fa-cutlery',
    'fa fa-dashboard' => 'fa fa-dashboard',
    'fa fa-database' => 'fa fa-database',
    'fa fa-desktop' => 'fa fa-desktop',
    'fa fa-dot-circle-o' => 'fa fa-dot-circle-o',
    'fa fa-download' => 'fa fa-download',
    'fa fa-edit' => 'fa fa-edit',
    'fa fa-ellipsis-h' => 'fa fa-ellipsis-h',
    'fa fa-ellipsis-v' => 'fa fa-ellipsis-v',
    'fa fa-envelope' => 'fa fa-envelope',
    'fa fa-envelope-o' => 'fa fa-envelope-o',
    'fa fa-envelope-square' => 'fa fa-envelope-square',
    'fa fa-eraser' => 'fa fa-eraser',
    'fa fa-exchange' => 'fa fa-exchange',
    'fa fa-exclamation' => 'fa fa-exclamation',
    'fa fa-exclamation-circle' => 'fa fa-exclamation-circle',
    'fa fa-exclamation-triangle' => 'fa fa-exclamation-triangle',
    'fa fa-external-link' => 'fa fa-external-link',
    'fa fa-external-link-square' => 'fa fa-external-link-square',
    'fa fa-eye' => 'fa fa-eye',
    'fa fa-eye-slash' => 'fa fa-eye-slash',
    'fa fa-fax' => 'fa fa-fax',
    'fa fa-female' => 'fa fa-female',
    'fa fa-fighter-jet' => 'fa fa-fighter-jet',
    'fa fa-file-archive-o' => 'fa fa-file-archive-o',
    'fa fa-file-audio-o' => 'fa fa-file-audio-o',
    'fa fa-file-code-o' => 'fa fa-file-code-o',
    'fa fa-file-excel-o' => 'fa fa-file-excel-o',
    'fa fa-file-image-o' => 'fa fa-file-image-o',
    'fa fa-file-movie-o' => 'fa fa-file-movie-o',
    'fa fa-file-pdf-o' => 'fa fa-file-pdf-o',
    'fa fa-file-photo-o' => 'fa fa-file-photo-o',
    'fa fa-file-picture-o' => 'fa fa-file-picture-o',
    'fa fa-file-powerpoint-o' => 'fa fa-file-powerpoint-o',
    'fa fa-file-sound-o' => 'fa fa-file-sound-o',
    'fa fa-file-video-o' => 'fa fa-file-video-o',
    'fa fa-file-word-o' => 'fa fa-file-word-o',
    'fa fa-file-zip-o' => 'fa fa-file-zip-o',
    'fa fa-film' => 'fa fa-film',
    'fa fa-filter' => 'fa fa-filter',
    'fa fa-fire' => 'fa fa-fire',
    'fa fa-fire-extinguisher' => 'fa fa-fire-extinguisher',
    'fa fa-flag' => 'fa fa-flag',
    'fa fa-flag-checkered' => 'fa fa-flag-checkered',
    'fa fa-flag-o' => 'fa fa-flag-o',
    'fa fa-flash' => 'fa fa-flash',
    'fa fa-flask' => 'fa fa-flask',
    'fa fa-folder' => 'fa fa-folder',
    'fa fa-folder-o' => 'fa fa-folder-o',
    'fa fa-folder-open' => 'fa fa-folder-open',
    'fa fa-folder-open-o' => 'fa fa-folder-open-o',
    'fa fa-frown-o' => 'fa fa-frown-o',
    'fa fa-gamepad' => 'fa fa-gamepad',
    'fa fa-gavel' => 'fa fa-gavel',
    'fa fa-gear' => 'fa fa-gear',
    'fa fa-gears' => 'fa fa-gears',
    'fa fa-gift' => 'fa fa-gift',
    'fa fa-glass' => 'fa fa-glass',
    'fa fa-globe' => 'fa fa-globe',
    'fa fa-graduation-cap' => 'fa fa-graduation-cap',
    'fa fa-group' => 'fa fa-group',
    'fa fa-hdd-o' => 'fa fa-hdd-o',
    'fa fa-headphones' => 'fa fa-headphones',
    'fa fa-heart' => 'fa fa-heart',
    'fa fa-heart-o' => 'fa fa-heart-o',
    'fa fa-history' => 'fa fa-history',
    'fa fa-home' => 'fa fa-home',
    'fa fa-image' => 'fa fa-image',
    'fa fa-inbox' => 'fa fa-inbox',
    'fa fa-info' => 'fa fa-info',
    'fa fa-info-circle' => 'fa fa-info-circle',
    'fa fa-institution' => 'fa fa-institution',
    'fa fa-key' => 'fa fa-key',
    'fa fa-keyboard-o' => 'fa fa-keyboard-o',
    'fa fa-language' => 'fa fa-language',
    'fa fa-laptop' => 'fa fa-laptop',
    'fa fa-leaf' => 'fa fa-leaf',
    'fa fa-legal' => 'fa fa-legal',
    'fa fa-lemon-o' => 'fa fa-lemon-o',
    'fa fa-level-down' => 'fa fa-level-down',
    'fa fa-level-up' => 'fa fa-level-up',
    'fa fa-life-bouy' => 'fa fa-life-bouy',
    'fa fa-life-buoy' => 'fa fa-life-buoy',
    'fa fa-life-ring' => 'fa fa-life-ring',
    'fa fa-life-saver' => 'fa fa-life-saver',
    'fa fa-lightbulb-o' => 'fa fa-lightbulb-o',
    'fa fa-location-arrow' => 'fa fa-location-arrow',
    'fa fa-lock' => 'fa fa-lock',
    'fa fa-magic' => 'fa fa-magic',
    'fa fa-magnet' => 'fa fa-magnet',
    'fa fa-mail-forward' => 'fa fa-mail-forward',
    'fa fa-mail-reply' => 'fa fa-mail-reply',
    'fa fa-mail-reply-all' => 'fa fa-mail-reply-all',
    'fa fa-male' => 'fa fa-male',
    'fa fa-map-marker' => 'fa fa-map-marker',
    'fa fa-meh-o' => 'fa fa-meh-o',
    'fa fa-microphone' => 'fa fa-microphone',
    'fa fa-microphone-slash' => 'fa fa-microphone-slash',
    'fa fa-minus' => 'fa fa-minus',
    'fa fa-minus-circle' => 'fa fa-minus-circle',
    'fa fa-minus-square' => 'fa fa-minus-square',
    'fa fa-minus-square-o' => 'fa fa-minus-square-o',
    'fa fa-mobile' => 'fa fa-mobile',
    'fa fa-mobile-phone' => 'fa fa-mobile-phone',
    'fa fa-money' => 'fa fa-money',
    'fa fa-moon-o' => 'fa fa-moon-o',
    'fa fa-mortar-board' => 'fa fa-mortar-board',
    'fa fa-music' => 'fa fa-music',
    'fa fa-navicon' => 'fa fa-navicon',
    'fa fa-paper-plane' => 'fa fa-paper-plane',
    'fa fa-paper-plane-o' => 'fa fa-paper-plane-o',
    'fa fa-paw' => 'fa fa-paw',
    'fa fa-pencil' => 'fa fa-pencil',
    'fa fa-pencil-square' => 'fa fa-pencil-square',
    'fa fa-pencil-square-o' => 'fa fa-pencil-square-o',
    'fa fa-phone' => 'fa fa-phone',
    'fa fa-phone-square' => 'fa fa-phone-square',
    'fa fa-photo' => 'fa fa-photo',
    'fa fa-picture-o' => 'fa fa-picture-o',
    'fa fa-plane' => 'fa fa-plane',
    'fa fa-plus' => 'fa fa-plus',
    'fa fa-plus-circle' => 'fa fa-plus-circle',
    'fa fa-plus-square' => 'fa fa-plus-square',
    'fa fa-plus-square-o' => 'fa fa-plus-square-o',
    'fa fa-power-off' => 'fa fa-power-off',
    'fa fa-print' => 'fa fa-print',
    'fa fa-puzzle-piece' => 'fa fa-puzzle-piece',
    'fa fa-qrcode' => 'fa fa-qrcode',
    'fa fa-question' => 'fa fa-question',
    'fa fa-question-circle' => 'fa fa-question-circle',
    'fa fa-quote-left' => 'fa fa-quote-left',
    'fa fa-quote-right' => 'fa fa-quote-right',
    'fa fa-random' => 'fa fa-random',
    'fa fa-recycle' => 'fa fa-recycle',
    'fa fa-refresh' => 'fa fa-refresh',
    'fa fa-remove' => 'fa fa-remove',
    'fa fa-reorder' => 'fa fa-reorder',
    'fa fa-reply' => 'fa fa-reply',
    'fa fa-reply-all' => 'fa fa-reply-all',
    'fa fa-retweet' => 'fa fa-retweet',
    'fa fa-road' => 'fa fa-road',
    'fa fa-rocket' => 'fa fa-rocket',
    'fa fa-rss' => 'fa fa-rss',
    'fa fa-rss-square' => 'fa fa-rss-square',
    'fa fa-search' => 'fa fa-search',
    'fa fa-search-minus' => 'fa fa-search-minus',
    'fa fa-search-plus' => 'fa fa-search-plus',
    'fa fa-send' => 'fa fa-send',
    'fa fa-send-o' => 'fa fa-send-o',
    'fa fa-share' => 'fa fa-share',
    'fa fa-share-alt' => 'fa fa-share-alt',
    'fa fa-share-alt-square' => 'fa fa-share-alt-square',
    'fa fa-share-square' => 'fa fa-share-square',
    'fa fa-share-square-o' => 'fa fa-share-square-o',
    'fa fa-shield' => 'fa fa-shield',
    'fa fa-shopping-cart' => 'fa fa-shopping-cart',
    'fa fa-sign-in' => 'fa fa-sign-in',
    'fa fa-sign-out' => 'fa fa-sign-out',
    'fa fa-signal' => 'fa fa-signal',
    'fa fa-sitemap' => 'fa fa-sitemap',
    'fa fa-sliders' => 'fa fa-sliders',
    'fa fa-smile-o' => 'fa fa-smile-o',
    'fa fa-sort' => 'fa fa-sort',
    'fa fa-sort-alpha-asc' => 'fa fa-sort-alpha-asc',
    'fa fa-sort-alpha-desc' => 'fa fa-sort-alpha-desc',
    'fa fa-sort-amount-asc' => 'fa fa-sort-amount-asc',
    'fa fa-sort-amount-desc' => 'fa fa-sort-amount-desc',
    'fa fa-sort-asc' => 'fa fa-sort-asc',
    'fa fa-sort-desc' => 'fa fa-sort-desc',
    'fa fa-sort-down' => 'fa fa-sort-down',
    'fa fa-sort-numeric-asc' => 'fa fa-sort-numeric-asc',
    'fa fa-sort-numeric-desc' => 'fa fa-sort-numeric-desc',
    'fa fa-sort-up' => 'fa fa-sort-up',
    'fa fa-space-shuttle' => 'fa fa-space-shuttle',
    'fa fa-spinner' => 'fa fa-spinner',
    'fa fa-spoon' => 'fa fa-spoon',
    'fa fa-square' => 'fa fa-square',
    'fa fa-square-o' => 'fa fa-square-o',
    'fa fa-star' => 'fa fa-star',
    'fa fa-star-half' => 'fa fa-star-half',
    'fa fa-star-half-empty' => 'fa fa-star-half-empty',
    'fa fa-star-half-full' => 'fa fa-star-half-full',
    'fa fa-star-half-o' => 'fa fa-star-half-o',
    'fa fa-star-o' => 'fa fa-star-o',
    'fa fa-suitcase' => 'fa fa-suitcase',
    'fa fa-sun-o' => 'fa fa-sun-o',
    'fa fa-support' => 'fa fa-support',
    'fa fa-tablet' => 'fa fa-tablet',
    'fa fa-tachometer' => 'fa fa-tachometer',
    'fa fa-tag' => 'fa fa-tag',
    'fa fa-tags' => 'fa fa-tags',
    'fa fa-tasks' => 'fa fa-tasks',
    'fa fa-taxi' => 'fa fa-taxi',
    'fa fa-terminal' => 'fa fa-terminal',
    'fa fa-thumb-tack' => 'fa fa-thumb-tack',
    'fa fa-thumbs-down' => 'fa fa-thumbs-down',
    'fa fa-thumbs-o-down' => 'fa fa-thumbs-o-down',
    'fa fa-thumbs-o-up' => 'fa fa-thumbs-o-up',
    'fa fa-thumbs-up' => 'fa fa-thumbs-up',
    'fa fa-ticket' => 'fa fa-ticket',
    'fa fa-times' => 'fa fa-times',
    'fa fa-times-circle' => 'fa fa-times-circle',
    'fa fa-times-circle-o' => 'fa fa-times-circle-o',
    'fa fa-tint' => 'fa fa-tint',
    'fa fa-toggle-down' => 'fa fa-toggle-down',
    'fa fa-toggle-left' => 'fa fa-toggle-left',
    'fa fa-toggle-right' => 'fa fa-toggle-right',
    'fa fa-toggle-up' => 'fa fa-toggle-up',
    'fa fa-trash-o' => 'fa fa-trash-o',
    'fa fa-tree' => 'fa fa-tree',
    'fa fa-trophy' => 'fa fa-trophy',
    'fa fa-truck' => 'fa fa-truck',
    'fa fa-umbrella' => 'fa fa-umbrella',
    'fa fa-university' => 'fa fa-university',
    'fa fa-unlock' => 'fa fa-unlock',
    'fa fa-unlock-alt' => 'fa fa-unlock-alt',
    'fa fa-unsorted' => 'fa fa-unsorted',
    'fa fa-upload' => 'fa fa-upload',
    'fa fa-user' => 'fa fa-user',
    'fa fa-users' => 'fa fa-users',
    'fa fa-video-camera' => 'fa fa-video-camera',
    'fa fa-volume-down' => 'fa fa-volume-down',
    'fa fa-volume-off' => 'fa fa-volume-off',
    'fa fa-volume-up' => 'fa fa-volume-up',
    'fa fa-warning' => 'fa fa-warning',
    'fa fa-wheelchair' => 'fa fa-wheelchair',
    'fa fa-wrench' => 'fa fa-wrench',
    'fa fa-file' => 'fa fa-file',
    'fa fa-file-o' => 'fa fa-file-o',
    'fa fa-file-text' => 'fa fa-file-text',
    'fa fa-file-text-o' => 'fa fa-file-text-o',
    'fa fa-bitcoin' => 'fa fa-bitcoin',
    'fa fa-btc' => 'fa fa-btc',
    'fa fa-cny' => 'fa fa-cny',
    'fa fa-dollar' => 'fa fa-dollar',
    'fa fa-eur' => 'fa fa-eur',
    'fa fa-euro' => 'fa fa-euro',
    'fa fa-gbp' => 'fa fa-gbp',
    'fa fa-inr' => 'fa fa-inr',
    'fa fa-jpy' => 'fa fa-jpy',
    'fa fa-krw' => 'fa fa-krw',
    'fa fa-rmb' => 'fa fa-rmb',
    'fa fa-rouble' => 'fa fa-rouble',
    'fa fa-rub' => 'fa fa-rub',
    'fa fa-ruble' => 'fa fa-ruble',
    'fa fa-rupee' => 'fa fa-rupee',
    'fa fa-try' => 'fa fa-try',
    'fa fa-turkish-lira' => 'fa fa-turkish-lira',
    'fa fa-usd' => 'fa fa-usd',
    'fa fa-won' => 'fa fa-won',
    'fa fa-yen' => 'fa fa-yen',
    'fa fa-align-center' => ' fa fa-align-center',
    'fa fa-align-justify' => 'fa fa-align-justify',
    'fa fa-align-left' => 'fa fa-align-left',
    'fa fa-align-right' => 'fa fa-align-right',
    'fa fa-bold' => 'fa fa-bold',
    'fa fa-chain' => 'fa fa-chain',
    'fa fa-chain-broken' => 'fa fa-chain-broken',
    'fa fa-clipboard' => 'fa fa-clipboard',
    'fa fa-columns' => 'fa fa-columns',
    'fa fa-copy' => 'fa fa-copy',
    'fa fa-cut' => 'fa fa-cut',
    'fa fa-dedent' => 'fa fa-dedent',
    'fa fa-files-o' => 'fa fa-files-o',
    'fa fa-floppy-o' => 'fa fa-floppy-o',
    'fa fa-font' => 'fa fa-font',
    'fa fa-header' => 'fa fa-header',
    'fa fa-indent' => 'fa fa-indent',
    'fa fa-italic' => 'fa fa-italic',
    'fa fa-link' => 'fa fa-link',
    'fa fa-list' => 'fa fa-list',
    'fa fa-list-alt' => 'fa fa-list-alt',
    'fa fa-list-ol' => 'fa fa-list-ol',
    'fa fa-list-ul' => 'fa fa-list-ul',
    'fa fa-outdent' => 'fa fa-outdent',
    'fa fa-paperclip' => 'fa fa-paperclip',
    'fa fa-paragraph' => 'fa fa-paragraph',
    'fa fa-paste' => 'fa fa-paste',
    'fa fa-repeat' => 'fa fa-repeat',
    'fa fa-rotate-left' => 'fa fa-rotate-left',
    'fa fa-rotate-right' => 'fa fa-rotate-right',
    'fa fa-save' => 'fa fa-save',
    'fa fa-scissors' => 'fa fa-scissors',
    'fa fa-strikethrough' => 'fa fa-strikethrough',
    'fa fa-subscript' => 'fa fa-subscript',
    'fa fa-superscript' => 'fa fa-superscript',
    'fa fa-table' => 'fa fa-table',
    'fa fa-text-height' => 'fa fa-text-height',
    'fa fa-text-width' => 'fa fa-text-width',
    'fa fa-th' => 'fa fa-th',
    'fa fa-th-large' => 'fa fa-th-large',
    'fa fa-th-list' => 'fa fa-th-list',
    'fa fa-underline' => 'fa fa-underline',
    'fa fa-undo' => 'fa fa-undo',
    'fa fa-unlink' => 'fa fa-unlink',
    'fa fa-angle-double-down' => ' fa fa-angle-double-down',
    'fa fa-angle-double-left' => 'fa fa-angle-double-left',
    'fa fa-angle-double-right' => 'fa fa-angle-double-right',
    'fa fa-angle-double-up' => 'fa fa-angle-double-up',
    'fa fa-angle-down' => 'fa fa-angle-down',
    'fa fa-angle-left' => 'fa fa-angle-left',
    'fa fa-angle-right' => 'fa fa-angle-right',
    'fa fa-angle-up' => 'fa fa-angle-up',
    'fa fa-arrow-circle-down' => 'fa fa-arrow-circle-down',
    'fa fa-arrow-circle-left' => 'fa fa-arrow-circle-left',
    'fa fa-arrow-circle-o-down' => 'fa fa-arrow-circle-o-down',
    'fa fa-arrow-circle-o-left' => 'fa fa-arrow-circle-o-left',
    'fa fa-arrow-circle-o-right' => 'fa fa-arrow-circle-o-right',
    'fa fa-arrow-circle-o-up' => 'fa fa-arrow-circle-o-up',
    'fa fa-arrow-circle-right' => 'fa fa-arrow-circle-right',
    'fa fa-arrow-circle-up' => 'fa fa-arrow-circle-up',
    'fa fa-arrow-down' => 'fa fa-arrow-down',
    'fa fa-arrow-left' => 'fa fa-arrow-left',
    'fa fa-arrow-right' => 'fa fa-arrow-right',
    'fa fa-arrow-up' => 'fa fa-arrow-up',
    'fa fa-arrows-alt' => 'fa fa-arrows-alt',
    'fa fa-caret-down' => 'fa fa-caret-down',
    'fa fa-caret-left' => 'fa fa-caret-left',
    'fa fa-caret-right' => 'fa fa-caret-right',
    'fa fa-caret-up' => 'fa fa-caret-up',
    'fa fa-chevron-circle-down' => 'fa fa-chevron-circle-down',
    'fa fa-chevron-circle-left' => 'fa fa-chevron-circle-left',
    'fa fa-chevron-circle-right' => 'fa fa-chevron-circle-right',
    'fa fa-chevron-circle-up' => 'fa fa-chevron-circle-up',
    'fa fa-chevron-down' => 'fa fa-chevron-down',
    'fa fa-chevron-left' => 'fa fa-chevron-left',
    'fa fa-chevron-right' => 'fa fa-chevron-right',
    'fa fa-chevron-up' => 'fa fa-chevron-up',
    'fa fa-hand-o-down' => 'fa fa-hand-o-down',
    'fa fa-hand-o-left' => 'fa fa-hand-o-left',
    'fa fa-hand-o-right' => 'fa fa-hand-o-right',
    'fa fa-hand-o-up' => 'fa fa-hand-o-up',
    'fa fa-long-arrow-down' => 'fa fa-long-arrow-down',
    'fa fa-long-arrow-left' => 'fa fa-long-arrow-left',
    'fa fa-long-arrow-right' => 'fa fa-long-arrow-right',
    'fa fa-long-arrow-up' => 'fa fa-long-arrow-up',
    'fa fa-backward' => 'fa fa-backward',
    'fa fa-compress' => 'fa fa-compress',
    'fa fa-eject' => 'fa fa-eject',
    'fa fa-expand' => 'fa fa-expand',
    'fa fa-fast-backward' => 'fa fa-fast-backward',
    'fa fa-fast-forward' => 'fa fa-fast-forward',
    'fa fa-forward' => 'fa fa-forward',
    'fa fa-pause' => 'fa fa-pause',
    'fa fa-play' => 'fa fa-play',
    'fa fa-play-circle' => 'fa fa-play-circle',
    'fa fa-play-circle-o' => 'fa fa-play-circle-o',
    'fa fa-step-backward' => 'fa fa-step-backward',
    'fa fa-step-forward' => 'fa fa-step-forward',
    'fa fa-stop' => 'fa fa-stop',
    'fa fa-youtube-play' => 'fa fa-youtube-play'
  );

  #Animations list
  $animations_list = array(
    'Choose an Option' => 'no-animation-selected',
    'bounce' => 'bounce',
    'flash' => 'flash',
    'pulse' => 'pulse',
    'rubberBand' => 'rubberBand',
    'shake' => 'shake',
    'swing' => 'swing',
    'tada' => 'tada',
    'wobble' => 'wobble',
    'bounceIn' => 'bounceIn',
    'bounceInDown' => 'bounceInDown',
    'bounceInLeft' => 'bounceInLeft',
    'bounceInRight' => 'bounceInRight',
    'bounceInUp' => 'bounceInUp',
    'bounceOut' => 'bounceOut',
    'bounceOutDown' => 'bounceOutDown',
    'bounceOutLeft' => 'bounceOutLeft',
    'bounceOutRight' => 'bounceOutRight',
    'bounceOutUp' => 'bounceOutUp',
    'fadeIn' => 'fadeIn',
    'fadeInDown' => 'fadeInDown',
    'fadeInDownBig' => 'fadeInDownBig',
    'fadeInLeft' => 'fadeInLeft',
    'fadeInLeftBig' => 'fadeInLeftBig',
    'fadeInRight' => 'fadeInRight',
    'fadeInRightBig' => 'fadeInRightBig',
    'fadeInUp' => 'fadeInUp',
    'fadeInUpBig' => 'fadeInUpBig',
    'fadeOut' => 'fadeOut',
    'fadeOutDown' => 'fadeOutDown',
    'fadeOutDownBig' => 'fadeOutDownBig',
    'fadeOutLeft' => 'fadeOutLeft',
    'fadeOutLeftBig' => 'fadeOutLeftBig',
    'fadeOutRight' => 'fadeOutRight',
    'fadeOutRightBi' => 'fadeOutRightBig',
    'fadeOutUp' => 'fadeOutUp',
    'fadeOutUpBig' => 'fadeOutUpBig',
    'flip' => 'flip',
    'flipInX' => 'flipInX',
    'flipInY' => 'flipInY',
    'flipOutX' => 'flipOutX',
    'flipOutY' => 'flipOutY',
    'lightSpeedIn' => 'lightSpeedIn',
    'lightSpeedOut' => 'lightSpeedOut',
    'rotateIn' => 'rotateIn',
    'rotateInDownLe' => 'rotateInDownLeft',
    'rotateInDownRi' => 'rotateInDownRight',
    'rotateInUpLeft' => 'rotateInUpLeft',
    'rotateInUpRigh' => 'rotateInUpRight',
    'rotateOut' => 'rotateOut',
    'rotateOutDownL' => 'rotateOutDownLeft',
    'rotateOutDownR' => 'rotateOutDownRight',
    'rotateOutUpLef' => 'rotateOutUpLeft',
    'rotateOutUpRig' => 'rotateOutUpRight',
    'hinge' => 'hinge',
    'rollIn' => 'rollIn',
    'rollOut' => 'rollOut',
    'zoomIn' => 'zoomIn',
    'zoomInDown' => 'zoomInDown',
    'zoomInLeft' => 'zoomInLeft',
    'zoomInRight' => 'zoomInRight',
    'zoomInUp' => 'zoomInUp',
    'zoomOut' => 'zoomOut',
    'zoomOutDown' => 'zoomOutDown',
    'zoomOutLeft' => 'zoomOutLeft',
    'zoomOutRight' => 'zoomOutRight',
    'zoomOutUp' => 'zoomOutUp'
  );






  #SHORTCODE: Testimonials Slider V1
  vc_map( array(
     "name" => esc_attr__("Testimonials Box", 'modeltheme'),
     "base" => "testimonials01",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/testimonials.svg', __FILE__ ),
     "params" => array(
        array(
           "group" => "Options",
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Select style type", 'modeltheme'),
           "param_name" => "style_type",
           "description" => esc_attr__("Please choose style type", 'modeltheme'),
           "std" => 'Default value',
           "value" => array(
                esc_attr__('Style 1 (default)', 'modeltheme')   => 'style_1'
           )
        ),
        array(
          "group" => "Options",
          "type" => "textfield",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__( "Number of testimonials", 'modeltheme' ),
          "param_name" => "number",
          "value" => "",
          "description" => esc_attr__( "Enter number of testimonials to show.", 'modeltheme' )
        ),
        array(
          "group" => "Options",
          "type" => "dropdown",
          "heading" => esc_attr__("Visible Testimonials per slide", 'modeltheme'),
          "param_name" => "visible_items",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => "",
          "value" => array(
            '1'   => '1',
            '2'   => '2',
            '3'   => '3'
            )
        ),
        array(
          "group" => "Navigation",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Navigation background color of arrows", 'modeltheme' ),
          "param_name" => "navigation_arrows_background",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose navigation background color of arrows", 'modeltheme' )
        ),
        array(
          "group" => "Navigation",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Navigation background color of arrows on hover", 'modeltheme' ),
          "param_name" => "navigation_arrows_background_hover",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose navigation background color of arrows on hover", 'modeltheme' )
        ),
        array(
          "group" => "Navigation",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Navigation color of arrows", 'modeltheme' ),
          "param_name" => "navigation_arrows_color",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose navigation color of arrows", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Background color of testimonial", 'modeltheme' ),
          "param_name" => "background_color",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose background color of testimonial", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Content color of testimonial", 'modeltheme' ),
          "param_name" => "content_color",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose content color of testimonial (paragraphs)", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Testimonial name color", 'modeltheme' ),
          "param_name" => "testimonial_name_color",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose Testimonial name color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Testimonial position color", 'modeltheme' ),
          "param_name" => "testimonial_position_color",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose Testimonial position color", 'modeltheme' )
        ),
        array(
          "group" => "Animation",
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => "",
          "value" => $animations_list
        )
      )
  ));

  $mt_services = get_terms('services');
  $mt_service_category = array();
  foreach ( $mt_services as $service ) {
     $mt_service_category[$service->name] = $service->slug;
  }

  $terms = get_terms('services');
  $services_category = array();
  foreach ( $terms as $term ) {
     $category[$term->name] = $term->slug;
  }

#SHORTCODE: Services Activities shortcode
  vc_map( array(
     "name" => __("Services Features", 'modeltheme'),
     "base" => "service_activity",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/service-icon-with-text.svg', __FILE__ ),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Number of posts to show", 'modeltheme'),
           "param_name" => "number",
           "value" => "5",
        ),
        array(
            "type" => "dropdown",
            "heading" => esc_attr__("Columns", 'modeltheme'),
            "param_name" => "columns",
            "std" => '',
            "holder" => "div",
            "class" => "",
            "description" => "",
            "value" => array(
                esc_attr__('3 Columns', 'modeltheme')  => 'vc_col-md-4',
                esc_attr__('4 Columns', 'modeltheme')  => 'vc_col-md-3',
                esc_attr__('6 Columns', 'modeltheme')  => 'vc_col-md-6',
            )
        ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Select Category", 'modeltheme'),
           "param_name" => "category",
           "description" => esc_attr__("Please select a category", 'modeltheme'),
           "std" => 'Default value',
           "value" => $mt_service_category
        ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Select style type", 'modeltheme'),
           "param_name" => "style_type",
           "description" => esc_attr__("Please choose style type", 'modeltheme'),
           "std" => 'Default value',
           "value" => array(
            esc_attr__('Style 1 - Single color', 'modeltheme')   => 'single_color',
            esc_attr__('Style 2 - Dual color', 'modeltheme')     => 'dual_color'
           )
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
      )
  ));





  #SHORTCODE: Progress bars shortcode
    vc_map( 
        array(
        "name" => esc_attr__("Progress bar", 'modeltheme', 'modeltheme'),
        "base" => "progress_bar",
        "category" => esc_attr__('pomana Theme', 'modeltheme', 'modeltheme'),
        "icon" => plugins_url( 'images/progress-bar.svg', __FILE__ ),
        "params" => array(
            array(
                "group" => "Options",
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar tooltip", 'modeltheme'),
                "param_name" => "tooltip_option",
                "std" => '',
                "description" => "",
                "value" => array(
                    esc_attr__('Tooltip on', 'modeltheme')     => 'tooltip_on',
                    esc_attr__('Tooltip off', 'modeltheme')    => 'tooltip_off'
                )
            ),
            array(
                "group" => "Options",
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar scope", 'modeltheme'),
                "param_name" => "bar_scope",
                "std" => '',
                "description" => "",
                "value" => array(
                    esc_attr__('Success', 'modeltheme')     => 'success',
                    esc_attr__('Info', 'modeltheme')        => 'info',
                    esc_attr__('Warning', 'modeltheme')     => 'warning',
                    esc_attr__('Danger', 'modeltheme')      => 'danger'
                )
            ),
            array(
                "group" => "Options",
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar style", 'modeltheme'),
                "param_name" => "bar_style",
                "std" => '',
                "description" => "",
                "value" => array(
                    esc_attr__('Simple', 'modeltheme')     => 'simple',
                    esc_attr__('Striped', 'modeltheme')    => 'progress-bar-striped'
                )
            ),
            array(
                "group" => "Options",
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar value (1-100)", 'modeltheme'),
                "param_name" => "bar_value",
                "value" => "40",
                "description" => ""
            ),
            array(
                "group" => "Options",
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar text", 'modeltheme'),
                "param_name" => "bar_label_text",
                "value" => esc_attr__("Complete", 'modeltheme'),
                "description" => ""
            ),
            array(
                "group" => "Options",
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Progress bar percentage", 'modeltheme'),
                "param_name" => "bar_label_percentage",
                "value" => esc_attr__("40%", 'modeltheme'),
                "description" => ""
            )
        )
    ));




  #SHORTCODE: Skill counter shortcode
  vc_map( array(
     "name" => __("Skill counter", 'modeltheme'),
     "base" => "skill",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/skill-counter.svg', __FILE__ ),
     "params" => array(
        array(
          "group" => "Options",
          "type" => "dropdown",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__("Skill media", 'modeltheme'),
          "param_name" => "icon_or_image",
          "std" => '',
          "description" => esc_attr__("Choose what you want to use: empty/image/icon", 'modeltheme'),
          "value" => array(
          'Nothing'     => 'choosed_nothing',
          'Use an image'     => 'choosed_image',
          'Use an icon'      => 'choosed_icon'
          )
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
          "type" => "dropdown",
          "dependency" => array(
           'element' => 'icon_or_image',
           'value' => array( 'choosed_icon' ),
           ),
          "heading" => esc_attr__("Icon class(FontAwesome)", 'modeltheme'),
          "param_name" => "icon",
          "std" => 'fa fa-lightbulb-o',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $fa_list
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
          "group" => esc_attr__("Options", 'modeltheme'),
          "group" => esc_attr__("Options", 'modeltheme'),
          "dependency" => array(
           'element' => 'icon_or_image',
           'value' => array( 'choosed_image' ),
           ),
          "type" => "attach_images",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__( "Choose image", 'modeltheme' ),
          "param_name" => "image_skill",
          "value" => "",
          "description" => esc_attr__( "Choose image for skill", 'modeltheme' )
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Title", 'modeltheme'),
           "param_name" => "title",
           "value" => esc_attr__("COMPLETED PROJECTS", 'modeltheme'),
           "description" => esc_attr__("")
        ),
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Skill value", 'modeltheme'),
           "param_name" => "skillvalue",
           "value" => "3200",
           "description" => esc_attr__("")
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Bordered", 'modeltheme'),
          "param_name" => "has_border",
          "std" => 'unbordered',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => array(
              esc_attr__('Bordered', 'modeltheme')  => 'bordered',
              esc_attr__('Without border', 'modeltheme') => 'unbordered',
              )
        ),
     )
  ));


    #SHORTCODE: Pricing table shortcode2
    vc_map( array(
     "name" => esc_attr__("Pricing Table (Simple List)", 'modeltheme'),
     "base" => "pricing-table",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
     "params" => array(
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package style", 'modeltheme'),
           "param_name" => "package_style",
           "std" => '',
           "value" => array(
            'Style 1'     => 'pricing--tenzin',
            'Style 2'     => 'pricing--norbu',
            'Style 3'     => 'pricing--pema'
           )
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "dependency" => array(
           'element' => 'package_style',
           'value' => array( 'pricing--norbu','pricing--pema' ),
           ),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package period", 'modeltheme'),
           "param_name" => "package_period",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "dependency" => array(
           'element' => 'package_style',
           'value' => array( 'pricing--pema' ),
           ),
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package Recommended", 'modeltheme'),
           "param_name" => "package_recommended",
           "std" => '',
           "value" => array(
            'Basic'           => 'pricing__item--nofeatured',
            'Recommended'     => 'pricing__item--featured'
           )
        ),
          array(
           "group" => "Options",
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package name", 'modeltheme'),
           "param_name" => "package_name",
           "value" => esc_attr__("", 'modeltheme'),
           "description" => ""
        ),

        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package currency", 'modeltheme'),
           "param_name" => "package_currency",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 1st feature", 'modeltheme'),
           "param_name" => "package_feature1",

        ),
                 array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price1", 'modeltheme'),
           "param_name" => "package_price",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 2nd feature", 'modeltheme'),
           "param_name" => "package_feature2",

        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price2", 'modeltheme'),
           "param_name" => "package_price2",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 3rd feature", 'modeltheme'),
           "param_name" => "package_feature3",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price3", 'modeltheme'),
           "param_name" => "package_price3",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 4th feature", 'modeltheme'),
           "param_name" => "package_feature4",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price4", 'modeltheme'),
           "param_name" => "package_price4",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 5th feature", 'modeltheme'),
           "param_name" => "package_feature5",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price5", 'modeltheme'),
           "param_name" => "package_price5",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 6th feature", 'modeltheme'),
           "param_name" => "package_feature6",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price6", 'modeltheme'),
           "param_name" => "package_price6",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 7th feature", 'modeltheme'),
           "param_name" => "package_feature7",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price7", 'modeltheme'),
           "param_name" => "package_price7",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 8th feature", 'modeltheme'),
           "param_name" => "package_feature8",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price8", 'modeltheme'),
           "param_name" => "package_price8",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 9th feature", 'modeltheme'),
           "param_name" => "package_feature9",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price9", 'modeltheme'),
           "param_name" => "package_price9",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package's 10th feature", 'modeltheme'),
           "param_name" => "package_feature10",
        ),
         array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package price10", 'modeltheme'),
           "param_name" => "package_price10",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package button url", 'modeltheme'),
           "param_name" => "button_url",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Package button text", 'modeltheme'),
           "param_name" => "button_text",
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--tenzin' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Differential package color", 'modeltheme' ),
          "param_name" => "package_differential_color_style1",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose differential package color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--pema' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Price package color", 'modeltheme' ),
          "param_name" => "package_differential_color_style3",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose the price color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--pema' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Package background color", 'modeltheme' ),
          "param_name" => "package_background_style3",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose package background color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--pema' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Package hover background color", 'modeltheme' ),
          "param_name" => "package_background_hover_style3",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose package hover background color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--tenzin' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Differential package color", 'modeltheme' ),
          "param_name" => "package_differential_hover_color_style1",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose differential package hover color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--pema' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Package button color", 'modeltheme' ),
          "param_name" => "package_button_color_style3",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose package button color", 'modeltheme' )
        ),
        array(
          "group" => "Styling",
          "dependency" => array(
          'element' => 'package_style',
          'value' => array( 'pricing--pema' ),
          ),
          "type" => "colorpicker",
          "class" => "",
          "heading" => esc_attr__( "Package button hover color", 'modeltheme' ),
          "param_name" => "package_button_hover_color_style3",
          "value" => "", //Default color
          "description" => esc_attr__( "Choose package button hover color", 'modeltheme' )
        ),
        array(
          "group" => "Animation",
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => "",
          "value" => $animations_list
        )
     )
  ));


// pomana - Pricing table
    vc_map( 
      array(
       "name" => esc_attr__("Pricing table", "modeltheme"),
       "base" => "pricing-table-v2",
       "category" => esc_attr__("pomana Theme", "modeltheme"),
        "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
       "params" => array(
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package name", "modeltheme"),
             "param_name" => "package_name",
             "value" => esc_attr__("BASIC", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package price", "modeltheme"),
             "param_name" => "package_price",
             "value" => esc_attr__("199", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package currency", "modeltheme"),
             "param_name" => "package_currency"
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package basis", "modeltheme"),
             "param_name" => "package_basis"
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package Description", "modeltheme"),
             "param_name" => "package_desc"
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 1st feature", "modeltheme"),
             "param_name" => "package_feature1",
             "value" => esc_attr__("05 Email Account", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 2nd feature", "modeltheme"),
             "param_name" => "package_feature2",
             "value" => esc_attr__("01 Website Layout", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 3rd feature", "modeltheme"),
             "param_name" => "package_feature3",
             "value" => esc_attr__("03 Photo Stock Banner", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 4th feature", "modeltheme"),
             "param_name" => "package_feature4",
             "value" => esc_attr__("01 Javascript Slider", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 5th feature", "modeltheme"),
             "param_name" => "package_feature5",
             "value" => esc_attr__("01 Hosting", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package's 6th feature", "modeltheme"),
             "param_name" => "package_feature6",
             "value" => esc_attr__("01 Domain Name Server", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package button url", "modeltheme"),
             "param_name" => "button_url",
             "value" => esc_attr__("#", "modeltheme")
          ),
          array(
             "type" => "textfield",
             "holder" => "div",
             "class" => "",
             "heading" => esc_attr__("Package button text", "modeltheme"),
             "param_name" => "button_text",
             "value" => esc_attr__("Purchase", "modeltheme")
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_attr__("Animation", "modeltheme"),
            "param_name" => "animation",
            "std" => 'fadeInLeft',
            "holder" => "div",
            "class" => "",
            "value" => $animations_list
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_attr__("Recommended?", "modeltheme"),
            "param_name" => "recommended",
            "value" => array(
              esc_attr__('Simple', "modeltheme")      => 'simple',
              esc_attr__('Recommended', "modeltheme") => 'recommended',
              ),
            "std" => 'simple',
            "holder" => "div",
            "class" => ""
          )
       )
    ));


  #SHORTCODE: Heading with border
  vc_map( array(
     "name" => __("Heading with Border (no sub heading)", 'modeltheme'),
     "base" => "heading-border",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/heading.svg', __FILE__ ),
     "params" => array(
        array(
           "type" => "dropdown",
          "heading" => esc_attr__("Alignment", 'modeltheme', 'modeltheme'),
          "param_name" => "align",
          "std" => 'left',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => array(
              esc_attr__('left', 'modeltheme') => 'left',
              esc_attr__('right', 'modeltheme') => 'right',
              )
        ),
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Heading", 'modeltheme' ),
            "param_name" => "content", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
            "value" => esc_attr__( "OUR<br>WORK", 'modeltheme' ),
            "description" => esc_attr__( "Enter your heading.", 'modeltheme' )
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
     )
  ));





  #SHORTCODE: Testimonials Slider V2
  vc_map( array(
     "name" => __("Testimonials Slider V2", 'modeltheme'),
     "base" => "testimonials-style2",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/testimonials-slider.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Number of testimonials", 'modeltheme' ),
            "param_name" => "number",
            "value" => "5",
            "description" => esc_attr__( "Enter number of testimonials to show.", 'modeltheme' )
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
     )
  ));




  #SHORTCODE: List group
  vc_map( array(
     "name" => __("List group", 'modeltheme'),
     "base" => "list_group",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/list-group.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "List group item heading", 'modeltheme' ),
            "param_name" => "heading",
            "value" => esc_attr__( "List group item heading", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
         array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "List group item description", 'modeltheme' ),
            "param_name" => "description",
            "value" => esc_attr__( "Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Status", 'modeltheme'),
          "param_name" => "active",
          "value" => array(
            esc_attr__('Active', 'modeltheme')   => 'active',
            esc_attr__('Normal', 'modeltheme')   => 'normal',
            ),
          "std" => 'normal',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("")
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
     )
  ));



  #SHORTCODE: BUTTONS
  vc_map( array(
     "name" => __("Button", 'modeltheme'),
     "base" => "pomana_btn",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/button.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Button text" , 'modeltheme'),
            "param_name" => "btn_text",
            "value" => esc_attr__( "Shop now", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Button url", 'modeltheme' ),
            "param_name" => "btn_url",
            "value" => esc_attr__( "#" ),
            "description" => esc_attr__( "" )
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Button size", 'modeltheme'),
          "param_name" => "btn_size",
          "value" => array(
            esc_attr__('Small', 'modeltheme')   => 'btn btn-sm',
            esc_attr__('Medium', 'modeltheme')   => 'btn btn-medium',
            esc_attr__('Large', 'modeltheme')   => 'btn btn-lg',
            esc_attr__('Extra-Large', 'modeltheme')   => 'extra-large'
            ),
          "std" => 'normal',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("")
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Alignment", 'modeltheme'),
          "param_name" => "align",
          "value" => array(
            esc_attr__('Left', 'modeltheme')   => 'text-left',
            esc_attr__('Center', 'modeltheme')   => 'text-center',
            esc_attr__('Right', 'modeltheme')   => 'text-right'
            ),
          "std" => 'normal',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("")
        ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => esc_attr__( "Choose custom background color" , 'modeltheme'),
            "param_name" => "color",
            "value" => '#FFBA41', //Default color #FFBA41
            "description" => esc_attr__( "Choose background color", 'modeltheme' )
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => esc_attr__( "Choose custom hover background color", 'modeltheme' ),
            "param_name" => "color_hover",
            "value" => '#FFBA41', //Default color #FFBA41
            "description" => esc_attr__( "Choose hover background color", 'modeltheme' )
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => esc_attr__( "Text color", 'modeltheme' ),
            "param_name" => "text_color",
            "description" => esc_attr__( "Choose text color" , 'modeltheme')
         ),
        array(
            "type" => "colorpicker",
            "class" => "",
            "heading" => esc_attr__( "Hover text color", 'modeltheme' ),
            "param_name" => "hover_text_color",
            "value" => '#ffffff', //Default color #ffffff
            "description" => esc_attr__( "Choose hover text color" , 'modeltheme')
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
     )
  ));




  // SHORTCODE: Heading with bottom border
  vc_map( array(
     "name" => __("Heading with bottom border", 'modeltheme'),
     "base" => "heading_border_bottom",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/section-title-heading.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Heading", 'modeltheme' ),
            "param_name" => "heading",
            "value" => esc_attr__( "Our Work", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Heading align(left/right)", 'modeltheme'),
          "param_name" => "text_align",
          "value" => array(
            esc_attr__('Left', 'modeltheme')   => 'text-left',
            esc_attr__('Right', 'modeltheme')   => 'text-right',
            esc_attr__('Center', 'modeltheme')   => 'text-center',
            ),
          "std" => 'text-left',
          "holder" => "div",
          "class" => "",
        ),
        array(
          "type" => "textfield",
          "heading" => esc_attr__("Heading font size", 'modeltheme'),
          "param_name" => "text_size",
          "holder" => "div",
          "class" => "",
        ),
        array(
          "type" => "textfield",
          "heading" => esc_attr__("Heading line height", 'modeltheme'),
          "param_name" => "text_line_height",
          "holder" => "div",
          "class" => "",
        ),
        array(
          "type" => "textfield",
          "heading" => esc_attr__("Heading color", 'modeltheme'),
          "param_name" => "text_color",
          "holder" => "div",
          "class" => "",
        ),
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Heading", 'modeltheme' ),
            "param_name" => "heading",
            "value" => esc_attr__( "Our Work", 'modeltheme' ),
         ),
     )
  ));



  // SHORTCODE: Call to Action
  vc_map( array(
     "name" => __("Call to Action", 'modeltheme'),
     "base" => "modeltheme-call-to-action",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
      "icon" => plugins_url( 'images/call-to-action.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Heading", 'modeltheme' ),
            "param_name" => "heading",
            "value" => esc_attr__( "pomana Is The Ultimate WordPress Multi-Purpose WordPress Theme!", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Heading type", 'modeltheme'),
           "param_name" => "heading_type",
           "std" => 'h2',
           "description" => esc_attr__(""),
           "value" => array(
            esc_attr__('Heading H1', 'modeltheme')     => 'h1',
            esc_attr__('Heading H2', 'modeltheme')     => 'h2',
            esc_attr__('Heading H3', 'modeltheme')     => 'h3',
            esc_attr__('Heading H4', 'modeltheme')     => 'h4',
            esc_attr__('Heading H5', 'modeltheme')     => 'h5',
            esc_attr__('Heading H6', 'modeltheme')     => 'h6'
           )
        ),
         array(
            "type" => "textarea",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Subheading", 'modeltheme' ),
            "param_name" => "subheading",
            "value" => esc_attr__( "Loaded with awesome features like Visual Composer, premium sliders, unlimited colors, advanced theme options & more!", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Text align", 'modeltheme'),
           "param_name" => "align",
           "std" => 'text-left',
           "description" => esc_attr__("Text align of Title and subtitle", 'modeltheme'),
           "value" => array(
            esc_attr__('Align left', 'modeltheme')     => 'text-left',
            esc_attr__('Align center', 'modeltheme')        => 'text-center',
            esc_attr__('Align right', 'modeltheme')     => 'text-right'
           )
        ),
     )
  ));



  // SHORTCODE: Section Heading with Title and Subtitle
  vc_map( array(
     "name" => __("Heading with Title and Subtitle", 'modeltheme'),
     "base" => "heading_title_subtitle",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/section-title-heading.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Section title", 'modeltheme' ),
            "param_name" => "title",
            "value" => esc_attr__( "" ),
            "description" => esc_attr__( "" )
         ),
         array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Title Color", 'modeltheme'),
           "param_name" => "title_color",
           "description" => esc_attr__(""),
           "value" => array(
            esc_attr__('Light color title for dark section', 'modeltheme')     => 'light_title',
            esc_attr__('Dark color title for light section', 'modeltheme')     => 'dark_title'
           ),
           "std" => ''
        ),
         array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Border Section Color", 'modeltheme'),
           "param_name" => "border_color",
           "description" => esc_attr__(""),
           "value" => array(
            esc_attr__('Light border for dark section', 'modeltheme')     => 'light_border',
            esc_attr__('Dark border for light section', 'modeltheme')     => 'dark_border'
           ),
           "std" => ''
        ),
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Section subtitle", 'modeltheme' ),
            "param_name" => "subtitle",
            "value" => esc_attr__( "" ),
            "description" => esc_attr__( "" )
         ),
         array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Subtitle Color", 'modeltheme'),
           "param_name" => "subtitle_color",
           "description" => esc_attr__(""),
           "value" => array(
            esc_attr__('Light color subtitle for dark section', 'modeltheme')     => 'light_subtitle',
            esc_attr__('Dark color subtitle for light section', 'modeltheme')     => 'dark_subtitle'
           ),
           "std" => ''
        )
         
     )
  ));

  // SHORTCODE: Section Heading with Title
  vc_map( array(
     "name" => __("Heading with Title (no subtitle)", 'modeltheme'),
     "base" => "heading_title",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/section-title-heading.svg', __FILE__ ),
     "params" => array(
         array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Section title", 'modeltheme' ),
            "param_name" => "title",
            "value" => esc_attr__( "OUR <span>SERVICES</span>", 'modeltheme' ),
            "description" => esc_attr__( "" )
         ),
         array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
         
     )
  ));



  $post_category_tax = get_terms('category');
  $post_category = array();
  foreach ( $post_category_tax as $term ) {
     $post_category[$term->name] = $term->slug;
  }

  // SHORTCODE: Blog Posts
  vc_map( array(
     "name" => __("Blog Grid", 'modeltheme'),
     "base" => "modeltheme-blog-posts",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/blog.svg', __FILE__ ),
     "params" => array(
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Select style type", 'modeltheme'),
           "param_name" => "style_type",
           "description" => esc_attr__("Please choose style type", 'modeltheme'),
           "std" => 'Default value',
           "value" => array(
            esc_attr__('Style 1 (default)', 'modeltheme')   => 'style_1',
            esc_attr__('Style 2 (Blood Donation demo)', 'modeltheme')     => 'style_2'
           )
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "class" => "",
            "heading" => esc_attr__( "Number", 'modeltheme' ),
            "param_name" => "number",
            "value" => "5",
            "description" => esc_attr__( "" )
        ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Select Blog Category", 'modeltheme'),
           "param_name" => "category",
           "description" => esc_attr__("Please select blog category", 'modeltheme'),
           "std" => esc_attr__('Default value', 'modeltheme'),
           "value" => $post_category
        ),
        array(
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Columns", 'modeltheme'),
           "param_name" => "columns",
           "std" => '',
           "description" => esc_attr__(""),
           "value" => array(
            esc_attr__('2 columns', 'modeltheme')     => 'vc_col-sm-6',
            esc_attr__('3 columns', 'modeltheme')     => 'vc_col-sm-4',
            esc_attr__('4 columns', 'modeltheme')     => 'vc_col-sm-3'
           )
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => 'fadeInLeft',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__(""),
          "value" => $animations_list
        )
     )
  ));




  // SHORTCODE: Coundown
  vc_map( array(
     "name" => __("Countdown", 'modeltheme'),
     "base" => "modeltheme-countdown",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/countdown.svg', __FILE__ ),
     "params" => array(
        array(
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Date", 'modeltheme'),
           "param_name" => "date",
           "value" => "2015/12/12",
           "description" => esc_attr__("Eg: 2015/12/12", 'modeltheme')
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Color of the digits", 'modeltheme'),
           "param_name" => "digit_color",
           "value" => "#495153",
           "description" => esc_attr__("")
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Color of the text", 'modeltheme'),
           "param_name" => "textcolor",
           "value" => "#848685",
           "description" => esc_attr__("")
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Color of the dots", 'modeltheme'),
           "param_name" => "dots_color",
           "value" => "#48A8A7",
           "description" => esc_attr__("")
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Background color", 'modeltheme'),
           "param_name" => "background_color_count",
           "value" => "#FBFBFB",
           "description" => esc_attr__("")
        ),
        array(
           "type" => "colorpicker",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Border color", 'modeltheme'),
           "param_name" => "border_color_count",
           "value" => "#C7C7C7",
           "description" => esc_attr__("")
        )

     )
  ));  

  $product_category = array();
        if ( class_exists( 'WooCommerce' ) ) {
          $product_category_tax = get_terms( 'product_cat', array(
            'parent'      => '0'
          ));
          if ($product_category_tax) {
            foreach ( $product_category_tax as $term ) {
              if ($term) {
                $product_category[$term->name] = $term->slug;
              }
            }
          }
        }

        // pomana - Products by Category v2
        vc_map( 
          array(
           "name" => esc_attr__("Products by Category", 'modeltheme'),
           "base" => "shop-categories-with-xsthumbnails",
           "category" => esc_attr__('pomana Theme', 'modeltheme'),
           "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
           "params" => array(
              array(
                 "group" => "Settings",
                 "type" => "dropdown",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Select Products Category", 'modeltheme'),
                 "param_name" => "category",
                 "description" => esc_attr__("Please select WooCommerce Category", 'modeltheme'),
                 "std" => 'Default value',
                 "value" => $product_category
              ),
              array(
                "group" => "Settings",
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Button text", 'modeltheme'),
                 "param_name" => "products_label_text",
                 "description" => esc_attr__("A text to replace the 'Products' label", 'modeltheme'),
              ),
              array(
                "group" => "Styling",
                "type" => "colorpicker",
                "class" => "",
                "heading" => esc_attr__( "Background Banner Color 1", 'modeltheme' ),
                "param_name" => "overlay_color1",
                "value" => "", //Default color
                "description" => esc_attr__( "Choose banner color", 'modeltheme' )
              ),
              array(
                      "group" => "Styling",
                      "type" => "colorpicker",
                      "class" => "",
                      "heading" => esc_attr__( "Background Banner Color 2", 'modeltheme' ),
                      "param_name" => "overlay_color2",
                      "value" => "", //Default color
                      "description" => esc_attr__( "Choose banner color", 'modeltheme' )
              ),
               array(
                  "type" => "attach_image",
                  "group" => "Styling",
                  "holder" => "div",
                  "class" => "",
                  "heading" => esc_attr__( "Background Image (Optional)", 'modeltheme' ),
                  "description" => esc_attr__("If this option is empty, the colors from colorpickers will be applied.", 'modeltheme'),
                  "param_name" => "bg_image",
               ),
           )
        ));

         //  Products Carousel
        vc_map( 
          array(
            "name" => esc_attr__("Products Carousel", 'modeltheme'),
            "base" => "mt-products-carousel",
            "category" => esc_attr__('pomana Theme', 'modeltheme'),
            "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
            "params" => array(
                array(
                 "group" => "Settings",
                 "type" => "dropdown",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Select Products Category", 'modeltheme'),
                 "param_name" => "category",
                 "description" => esc_attr__("Please select WooCommerce Category", 'modeltheme'),
                 "std" => 'Default value',
                 "value" => $product_category
              ),
              array(
                 "group" => "Settings",
                 "type" => "textfield",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Number of products to show", 'modeltheme'),
                 "param_name" => "number_of_products_by_category"
              ),
              array(
                 "group" => "Settings",
                 "type" => "dropdown",
                 "holder" => "div",
                 "class" => "",
                 "heading" => esc_attr__("Products per column", 'modeltheme'),
                 "param_name" => "number_of_columns",
                 "value" => array(
                  '2'        => 'col-md-6',
                  '3'        => 'col-md-4',
                  '4'        => 'col-md-3'
                 ),
              ),
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Number of products", 'modeltheme' ),
                    "param_name" => "number",
                    "value" => "",
                    "description" => esc_attr__( "Enter number of products to show.", 'modeltheme' )
                ),
                array(
                    "group" => "Slider Options",
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "",
                    "param_name" => "order",
                    "std"          => '',
                    "heading" => esc_attr__( "Order options", 'modeltheme' ),
                    "description" => esc_attr__( "Order ascending or descending by date", 'modeltheme' ),
                    "value"        => array(
                        esc_attr__('Ascending', 'modeltheme') => 'asc',
                        esc_attr__('Descending', 'modeltheme') => 'desc',
                    )
                    
                ),
                array(
                    "group" => "Slider Options",
                    "type"         => "dropdown",
                    "holder"       => "div",
                    "class"        => "",
                    "param_name"   => "navigation",
                    "std"          => '',
                    "heading"      => esc_attr__("Navigation", 'modeltheme'),
                    "description"  => "",
                    "value"        => array(
                        esc_attr__('Disabled', 'modeltheme') => 'false',
                        esc_attr__('Enabled', 'modeltheme')    => 'true',
                    )
                ),
                array(
                    "group" => "Slider Options",
                    "type"         => "dropdown",
                    "holder"       => "div",
                    "class"        => "",
                    "param_name"   => "pagination",
                    "std"          => '',
                    "heading"      => esc_attr__("Pagination", 'modeltheme'),
                    "description"  => "",
                    "value"        => array(
                        esc_attr__('Disabled', 'modeltheme') => 'false',
                        esc_attr__('Enabled', 'modeltheme')    => 'true',
                    )
                ),
                array(
                    "group" => "Slider Options",
                    "type"         => "dropdown",
                    "holder"       => "div",
                    "class"        => "",
                    "param_name"   => "autoPlay",
                    "std"          => '',
                    "heading"      => esc_attr__("Auto Play", 'modeltheme'),
                    "description"  => "",
                    "value"        => array(
                        esc_attr__('Disabled', 'modeltheme') => 'false',
                        esc_attr__('Enabled', 'modeltheme')    => 'true',
                    )
                ),
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Pagination Speed", 'modeltheme' ),
                    "param_name" => "paginationSpeed",
                    "value" => "",
                    "description" => esc_attr__( "Pagination Speed(Default: 700)", 'modeltheme' )
                ),
                
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Slide Speed", 'modeltheme' ),
                    "param_name" => "slideSpeed",
                    "value" => "",
                    "description" => esc_attr__( "Slide Speed(Default: 700)", 'modeltheme' )
                ),
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Items for Desktops", 'modeltheme' ),
                    "param_name" => "number_desktop",
                    "value" => "",
                    "description" => esc_attr__( "Default - 4", 'modeltheme' )
                ),
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Items for Tablets", 'modeltheme' ),
                    "param_name" => "number_tablets",
                    "value" => "",
                    "description" => esc_attr__( "Default - 2", 'modeltheme' )
                ),
                array(
                    "group" => "Slider Options",
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Items for Mobile", 'modeltheme' ),
                    "param_name" => "number_mobile",
                    "value" => "",
                    "description" => esc_attr__( "Default - 1", 'modeltheme' )
                ),
                array(
                    "group" => "Animation",
                    "type" => "dropdown",
                    "heading" => esc_attr__("Animation", 'modeltheme'),
                    "param_name" => "animation",
                    "std" => '',
                    "holder" => "div",
                    "class" => "",
                    "description" => "",
                    "value" => $animations_list
                ),
            )
        ));


  // vc_map( array(
  //    "name" => esc_attr__("Icon List Item", 'modeltheme'),
  //    "base" => "mt_icon_list_item",
  //    "category" => esc_attr__('pomana Theme', 'modeltheme'),
  //    "icon" => "modeltheme_shortcode",
  //    "params" => array(
  //       array(
  //         "group" => esc_attr__("Icon Setup", 'modeltheme'),
  //         "type" => "dropdown",
  //         "heading" => esc_attr__("Icon", 'modeltheme'),
  //         "param_name" => "list_icon",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => "",
  //         "value" => $fa_list
  //       ),
  //       array(
  //         "group" => esc_attr__("Icon Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "holder" => "div",
  //         "class" => "",
  //         "heading" => esc_attr__("Icon Size (px)", 'modeltheme'),
  //         "param_name" => "list_icon_size",
  //         "value" => "",
  //         "description" => esc_attr__("Default: 18(px)", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => esc_attr__("Icon Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "holder" => "div",
  //         "class" => "",
  //         "heading" => esc_attr__("Icon Margin right (px)", 'modeltheme'),
  //         "param_name" => "list_icon_margin",
  //         "value" => "",
  //       ),
  //       array(
  //         "group" => esc_attr__("Icon Setup", 'modeltheme'),
  //         "type" => "colorpicker",
  //         "holder" => "div",
  //         "class" => "",
  //         "heading" => esc_attr__("Icon Color", 'modeltheme'),
  //         "param_name" => "list_icon_color",
  //         "value" => "",
  //       ),
  //       array(
  //         "group" => esc_attr__("Label Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "heading" => esc_attr__("Label/Title", 'modeltheme'),
  //         "param_name" => "list_icon_title",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => esc_attr__("Eg: This is a label", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => esc_attr__("Label Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "heading" => esc_attr__("Label/Icon URL", 'modeltheme'),
  //         "param_name" => "list_icon_url",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => esc_attr__("Eg: http://modeltheme.com", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => esc_attr__("Label Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "heading" => esc_attr__("Title Font Size", 'modeltheme'),
  //         "param_name" => "list_icon_title_size",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => esc_attr__("Default: 18(px)", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => esc_attr__("Label Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "heading" => esc_attr__("Title line height", 'modeltheme'),
  //         "param_name" => "list_icon_title_line_height",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => esc_attr__("Default: 13(px)", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => esc_attr__("Label Setup", 'modeltheme'),
  //         "type" => "textfield",
  //         "heading" => esc_attr__("Title font weight", 'modeltheme'),
  //         "param_name" => "list_icon_title_font_weight",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //         "description" => esc_attr__("Default: 600", 'modeltheme'),
  //       ),
  //       array(
  //         "group" => "Label Setup",
  //         "type" => "colorpicker",
  //         "heading" => esc_attr__("Title Color", 'modeltheme'),
  //         "param_name" => "list_icon_title_color",
  //         "std" => '',
  //         "holder" => "div",
  //         "class" => "",
  //       ),
  //    )
  //   ));


    vc_map( array(
     "name" => esc_attr__("Image List Item", 'modeltheme'),
     "base" => "mt_image_list_item",
     "category" => esc_attr__('pomana Theme', 'modeltheme'),
     "icon" => plugins_url( 'images/list-group.svg', __FILE__ ),
     "params" => array(
        array(
          "group" => esc_attr__("Icon Setup", 'modeltheme'),
          "type" => "dropdown",
          "heading" => esc_attr__("Icon class(FontAwesome)", 'modeltheme'),
          "param_name" => "list_icon",
          "std" => 'fa fa-check-circle',
          "holder" => "div",
          "class" => "",
          "value" => $fa_list
        ),
        array(
          "group" => esc_attr__("Icon Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Icon size", 'modeltheme'),
          "param_name" => "list_icon_size",
          "std" => '',
          "holder" => "div",
          "class" => "",
        ),
        array(
          "group" => esc_attr__("Icon Setup", 'modeltheme'),
          "type" => "colorpicker",
          "heading" => esc_attr__("Icon color", 'modeltheme'),
          "param_name" => "list_icon_colors",
          "std" => '',
          "holder" => "div",
          "class" => "",
        ),
        array(
          "group" => esc_attr__("Icon Setup", 'modeltheme'),
          "type" => "colorpicker",
          "heading" => esc_attr__("Icon background", 'modeltheme'),
          "param_name" => "list_icon_backgrounds",
          "std" => '',
          "holder" => "div",
          "class" => "",
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Label/Title", 'modeltheme'),
          "param_name" => "list_icon_title",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Eg: This is a label", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Label/Icon URL", 'modeltheme'),
          "param_name" => "list_icon_url",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Eg: http://modeltheme.com", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Title Font Size", 'modeltheme'),
          "param_name" => "list_icon_title_size",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 18(px)", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Title line height", 'modeltheme'),
          "param_name" => "list_icon_title_line_height",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 13(px)", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Title font weight", 'modeltheme'),
          "param_name" => "list_icon_title_font_weight",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 600", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "colorpicker",
          "heading" => esc_attr__("Title Color", 'modeltheme'),
          "param_name" => "list_icon_title_color",
          "std" => '',
          "holder" => "div",
          "class" => "",
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Label/Subtitle", 'modeltheme'),
          "param_name" => "list_icon_subtitle",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Eg: This is a label", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Subtitle Font Size", 'modeltheme'),
          "param_name" => "list_icon_subtitle_size",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 18(px)", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Subtitle line height", 'modeltheme'),
          "param_name" => "list_icon_subtitle_line_height",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 13(px)", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "textfield",
          "heading" => esc_attr__("Subtitle font weight", 'modeltheme'),
          "param_name" => "list_icon_subtitle_font_weight",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "description" => esc_attr__("Default: 600", 'modeltheme')
        ),
        array(
          "group" => esc_attr__("Label Setup", 'modeltheme'),
          "type" => "colorpicker",
          "heading" => esc_attr__("Subtitle Color", 'modeltheme'),
          "param_name" => "list_icon_subtitle_color",
          "std" => '',
          "holder" => "div",
          "class" => "",
        )
     )
    ));

      vc_map( array(
       "name" => esc_attr__("Video Popup", 'modeltheme'),
       "base" => "shortcode_video",
       "category" => esc_attr__('pomana Theme', 'modeltheme'),
       "icon" => plugins_url( 'images/video-popup.svg', __FILE__ ),
       "params" => array(
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
          "type" => "attach_images",
          "holder" => "div",
          "class" => "",
          "heading" => esc_attr__( "Choose image", 'modeltheme' ),
          "param_name" => "button_image",
          "value" => "",
          "description" => esc_attr__( "Choose image for play button", 'modeltheme' )
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Video source", 'modeltheme'),
           "param_name" => "video_source",
           "std" => '',
           "value" => array(
            'Youtube'   => 'source_youtube',
            'Vimeo'     => 'source_vimeo',
            )
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
             "dependency" => array(
             'element' => 'video_source',
             'value' => array( 'source_vimeo' ),
           ),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Vimeo id link", 'modeltheme'),
           "param_name" => "vimeo_link_id",
        ),
        array(
          "group" => esc_attr__("Options", 'modeltheme'),
           "dependency" => array(
           'element' => 'video_source',
           'value' => array( 'source_youtube' ),
           ),
           "type" => "textfield",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Youtube id link", 'modeltheme'),
           "param_name" => "youtube_link_id",
        ),
        array(
          "group" => esc_attr__("Animation", 'modeltheme'),
          "type" => "dropdown",
          "heading" => esc_attr__("Animation", 'modeltheme'),
          "param_name" => "animation",
          "std" => '',
          "holder" => "div",
          "class" => "",
          "value" => $animations_list
        )
        )));

        #SHORTCODE: MT Row Overlay
        vc_map( array(
           "name" => __("Row Overlay", 'modeltheme'),
           "base" => "mt_row_separator",
           "category" => esc_attr__('pomana Theme', 'modeltheme'),
           "icon" => plugins_url( 'images/separator.svg', __FILE__ ),
           "params" => array(
              array(
                  "type" => "colorpicker",
                  "class" => "",
                  "heading" => esc_attr__( "Overlay Background", 'modeltheme' ),
                  "param_name" => "bg_color",
                  "value" => '#FFBA41', //Default color #FFBA41
                  "description" => esc_attr__( "Set the background color of the Overlay Separator", 'modeltheme' )
               ),
              array(
                  'type' => 'css_editor',
                  'heading' => __( 'CSS Styling', 'modeltheme' ),
                  'param_name' => 'css',
                  'group' => __( 'Design options', 'modeltheme' ),
              ),
           )
        ));

        #SHORTCODE: MT Row Separator
        vc_map( array(
           "name" => __("Tabs categories", 'modeltheme'),
           "base" => "mt_tabs_categories",
           "category" => esc_attr__('pomana Theme', 'modeltheme'),
           "icon" => plugins_url( 'images/tabs.svg', __FILE__ ),
           "params" => array(
            /* CAT 1 */
            array(
                "group" => esc_attr__( "First item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose icon", 'modeltheme' ),
                "param_name" => "tabs_item_icon1",
                "value" => "",
                "description" => esc_attr__( "Choose icon for first category", 'modeltheme' )
            ),
            array(
                "group"        => esc_attr__( "First item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_title_tab1",
                "heading"      => esc_attr__("Title of column1", 'modeltheme'),
                "description"  => esc_attr__("Enter title of column1", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "First item", 'modeltheme' ),
                "type"         => "textarea",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_content1",
                "heading"      => esc_attr__("Description of column1", 'modeltheme'),
                "description"  => esc_attr__("Enter the description of column1", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "First item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_text1",
                "heading"      => esc_attr__("Button text of column1", 'modeltheme'),
                "description"  => esc_attr__("Enter button text of column1", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "First item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_link1",
                "heading"      => esc_attr__("Button link of column1", 'modeltheme'),
                "description"  => esc_attr__("Enter button link of column1", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "First item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "tabs_item_img1",
                "value" => "",
                "description" => esc_attr__( "Choose image for first category", 'modeltheme' )
            ),
            /* CAT 2 */
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose icon", 'modeltheme' ),
                "param_name" => "tabs_item_icon2",
                "value" => "",
                "description" => esc_attr__( "Choose icon for first category", 'modeltheme' )
            ),
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_title_tab2",
                "heading"      => esc_attr__("Title of column2", 'modeltheme'),
                "description"  => esc_attr__("Enter title of column2", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type"         => "textarea",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_content2",
                "heading"      => esc_attr__("Description of column2", 'modeltheme'),
                "description"  => esc_attr__("Enter the description of column2", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_text2",
                "heading"      => esc_attr__("Button text of column2", 'modeltheme'),
                "description"  => esc_attr__("Enter button text of column2", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_link2",
                "heading"      => esc_attr__("Button link of column2", 'modeltheme'),
                "description"  => esc_attr__("Enter button link of column2", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Second item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "tabs_item_img2",
                "value" => "",
                "description" => esc_attr__( "Choose image for first category", 'modeltheme' )
            ),
            /* CAT 3 */
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose icon", 'modeltheme' ),
                "param_name" => "tabs_item_icon3",
                "value" => "",
                "description" => esc_attr__( "Choose icon for first category", 'modeltheme' )
            ),
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_title_tab3",
                "heading"      => esc_attr__("Title of column3", 'modeltheme'),
                "description"  => esc_attr__("Enter title of column3", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type"         => "textarea",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_content3",
                "heading"      => esc_attr__("Description of column3", 'modeltheme'),
                "description"  => esc_attr__("Enter the description of column3", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_text3",
                "heading"      => esc_attr__("Button text of column3", 'modeltheme'),
                "description"  => esc_attr__("Enter button text of column3", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_link3",
                "heading"      => esc_attr__("Button link of column3", 'modeltheme'),
                "description"  => esc_attr__("Enter button link of column3", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Third item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "tabs_item_img3",
                "value" => "",
                "description" => esc_attr__( "Choose image for first category", 'modeltheme' )
            ),
            /* CAT 4 */
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose icon", 'modeltheme' ),
                "param_name" => "tabs_item_icon4",
                "value" => "",
                "description" => esc_attr__( "Choose Fourth for first category", 'modeltheme' )
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_title_tab4",
                "heading"      => esc_attr__("Title of column4", 'modeltheme'),
                "description"  => esc_attr__("Enter title of column4", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textarea",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_content4",
                "heading"      => esc_attr__("Description of column4", 'modeltheme'),
                "description"  => esc_attr__("Enter the description of column4", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_text4",
                "heading"      => esc_attr__("Button text of column4", 'modeltheme'),
                "description"  => esc_attr__("Enter button text of column4", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_link4",
                "heading"      => esc_attr__("Button link of column4", 'modeltheme'),
                "description"  => esc_attr__("Enter button link of column4", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "tabs_item_img4",
                "value" => "",
                "description" => esc_attr__( "Choose image for first category", 'modeltheme' )
            ),
            /* CAT 5 */
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose icon", 'modeltheme' ),
                "param_name" => "tabs_item_icon5",
                "value" => "",
                "description" => esc_attr__( "Choose icon for Fifth category", 'modeltheme' )
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_title_tab5",
                "heading"      => esc_attr__("Title of column5", 'modeltheme'),
                "description"  => esc_attr__("Enter title of column5", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textarea",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_content5",
                "heading"      => esc_attr__("Description of column5", 'modeltheme'),
                "description"  => esc_attr__("Enter the description of column5", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_text5",
                "heading"      => esc_attr__("Button text of column5", 'modeltheme'),
                "description"  => esc_attr__("Enter button text of column5", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type"         => "textfield",
                "holder"       => "div",
                "class"        => "",
                "param_name"   => "tabs_item_button_link5",
                "heading"      => esc_attr__("Button link of column5", 'modeltheme'),
                "description"  => esc_attr__("Enter button link of column5", 'modeltheme'),
            ),
            array(
                "group"        => esc_attr__( "Fourth item", 'modeltheme' ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "tabs_item_img5",
                "value" => "",
                "description" => esc_attr__( "Choose image for first category", 'modeltheme' )
            ),
          ),
        ));
     

    /**
    ||-> Map Shortcode in Visual Composer with: vc_map();
    */
        vc_map( array(
            "name" => esc_attr__("Members Slider", 'modeltheme'),
            "base" => "mt_members_slider",
            "category" => esc_attr__('pomana Theme', 'modeltheme'),
            "icon" => plugins_url( 'images/members-slider.svg', __FILE__ ),
            "params" => array(
                array(
                    "group"        => esc_attr__( "Slider Options", 'modeltheme' ),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_attr__( "Number of members", 'modeltheme' ),
                    "param_name" => "number",
                    "value" => "",
                    "description" => esc_attr__( "Enter number of members to show.", 'modeltheme' )
                ),
                array(
                    "group"        => esc_attr__( "Animation", 'modeltheme' ),
                    "type" => "dropdown",
                    "heading" => esc_attr__("Animation", 'modeltheme'),
                    "param_name" => "animation",
                    "std" => '',
                    "holder" => "div",
                    "class" => "",
                    "value" => $animations_list
                ),
            )
        ));
    }


    vc_map( array(
         "name" => esc_attr__("Clients (Slider)", 'modeltheme'),
         "base" => "clients01",
         "category" => esc_attr__('pomana Theme', 'modeltheme'),
          "icon" => plugins_url( 'images/clients.svg', __FILE__ ),
         "params" => array(
             array(
                "group"        => esc_attr__( "Options", 'modeltheme' ),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Number of clients", 'modeltheme' ),
                "param_name" => "number",
                "value" => "",
                "description" => esc_attr__( "Enter number of clients to show.", 'modeltheme' )
             ),
             array(
              "group"        => esc_attr__( "Options", 'modeltheme' ),
              "type" => "dropdown",
              "heading" => esc_attr__("Visible Clients per slide", 'modeltheme'),
              "param_name" => "visible_items_clients",
              "std" => '',
              "holder" => "div",
              "class" => "",
              "description" => "",
              "value" => array(
                '1'   => '1',
                '2'   => '2',
                '3'   => '3',
                '4'   => '4',
                '5'   => '5'
                )
            ),
             array(
              "group"        => esc_attr__( "Options", 'modeltheme' ),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Clients order", 'modeltheme' ),
                "param_name" => "order",
                "value" => "DESC",
                "description" => esc_attr__( "Ascendente or descendente", 'modeltheme' )
             ),
            array(
              "group"        => esc_attr__( "Options", 'modeltheme' ),
              "type" => "colorpicker",
              "class" => "",
              "heading" => esc_attr__( "Logo Background Overlay", 'modeltheme' ),
              "param_name" => "background_color_overlay",
              "value" => "", //Default color
              "description" => esc_attr__( "Client Logo Background Overlay", 'modeltheme' )
            ),
         )
    ));

    vc_map( array(
        "name" => esc_attr__("Pricing Tables (With Switcher)", 'modeltheme'),
        "base" => "mt_pricing_table_short_v4",
        "as_parent" => array('only' => 'mt_pricing_table_short_v4_item'), 
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
        "category" => esc_attr__('pomana Theme', 'modeltheme'),
        "is_container" => true,
        "params" => array(
            // add params same as with any other content element
            array(
               "group" => "Options",
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Switch status"),
               "param_name" => "switch_status",
               "std" => '',
               "description" => esc_attr__(""),
               "value" => array(
                    'Enable'           => 'on',
                    'Disable'          => 'off'
               )
            ),    
        ),
        "js_view" => 'VcColumnView'
    ) );
    vc_map( array(
      "name" => esc_attr__("Pricing Table List Item", 'modeltheme'),
      "base" => "mt_pricing_table_short_v4_item",
      "icon" => plugins_url( 'images/pricing-table.svg', __FILE__ ),
      "content_element" => true,
      "as_child" => array('only' => 'mt_pricing_table_short_v4'), // Use only|except attributes to limit parent (separate multiple values with comma)
      "params" => array(
       array(
           "group" => "Image Setup",
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Icon"),
           "param_name" => "svg_or_image",
           "std" => '',
           "description" => esc_attr__("Choose what you want to use: empty/image/svg"),
           "value" => array(
          'Nothing'     => 'choosed_nothing',
          'Use an image'     => 'choosed_image',
          'Use an svg'      => 'choosed_svg'
            )
        ),
       array(
               "group" => "Image Setup",
               "dependency" => array(
                   'element' => 'svg_or_image',
                   'value' => array( 'choosed_svg' ),
                   ),
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("SVG color", 'modeltheme'),
               "param_name" => "svg_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
        array(
           "group" => "Image Setup",
          "dependency" => array(
           'element' => 'svg_or_image',
           'value' => array( 'choosed_svg' ),
           ),
           "type" => "textarea_raw_html",
           "class" => "",
           "heading" => esc_attr__("SVG Path", 'modeltheme'),
           "description" => "Only add the path strokes of the SVG, without the svg tag",
           "param_name" => "package_svg",
           "value" => "",  
        ),
        array(
          "group" => "Image Setup",
          "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Loop animation", 'modeltheme'),
           "param_name" => "animated_svg_loop",
           "std" => '',
           "default" => 'delayed',
           "value" => array(
              esc_attr__('delayed', 'modeltheme')  => 'delayed',
              esc_attr__('async', 'modeltheme')    => 'async'           
            ),
        ),
        array(
          "group" => "Image Setup",
           "type" => "dropdown",
           "holder" => "div",
           "class" => "",
           "heading" => esc_attr__("Loop start", 'modeltheme'),
           "param_name" => "start_svg_loop",
           "std" => '',
           "default" => 'autostart',
           "value" => array(
              esc_attr__('autostart', 'modeltheme')  => 'autostart',
              esc_attr__('manual', 'modeltheme')    => 'manual'           
            )
          ),
            array(
              "group" => "Image Setup",
              "dependency" => array(
               'element' => 'svg_or_image',
               'value' => array( 'choosed_image' ),
               ),
              "type" => "attach_images",
              "holder" => "div",
              "class" => "",
              "heading" => esc_attr__( "Choose image", 'modeltheme' ),
              "param_name" => "package_image",
              "value" => "",
              "description" => esc_attr__( "Choose image for pricing table", 'modeltheme' )
            ),
            array(
               "group" => "Image Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Custom class", 'modeltheme'),
               "param_name" => "custom_class",
               "std" => '',
               
              ),
          array(
               "group" => "Options",
               "type" => "dropdown",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Number of columns"),
               "param_name" => "number_columns",
               "std" => '',
               "description" => esc_attr__(""),
               "value" => array(
                    '2'          => 'col-md-6',
                    '3'          => 'col-md-4',
                    '4'          => 'col-md-3'
               )
            ),  
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package title", 'modeltheme'),
               "param_name" => "package_title",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price per month", 'modeltheme'),
               "param_name" => "package_price_per_month",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price per year", 'modeltheme'),
               "param_name" => "package_price_per_year",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package price currency", 'modeltheme'),
               "param_name" => "package_price_currency",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package button url", 'modeltheme'),
               "param_name" => "button_url",
               "value" => "",
               "description" => ""
            ),
            array(
               "group" => "Box Setup",
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Package button text", 'modeltheme'),
               "param_name" => "button_text",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Box background color", 'modeltheme'),
               "param_name" => "box_background_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Button background color", 'modeltheme'),
               "param_name" => "button_background_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
              "group" => "Options",
              "type" => "textarea_html",
              "holder" => "div",
              "class" => "",
              "heading" => esc_attr__("Content pricing table", 'modeltheme'),
              "param_name" => "content_pricing_table",
              "value" => esc_attr__("", 'modeltheme'),
              "description" => "Create lists for pricing table with li tag"
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Content color of the header", 'modeltheme'),
               "param_name" => "header_button_content_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
               "group" => "Styling",
               "type" => "colorpicker",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Content color of list", 'modeltheme'),
               "param_name" => "content_color",
               "value" => esc_attr__("", 'modeltheme'),
               "description" => ""
            ),
            array(
              "group" => "Animation",
              "type" => "dropdown",
              "heading" => esc_attr__("Animation", 'modeltheme'),
              "param_name" => "animation",
              "std" => '',
              "holder" => "div",
              "class" => "",
              "description" => ""
            )
        )
    ) );
    //Your "container" content element should extend WPBakeryShortCodesContainer class to inherit all required functionality
    if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
        class WPBakeryShortCode_mt_pricing_table_short_v4 extends WPBakeryShortCodesContainer {
        }
    }
    if ( class_exists( 'WPBakeryShortCode' ) ) {
        class WPBakeryShortCode_mt_pricing_table_short_v4_item extends WPBakeryShortCode {
        }
    }

    #SHORTCODE: Skill counter shortcode
    vc_map( array(
        "name" => __("SVG Blob", 'modeltheme'),
        "base" => "svg-blob",
        "category" => esc_attr__('pomana Theme', 'modeltheme'),
        "icon" => plugins_url( 'images/skill-counter.svg', __FILE__ ),
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__("Background Type", 'modeltheme'),
                "param_name" => "icon_or_image",
                "std" => '',
                "description" => esc_attr__("Choose what you want to use: image/color", 'modeltheme'),
                "value" => array(
                    'Nothing'          => 'choosed_nothing',
                    'Use an image'     => 'choosed_image',
                    'Use a color'      => 'choosed_icon'
                )
            ),
            array(
                "dependency" => array(
                    'element' => 'icon_or_image',
                    'value' => array( 'choosed_icon' ),
                ),
                "heading" => esc_attr__("Background color", 'modeltheme'),
                "type" => "colorpicker",
                "param_name" => "back_color",
                "holder" => "div",
                "class" => "",
                "value" => ''
            ),
            array(
                "dependency" => array(
                    'element' => 'icon_or_image',
                    'value' => array( 'choosed_image' ),
                ),
                "type" => "attach_images",
                "holder" => "div",
                "class" => "",
                "heading" => esc_attr__( "Choose image", 'modeltheme' ),
                "param_name" => "image_skill",
                "value" => "",
                "description" => esc_attr__( "Choose background image", 'modeltheme' )
            ),
            array(
               "type" => "textfield",
               "class" => "",
               "heading" => esc_attr__("Clip Path", 'modeltheme'),
               "param_name" => "clip_path",
               "description" => esc_attr__("Create the blob shape at https://10015.io/tools/svg-blob-generator")
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Blob Width", 'modeltheme'),
               "param_name" => "blob_width",
               "value" => "100%",
               "description" => esc_attr__("Set with by px or %.")
            ),
            array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => esc_attr__("Extra Class", 'modeltheme'),
               "param_name" => "extra_class"
            )
         )
      ));