<?php
/**
 * Contains List of countries to be shown in dropdown.
 * Contains functions for getting country list for dropdown and whatsapp pricing
 *
 * @package miniorange-validaition-settings
 */

namespace OTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use OTP\Traits\Instance;

/**
 * This class lists down all the countries and their country code.
 * It also lists down a few country code related functions.
 */
if ( ! class_exists( 'TransactionCost' ) ) {
	/**
	 * CountryList class
	 */
	class TransactionCost {

		use Instance;
		/**Constructor
		 **/
		protected function __construct() {
			$sms_pricing = array(
				'Algeria'                      => array(
					'100 '   => '9',
					'500 '   => '40',
					'1000 '  => '77',
					'5000 '  => '370',
					'10000 ' => '730',
					'50000 ' => '3545',
				),
				'All Countries'                => array(
					'100 '   => '20',
					'500 '   => '95',
					'1000 '  => '179',
					'5000 '  => '867',
					'10000 ' => '1683',
					'50000 ' => '7665',
				),
				'Angola'                       => array(
					'100 '   => '6',
					'500 '   => '24',
					'1000 '  => '47',
					'5000 '  => '218',
					'10000 ' => '425',
					'50000 ' => '2020',
				),
				'Argentina'                    => array(
					'100 '   => '7',
					'500 '   => '35',
					'1000 '  => '66',
					'5000 '  => '319',
					'10000 ' => '632',
					'50000 ' => '3105',
				),
				'Australia'                    => array(
					'100 '   => '11',
					'500 '   => '50',
					'1000 '  => '89',
					'5000 '  => '420',
					'10000 ' => '790',
					'50000 ' => '3200',
				),
				'Austria'                      => array(
					'100 '   => '18',
					'500 '   => '85',
					'1000 '  => '167',
					'5000 '  => '820',
					'10000 ' => '1630',
					'50000 ' => '8045',
				),
				'Azerbaijan'                   => array(
					'100 '   => '18',
					'500 '   => '86',
					'1000 '  => '170',
					'5000 '  => '833',
					'10000 ' => '1656',
					'50000 ' => '8175',
				),
				'Bahrain'                      => array(
					'100 '   => '4',
					'500 '   => '13',
					'1000 '  => '22',
					'5000 '  => '96',
					'10000 ' => '181',
					'50000 ' => '800',
				),
				'Bangladesh'                   => array(
					'100 '   => '14',
					'500 '   => '65',
					'1000 '  => '127',
					'5000 '  => '618$',
					'10000 ' => '1226$',
					'50000 ' => '6025$',
				),
				'Belarus'                      => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '55',
					'5000 '  => '262',
					'10000 ' => '513',
					'50000 ' => '2460',
				),
				'Beligum'                      => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '99',
					'5000 '  => '478',
					'10000 ' => '945',
					'50000 ' => '4620',
				),
				'Belize'                       => array(
					'100 '   => '5',
					'500 '   => '19',
					'1000 '  => '35',
					'5000 '  => '160',
					'10000 ' => '310',
					'50000 ' => '1445',
				),
				'Benin'                        => array(
					'100 '   => '14',
					'500 '   => '64',
					'1000 '  => '125',
					'5000 '  => '610',
					'10000 ' => '1210',
					'50000 ' => '5945',
				),
				'Bhutan'                       => array(
					'100 '   => '6',
					'500 '   => '23',
					'1000 '  => '43',
					'5000 '  => '199',
					'10000 ' => '387',
					'50000 ' => '1830',
				),
				'Brazil'                       => array(
					'100 '   => '8',
					'500 '   => '33',
					'1000 '  => '63',
					'5000 '  => '300',
					'10000 ' => '590',
					'50000 ' => '2845',
				),
				'Brunei'                       => array(
					'100 '   => '4',
					'500 '   => '15',
					'1000 '  => '29',
					'5000 '  => '128',
					'10000 ' => '246',
					'50000 ' => '1125',
				),
				'Bulgaria'                     => array(
					'100 '   => '11',
					'500 '   => '49',
					'1000 '  => '94',
					'5000 '  => '457',
					'10000 ' => '903',
					'50000 ' => '4410',
				),
				'BurkinaFaso'                  => array(
					'100 '   => '7',
					'500 '   => '32',
					'1000 '  => '61',
					'5000 '  => '288',
					'10000 ' => '566',
					'50000 ' => '2725',
				),
				'Cambodia'                     => array(
					'100 '   => '9',
					'500 '   => '42',
					'1000 '  => '80',
					'5000 '  => '385',
					'10000 ' => '760',
					'50000 ' => '3695',
				),
				'Cameroon'                     => array(
					'100 '   => '4',
					'500 '   => '15',
					'1000 '  => '27',
					'5000 '  => '122',
					'10000 ' => '233',
					'50000 ' => '1060',
				),
				'Canada'                       => array(
					'100 '   => '4',
					'500 '   => '13',
					'1000 '  => '22',
					'5000 '  => '95',
					'10000 ' => '180',
					'50000 ' => '795',
				),
				'Chile'                        => array(
					'100 '   => '9',
					'500 '   => '38',
					'1000 '  => '73',
					'5000 '  => '350',
					'10000 ' => '690',
					'50000 ' => '3345',
				),
				'China'                        => array(
					'100 '   => '6',
					'500 '   => '26',
					'1000 '  => '50',
					'5000 '  => '235',
					'10000 ' => '460',
					'50000 ' => '2195',
				),
				'Colombia'                     => array(
					'100 '   => '7',
					'500 '   => '30',
					'1000 '  => '58',
					'5000 '  => '274',
					'10000 ' => '538',
					'50000 ' => '2585',
				),
				'Congo'                        => array(
					'100 '   => '11',
					'500 '   => '54',
					'1000 '  => '104',
					'5000 '  => '510',
					'10000 ' => '1015',
					'50000 ' => '5020',
				),
				'CostaRica'                    => array(
					'100 '   => '4',
					'500 '   => '20',
					'1000 '  => '37',
					'5000 '  => '170',
					'10000 ' => '330',
					'50000 ' => '1545',
				),
				'CôtedIvoire'                  => array(
					'100 '   => '7',
					'500 '   => '30',
					'1000 '  => '57',
					'5000 '  => '270',
					'10000 ' => '530',
					'50000 ' => '2545',
				),
				'Croatia'                      => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '56',
					'5000 '  => '265',
					'10000 ' => '519',
					'50000 ' => '2490',
				),
				'Cuba'                         => array(
					'100 '   => '10',
					'500 '   => '45',
					'1000 '  => '87',
					'5000 '  => '418',
					'10000 ' => '820',
					'50000 ' => '4020',
				),
				'Cyprus'                       => array(
					'100 '   => '6',
					'500 '   => '24',
					'1000 '  => '45',
					'5000 '  => '210',
					'10000 ' => '410',
					'50000 ' => '1945',
				),
				'CzenchRepublic'               => array(
					'100 '   => '3',
					'500 '   => '10',
					'1000 '  => '17',
					'5000 '  => '70',
					'10000 ' => '130',
					'50000 ' => '545$',
				),
				'Denmark'                      => array(
					'100 '   => '4',
					'500 '   => '15',
					'1000 '  => '27',
					'5000 '  => '120',
					'10000 ' => '230',
					'50000 ' => '1045',
				),
				'DominicanRepublic'            => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '216',
					'10000 ' => '421',
					'50000 ' => '2000',
				),
				'Euator'                       => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '65',
					'5000 '  => '312',
					'10000 ' => '614',
					'50000 ' => '2965',
				),
				'Egypt'                        => array(
					'100 '   => '11',
					'500 '   => '49',
					'1000 '  => '96',
					'5000 '  => '464',
					'10000 ' => '917',
					'50000 ' => '4480',
				),
				'Estonia'                      => array(
					'100 '   => '7',
					'500 '   => '31',
					'1000 '  => '59',
					'5000 '  => '279',
					'10000 ' => '548',
					'50000 ' => '2635',
				),
				'Ethiopia'                     => array(
					'100 '   => '9',
					'500 '   => '41',
					'1000 '  => '79',
					'5000 '  => '378',
					'10000 ' => '745',
					'50000 ' => '3620',
				),
				'Finland'                      => array(
					'100 '   => '9',
					'500 '   => '39',
					'1000 '  => '76',
					'5000 '  => '365',
					'10000 ' => '720',
					'50000 ' => '3495',
				),
				'France'                       => array(
					'100 '   => '10',
					'500 '   => '42',
					'1000 '  => '82',
					'5000 '  => '395',
					'10000 ' => '780',
					'50000 ' => '3795$',
				),
				'Georgia'                      => array(
					'100 '   => '3',
					'500 '   => '12',
					'1000 '  => '20',
					'5000 '  => '86',
					'10000 ' => '162',
					'50000 ' => '705',
				),
				'Germany'                      => array(
					'100 '   => '12',
					'500 '   => '54',
					'1000 '  => '105',
					'5000 '  => '510',
					'10000 ' => '1010',
					'50000 ' => '4945',
				),
				'Ghana'                        => array(
					'100 '   => '6',
					'500 '   => '26',
					'1000 '  => '50',
					'5000 '  => '236',
					'10000 ' => '461',
					'50000 ' => '2200',
				),
				'Greece'                       => array(
					'100 '   => '10',
					'500 '   => '42',
					'1000 '  => '82',
					'5000 '  => '395',
					'10000 ' => '780',
					'50000 ' => '3795',
				),
				'Honduras'                     => array(
					'100 '   => '6',
					'500 '   => '23',
					'1000 '  => '44',
					'5000 '  => '203',
					'10000 ' => '395',
					'50000 ' => '1870',
				),
				'HongKong'                     => array(
					'100 '   => '6',
					'500 '   => '26',
					'1000 '  => '50',
					'5000 '  => '235',
					'10000 ' => '460',
					'50000 ' => '2195',
				),
				'Hungary'                      => array(
					'100 '   => '12',
					'500 '   => '53',
					'1000 '  => '103',
					'5000 '  => '500',
					'10000 ' => '990',
					'50000 ' => '4845',
				),
				'Iceland'                      => array(
					'100 '   => '4',
					'500 '   => '16',
					'1000 '  => '29',
					'5000 '  => '130',
					'10000 ' => '250',
					'50000 ' => '1145$',
				),
				'India'                        => array(
					'100 '   => '1',
					'500 '   => '5',
					'1000 '  => '7',
					'5000 '  => '27',
					'10000 ' => '48',
					'50000 ' => '185',
				),
				'Indonesia'                    => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '56',
					'5000 '  => '265',
					'10000 ' => '520',
					'50000 ' => '2495',
				),
				'Iraq'                         => array(
					'100 '   => '13',
					'500 '   => '59',
					'1000 '  => '115',
					'5000 '  => '560',
					'10000 ' => '1110',
					'50000 ' => '5445',
				),
				'Ireland'                      => array(
					'100 '   => '9',
					'500 '   => '40',
					'1000 '  => '77',
					'5000 '  => '370',
					'10000 ' => '730',
					'50000 ' => '3545',
				),
				'Israel'                       => array(
					'100 '   => '9',
					'500 '   => '38',
					'1000 '  => '75',
					'5000 '  => '359',
					'10000 ' => '708',
					'50000 ' => '3440',
				),
				'Italy'                        => array(
					'100 '   => '9',
					'500 '   => '41',
					'1000 '  => '80',
					'5000 '  => '385',
					'10000 ' => '760',
					'50000 ' => '3695',
				),
				'Jamaica'                      => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '63',
					'5000 '  => '300',
					'10000 ' => '590',
					'50000 ' => '2845',
				),
				'Japan'                        => array(
					'100 '   => '11',
					'500 '   => '50',
					'1000 '  => '97',
					'5000 '  => '470',
					'10000 ' => '930',
					'50000 ' => '4545',
				),
				'Jordan'                       => array(
					'100 '   => '15',
					'500 '   => '70',
					'1000 '  => '138',
					'5000 '  => '676',
					'10000 ' => '1342',
					'50000 ' => '6605',
				),
				'Kazakhstan'                   => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '215',
					'10000 ' => '420',
					'50000 ' => '1995',
				),
				'Kenya'                        => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '215',
					'10000 ' => '420',
					'50000 ' => '1995',
				),
				'Kosovo'                       => array(
					'100 '   => '6',
					'500 '   => '27',
					'1000 '  => '50',
					'5000 '  => '237',
					'10000 ' => '464',
					'50000 ' => '2215',
				),
				'Kuwait'                       => array(
					'100 '   => '9',
					'500 '   => '39',
					'1000 '  => '74',
					'5000 '  => '356',
					'10000 ' => '701',
					'50000 ' => '3400',
				),
				'Latvia'                       => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '99',
					'5000 '  => '481',
					'10000 ' => '951',
					'50000 ' => '4650',
				),
				'Lebanon'                      => array(
					'100 '   => '7',
					'500 '   => '27',
					'1000 '  => '52',
					'5000 '  => '245',
					'10000 ' => '480',
					'50000 ' => '2295',
				),
				'Liberia'                      => array(
					'100 '   => '10',
					'500 '   => '45',
					'1000 '  => '86',
					'5000 '  => '415',
					'10000 ' => '820',
					'50000 ' => '3995',
				),
				'Libya'                        => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '100',
					'5000 '  => '483',
					'10000 ' => '955',
					'50000 ' => '4670',
				),
				'Lithuania'                    => array(
					'100 '   => '4',
					'500 '   => '15',
					'1000 '  => '27',
					'5000 '  => '120',
					'10000 ' => '230',
					'50000 ' => '1045',
				),
				'Macau'                        => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '215',
					'10000 ' => '420',
					'50000 ' => '1995',
				),
				'Macedonia'                    => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '66',
					'5000 '  => '313',
					'10000 ' => '616',
					'50000 ' => '2975',
				),
				'Malaysia'                     => array(
					'100 '   => '7',
					'500 '   => '32',
					'1000 '  => '62',
					'5000 '  => '295',
					'10000 ' => '579',
					'50000 ' => '2835',
				),
				'Maldives'                     => array(
					'100 '   => '4',
					'500 '   => '16',
					'1000 '  => '30',
					'5000 '  => '136',
					'10000 ' => '262',
					'50000 ' => '1205',
				),
				'Mali'                         => array(
					'100 '   => '13',
					'500 '   => '60',
					'1000 '  => '117',
					'5000 '  => '570',
					'10000 ' => '1130',
					'50000 ' => '5545',
				),
				'Mauritania'                   => array(
					'100 '   => '11',
					'500 '   => '49',
					'1000 '  => '94',
					'5000 '  => '456',
					'10000 ' => '902',
					'50000 ' => '4405',
				),
				'Mauritius'                    => array(
					'100 '   => '5',
					'500 '   => '20',
					'1000 '  => '37',
					'5000 '  => '170',
					'10000 ' => '330',
					'50000 ' => '1545',
				),
				'Mexico'                       => array(
					'100 '   => '7',
					'500 '   => '31',
					'1000 '  => '60',
					'5000 '  => '284',
					'10000 ' => '557',
					'50000 ' => '2680',
				),
				'Moldova'                      => array(
					'100 '   => '7',
					'500 '   => '28',
					'1000 '  => '54',
					'5000 '  => '256',
					'10000 ' => '501',
					'50000 ' => '2400',
				),
				'Mongolia'                     => array(
					'100 '   => '9',
					'500 '   => '40',
					'1000 '  => '78',
					'5000 '  => '374',
					'10000 ' => '737',
					'50000 ' => '3580',
				),
				'Morocco'                      => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '55',
					'5000 '  => '260',
					'10000 ' => '510',
					'50000 ' => '2445',
				),
				'Mozambique'                   => array(
					'100 '   => '10',
					'500 '   => '46',
					'1000 '  => '88',
					'5000 '  => '427',
					'10000 ' => '844',
					'50000 ' => '4115',
				),
				'Myanmar'                      => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '99',
					'5000 '  => '478',
					'10000 ' => '945',
					'50000 ' => '4620',
				),
				'Namibia'                      => array(
					'100 '   => '3',
					'500 '   => '9',
					'1000 '  => '16',
					'5000 '  => '67',
					'10000 ' => '123',
					'50000 ' => '510',
				),
				'Nepal'                        => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '47',
					'5000 '  => '220',
					'10000 ' => '430',
					'50000 ' => '2045',
				),
				'Netherlands'                  => array(
					'100 '   => '10',
					'500 '   => '46',
					'1000 '  => '89',
					'5000 '  => '430',
					'10000 ' => '850',
					'50000 ' => '4145',
				),
				'Newzealand'                   => array(
					'100 '   => '8',
					'500 '   => '35',
					'1000 '  => '67',
					'5000 '  => '320',
					'10000 ' => '630',
					'50000 ' => '3045',
				),
				'Nigeria'                      => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '99',
					'5000 '  => '480',
					'10000 ' => '950',
					'50000 ' => '4645',
				),
				'Norway'                       => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '215',
					'10000 ' => '420',
					'50000 ' => '1995',
				),
				'OccupiedPalestinianTerritory' => array(
					'100 '   => '14',
					'500 '   => '66',
					'1000 '  => '129',
					'5000 '  => '632',
					'10000 ' => '1253',
					'50000 ' => '6160',
				),
				'Oman'                         => array(
					'100 '   => '10',
					'500 '   => '43',
					'1000 '  => '83',
					'5000 '  => '398',
					'10000 ' => '786',
					'50000 ' => '3825',
				),
				'Pakistan'                     => array(
					'100 '   => '22',
					'500 '   => '105',
					'1000 '  => '207',
					'5000 '  => '1020',
					'10000 ' => '2030',
					'50000 ' => '10045',
				),
				'Panama'                       => array(
					'100 '   => '10',
					'500 '   => '40',
					'1000 '  => '72',
					'5000 '  => '280',
					'10000 ' => '540',
					'50000 ' => '2590',
				),
				'Peru'                         => array(
					'100 '   => '4',
					'500 '   => '16',
					'1000 '  => '29',
					'5000 '  => '130',
					'10000 ' => '249',
					'50000 ' => '1140',
				),
				'Philippines'                  => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '215',
					'10000 ' => '420',
					'50000 ' => '1995',
				),
				'Poland'                       => array(
					'100 '   => '6',
					'500 '   => '30',
					'1000 '  => '57',
					'5000 '  => '270',
					'10000 ' => '530',
					'50000 ' => '2545',
				),
				'Portugal'                     => array(
					'100 '   => '5',
					'500 '   => '21',
					'1000 '  => '39',
					'5000 '  => '179',
					'10000 ' => '348',
					'50000 ' => '1635',
				),
				'PuertoRico'                   => array(
					'100 '   => '3',
					'500 '   => '11',
					'1000 '  => '19',
					'5000 '  => '78',
					'10000 ' => '146',
					'50000 ' => '625',
				),
				'Quatar'                       => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '66',
					'5000 '  => '313',
					'10000 ' => '616',
					'50000 ' => '2975',
				),
				'RepublicofKorea'              => array(
					'100 '   => '3',
					'500 '   => '32',
					'1000 '  => '61',
					'5000 '  => '292',
					'10000 ' => '574',
					'50000 ' => '2765',
				),
				'Romania'                      => array(
					'100 '   => '7',
					'500 '   => '27',
					'1000 '  => '52',
					'5000 '  => '245',
					'10000 ' => '480',
					'50000 ' => '2295',
				),
				'Russia'                       => array(
					'100 '   => '7',
					'500 '   => '31',
					'1000 '  => '59',
					'5000 '  => '280',
					'10000 ' => '550',
					'50000 ' => '2645',
				),
				'Rwanda'                       => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '54',
					'5000 '  => '256',
					'10000 ' => '501',
					'50000 ' => '2400',
				),
				'SaudiArabia'                  => array(
					'100 '   => '7',
					'500 '   => '31',
					'1000 '  => '60',
					'5000 '  => '283',
					'10000 ' => '555',
					'50000 ' => '2670',
				),
				'Senegal'                      => array(
					'100 '   => '19',
					'500 '   => '89',
					'1000 '  => '174',
					'5000 '  => '857',
					'10000 ' => '1703',
					'50000 ' => '8410',
				),
				'Serbia'                       => array(
					'100 '   => '4',
					'500 '   => '16',
					'1000 '  => '28',
					'5000 '  => '126',
					'10000 ' => '241',
					'50000 ' => '1100',
				),
				'Singapore'                    => array(
					'100 '   => '7',
					'500 '   => '30',
					'1000 '  => '57',
					'5000 '  => '270',
					'10000 ' => '530',
					'50000 ' => '2545',
				),
				'Solvakia'                     => array(
					'100 '   => '8',
					'500 '   => '33',
					'1000 '  => '63',
					'5000 '  => '300',
					'10000 ' => '590',
					'50000 ' => '2845',
				),
				'Slovenia'                     => array(
					'100 '   => '5',
					'500 '   => '20',
					'1000 '  => '37',
					'5000 '  => '170',
					'10000 ' => '330',
					'50000 ' => '1545',
				),
				'Somalia'                      => array(
					'100 '   => '8',
					'500 '   => '33',
					'1000 '  => '62',
					'5000 '  => '295',
					'10000 ' => '580',
					'50000 ' => '2795',
				),
				'SouthAfrica'                  => array(
					'100 '   => '4',
					'500 '   => '14',
					'1000 '  => '26',
					'5000 '  => '115',
					'10000 ' => '220',
					'50000 ' => '995',
				),
				'SouthKorea'                   => array(
					'100 '   => '4',
					'500 '   => '16',
					'1000 '  => '28',
					'5000 '  => '125',
					'10000 ' => '240',
					'50000 ' => '1095',
				),
				'Spain'                        => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '65',
					'5000 '  => '312',
					'10000 ' => '614',
					'50000 ' => '2965',
				),
				'SriLanka'                     => array(
					'100 '   => '6',
					'500 '   => '27',
					'1000 '  => '51',
					'5000 '  => '240',
					'10000 ' => '470',
					'50000 ' => '2245',
				),
				'Sudan'                        => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '65',
					'5000 '  => '311',
					'10000 ' => '611',
					'50000 ' => '2950',
				),
				'Sweden'                       => array(
					'100 '   => '8',
					'500 '   => '33',
					'1000 '  => '63',
					'5000 '  => '300',
					'10000 ' => '590',
					'50000 ' => '2845',
				),
				'Switzerland'                  => array(
					'100 '   => '8',
					'500 '   => '35',
					'1000 '  => '67',
					'5000 '  => '320',
					'10000 ' => '630',
					'50000 ' => '3045',
				),
				'Syria'                        => array(
					'100 '   => '17',
					'500 '   => '79',
					'1000 '  => '154',
					'5000 '  => '757',
					'10000 ' => '1503',
					'50000 ' => '7410',
				),
				'Taiwan'                       => array(
					'100 '   => '7',
					'500 '   => '30',
					'1000 '  => '57',
					'5000 '  => '270',
					'10000 ' => '530',
					'50000 ' => '2545',
				),
				'Tuzania'                      => array(
					'100 '   => '11',
					'500 '   => '51',
					'1000 '  => '100',
					'5000 '  => '485',
					'10000 ' => '959',
					'50000 ' => '4690',
				),
				'Thailand'                     => array(
					'100 '   => '5',
					'500 '   => '20',
					'1000 '  => '37',
					'5000 '  => '170',
					'10000 ' => '330',
					'50000 ' => '1545',
				),
				'TrinidadandTobago'            => array(
					'100 '   => '6',
					'500 '   => '22',
					'1000 '  => '42',
					'5000 '  => '197',
					'10000 ' => '384',
					'50000 ' => '1815',
				),
				'Tunisia'                      => array(
					'100 '   => '13',
					'500 '   => '61',
					'1000 '  => '119',
					'5000 '  => '579',
					'10000 ' => '1147',
					'50000 ' => '5630',
				),
				'Turkey'                       => array(
					'100 '   => '5',
					'500 '   => '21',
					'1000 '  => '39',
					'5000 '  => '178',
					'10000 ' => '346',
					'50000 ' => '1625',
				),
				'Uganda'                       => array(
					'100 '   => '10',
					'500 '   => '46',
					'1000 '  => '89',
					'5000 '  => '431',
					'10000 ' => '852',
					'50000 ' => '4155',
				),
				'Ukraine'                      => array(
					'100 '   => '9',
					'500 '   => '38',
					'1000 '  => '74',
					'5000 '  => '354',
					'10000 ' => '697',
					'50000 ' => '3380',
				),
				'United Arab Emirates'         => array(
					'100 '   => '5',
					'500 '   => '22',
					'1000 '  => '42',
					'5000 '  => '193',
					'10000 ' => '375',
					'50000 ' => '1770',
				),
				'United Kingdom'               => array(
					'100 '   => '6',
					'500 '   => '25',
					'1000 '  => '46',
					'5000 '  => '217',
					'10000 ' => '424',
					'50000 ' => '2015',
				),
				'United State'                 => array(
					'100 '   => '8',
					'500 '   => '35',
					'1000 '  => '59',
					'5000 '  => '270',
					'10000 ' => '490',
					'50000 ' => '1700',
				),
				'Uzbekistan'                   => array(
					'100 '   => '8',
					'500 '   => '34',
					'1000 '  => '65',
					'5000 '  => '312',
					'10000 ' => '614',
					'50000 ' => '2965',
				),
				'Venezuela'                    => array(
					'100 '   => '7',
					'500 '   => '31',
					'1000 '  => '59',
					'5000 '  => '280',
					'10000 ' => '549',
					'50000 ' => '2640',
				),
				'Vietnam'                      => array(
					'100 '   => '7',
					'500 '   => '29',
					'1000 '  => '56',
					'5000 '  => '265',
					'10000 ' => '520',
					'50000 ' => '2495',
				),
				'Yemen'                        => array(
					'100 '   => '13',
					'500 '   => '60',
					'1000 '  => '117',
					'5000 '  => '570',
					'10000 ' => '1130',
					'50000 ' => '5545',
				),
				'Zambia'                       => array(
					'100 '   => '12',
					'500 '   => '57',
					'1000 '  => '111',
					'5000 '  => '539',
					'10000 ' => '1068',
					'50000 ' => '5235',
				),
				'Zimbabwe'                     => array(
					'100 '   => '16',
					'500 '   => '72',
					'1000 '  => '142',
					'5000 '  => '695',
					'10000 ' => '1380',
					'50000 ' => '6795',
				),
			);
			add_action( 'wp_ajax_wa_miniorange_check_pricing', array( $this, 'check_whatsapp_pricing' ) );
			add_action( 'wp_ajax_miniorange_check_sms_pricing', array( $this, 'check_sms_pricing' ) );
			define(
				'MO_SMS_PRICING',
				$sms_pricing
			);
		}


		/**
		 * Function for checking the whatsapp pricing.
		 */
		public function check_whatsapp_pricing() {
			if ( ! check_ajax_referer( 'whatsappnonce', 'security', false ) ) {
				return;
			}
			$target_country = isset( $_POST['target_country'] ) ? sanitize_text_field( wp_unslash( $_POST['target_country'] ) ) : ''; // phpcs:ignore -- false positive.

			$whatsapp_pricing_response = $this->mo_wa_check_pricing( $target_country );
			echo wp_json_encode( $whatsapp_pricing_response );
			die();
		}


		/**
		 * Function for checking the SMS pricing.
		 */
		public function check_sms_pricing() {
			if ( ! check_ajax_referer( 'mosmsnonce', 'security', false ) ) {
				return;
			}
			$target_country       = isset( $_POST['target_country'] ) ? sanitize_text_field( wp_unslash( $_POST['target_country'] ) ) : ''; // phpcs:ignore -- false positive.
			$sms_pricing_response = MO_SMS_PRICING[ $target_country ];
			echo wp_json_encode( $sms_pricing_response );
			die;
		}


		/**
		 * Check the whatsapp pricing for a particular target country.
		 *
		 * @param string $target_country - target country.
		 * @return array
		 */
		public function mo_wa_check_pricing( $target_country ) {
			$content = $this->check_transaction_cost( $target_country );
			return $content;
		}

		/**Country List
		 *
		 * @var $countries
		 */
		public static $countries = array(
			array(
				'name'         => 'All Countries',
				'alphacode'    => '',
				'countryCode'  => '',
				'whatsappcost' => array(
					'100'   => '25',
					'500'   => '89',
					'1000'  => '169',
					'5000'  => '768',
					'10000' => '1518',
					'50000' => '7475',
				),
			),
			array(
				'name'         => 'North America',
				'whatsappcost' => array(
					'100'   => '3',
					'500'   => '9',
					'1000'  => '17',
					'5000'  => '75',
					'10000' => '150',
					'50000' => '740',
				),
			),
			array(
				'name'         => 'Rest of Africa',
				'whatsappcost' => array(
					'100'   => '13',
					'500'   => '63',
					'1000'  => '124',
					'5000'  => '612',
					'10000' => '1215',
					'50000' => '6050',
				),
			),
			array(
				'name'         => 'Rest of Asia Pacific',
				'whatsappcost' => array(
					'100'   => '9',
					'500'   => '42',
					'1000'  => '83',
					'5000'  => '410',
					'10000' => '821',
					'50000' => '4101',
				),
			),
			array(
				'name'         => 'Rest of Central & Eastern Europe',
				'whatsappcost' => array(
					'100'   => '10',
					'500'   => '46',
					'1000'  => '91',
					'5000'  => '438',
					'10000' => '865',
					'50000' => '4220',
				),
			),
			array(
				'name'         => 'Rest of Latin America',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '37',
					'1000'  => '72',
					'5000'  => '355',
					'10000' => '710',
					'50000' => '3535',
				),
			),
			array(
				'name'         => 'Rest of Middle East',
				'whatsappcost' => array(
					'100'   => '9',
					'500'   => '41',
					'1000'  => '81',
					'5000'  => '389',
					'10000' => '767',
					'50000' => '3680',
				),
			),
			array(
				'name'         => 'Rest of Western Europe',
				'whatsappcost' => array(
					'100'   => '15',
					'500'   => '71',
					'1000'  => '139',
					'5000'  => '682',
					'10000' => '1357',
					'50000' => '6670',
				),
			),
			array(
				'name'         => 'Argentina',
				'alphacode'    => 'ar',
				'countryCode'  => '+54',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '37',
					'1000'  => '70',
					'5000'  => '340',
					'10000' => '665',
					'50000' => '3300',
				),
			),
			array(
				'name'         => 'Brazil (Brasil)',
				'alphacode'    => 'br',
				'countryCode'  => '+55',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '33',
					'1000'  => '63',
					'5000'  => '275',
					'10000' => '533',
					'50000' => '2550',
				),
			),
			array(
				'name'         => 'Chile',
				'alphacode'    => 'cl',
				'countryCode'  => '+56',
				'whatsappcost' => array(
					'100'   => '10',
					'500'   => '42',
					'1000'  => '83',
					'5000'  => '399',
					'10000' => '787',
					'50000' => '3830',
				),
			),
			array(
				'name'         => 'Colombia',
				'alphacode'    => 'co',
				'countryCode'  => '+57',
				'whatsappcost' => array(
					'100'   => '3',
					'500'   => '10',
					'1000'  => '17',
					'5000'  => '70',
					'10000' => '130',
					'50000' => '545',
				),
			),
			array(
				'name'         => 'Egypt (‫مصر‬‎)',
				'alphacode'    => 'eg',
				'countryCode'  => '+20',
				'whatsappcost' => array(
					'100'   => '13',
					'500'   => '58',
					'1000'  => '114',
					'5000'  => '557',
					'10000' => '1103',
					'50000' => '5410',
				),

			),
			array(
				'name'         => 'France',
				'alphacode'    => 'fr',
				'countryCode'  => '+33',
				'whatsappcost' => array(
					'100'   => '16',
					'500'   => '76',
					'1000'  => '150',
					'5000'  => '736',
					'10000' => '1462',
					'50000' => '7205',
				),
			),
			array(
				'name'         => 'Germany (Deutschland)',
				'alphacode'    => 'de',
				'countryCode'  => '+49',
				'whatsappcost' => array(
					'100'   => '16',
					'500'   => '73',
					'1000'  => '144',
					'5000'  => '703',
					'10000' => '1395',
					'50000' => '6870',
				),
			),
			array(
				'name'         => 'India (भारत)',
				'alphacode'    => 'in',
				'countryCode'  => '+91',
				'whatsappcost' => array(
					'100'   => '3',
					'500'   => '8',
					'1000'  => '14',
					'5000'  => '53',
					'10000' => '96',
					'50000' => '375',
				),
			),
			array(
				'name'         => 'Indonesia',
				'alphacode'    => 'id',
				'countryCode'  => '+62',
				'whatsappcost' => array(
					'100'   => '4',
					'500'   => '16',
					'1000'  => '32',
					'5000'  => '160',
					'10000' => '318',
					'50000' => '1582',
				),
			),
			array(
				'name'         => 'Israel (‫ישראל‬‎)',
				'alphacode'    => 'il',
				'countryCode'  => '+972',
				'whatsappcost' => array(
					'100'   => '5',
					'500'   => '20',
					'1000'  => '37',
					'5000'  => '170',
					'10000' => '330',
					'50000' => '1545',
				),
			),
			array(
				'name'         => 'Italy (Italia)',
				'alphacode'    => 'it',
				'countryCode'  => '+39',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '37',
					'1000'  => '71',
					'5000'  => '342',
					'10000' => '673',
					'50000' => '3260',
				),
			),
			array(
				'name'         => 'Kazakhstan (Казахстан)',
				'alphacode'    => 'kz',
				'countryCode'  => '+7',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '38',
					'1000'  => '75',
					'5000'  => '373',
					'10000' => '746',
					'50000' => '3728',
				),
			),
			array(
				'name'         => 'Malaysia',
				'alphacode'    => 'my',
				'countryCode'  => '+60',
				'whatsappcost' => array(
					'100'   => '10',
					'500'   => '45',
					'1000'  => '78',
					'5000'  => '375',
					'10000' => '746',
					'50000' => '3720',
				),
			),
			array(
				'name'         => 'Mexico (México)',
				'alphacode'    => 'mx',
				'countryCode'  => '+52',
				'whatsappcost' => array(
					'100'   => '5',
					'500'   => '22',
					'1000'  => '42',
					'5000'  => '195',
					'10000' => '379',
					'50000' => '1790',
				),
			),
			array(
				'name'         => 'Netherlands (Nederland)',
				'alphacode'    => 'nl',
				'countryCode'  => '+31',
				'whatsappcost' => array(
					'100'   => '17',
					'500'   => '79',
					'1000'  => '156',
					'5000'  => '763',
					'10000' => '1515',
					'50000' => '7470',
				),
			),
			array(
				'name'         => 'Nigeria',
				'alphacode'    => 'ng',
				'countryCode'  => '+234',
				'whatsappcost' => array(
					'100'   => '7',
					'500'   => '30',
					'1000'  => '59',
					'5000'  => '278',
					'10000' => '546',
					'50000' => '2625',
				),
			),
			array(
				'name'         => 'Pakistan (‫پاکستان‬‎)',
				'alphacode'    => 'pk',
				'countryCode'  => '+92',
				'whatsappcost' => array(
					'100'   => '7',
					'500'   => '28',
					'1000'  => '54',
					'5000'  => '257',
					'10000' => '503',
					'50000' => '2410',
				),
			),
			array(
				'name'         => 'Peru (Perú)',
				'alphacode'    => 'pe',
				'countryCode'  => '+51',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '34',
					'1000'  => '67',
					'5000'  => '319',
					'10000' => '628',
					'50000' => '3035',
				),
			),
			array(
				'name'         => 'Russia (Россия)',
				'alphacode'    => 'ru',
				'countryCode'  => '+7',
				'whatsappcost' => array(
					'100'   => '9',
					'500'   => '38',
					'1000'  => '73',
					'5000'  => '352',
					'10000' => '693',
					'50000' => '3360',
				),
			),
			array(
				'name'         => 'Saudi Arabia (‫المملكة العربية السعودية‬‎)',
				'alphacode'    => 'sa',
				'countryCode'  => '+966',
				'whatsappcost' => array(
					'100'   => '5',
					'500'   => '21',
					'1000'  => '40',
					'5000'  => '183',
					'10000' => '355',
					'50000' => '1670',
				),
			),
			array(
				'name'         => 'South Africa',
				'alphacode'    => 'za',
				'countryCode'  => '+27',
				'whatsappcost' => array(
					'100'   => '5',
					'500'   => '19',
					'1000'  => '35',
					'5000'  => '160',
					'10000' => '310',
					'50000' => '1445',
				),
			),
			array(
				'name'         => 'Spain (España)',
				'alphacode'    => 'es',
				'countryCode'  => '+34',
				'whatsappcost' => array(
					'100'   => '8',
					'500'   => '35',
					'1000'  => '69',
					'5000'  => '328',
					'10000' => '645',
					'50000' => '3120',
				),
			),
			array(
				'name'         => 'Turkey (Türkiye)',
				'alphacode'    => 'tr',
				'countryCode'  => '+90',
				'whatsappcost' => array(
					'100'   => '3',
					'500'   => '10',
					'1000'  => '17',
					'5000'  => '70',
					'10000' => '130',
					'50000' => '545',
				),
			),
			array(
				'name'         => 'United Arab Emirates (‫الإمارات العربية المتحدة‬‎)',
				'alphacode'    => 'ae',
				'countryCode'  => '+971',
				'whatsappcost' => array(
					'100'   => '5',
					'500'   => '20',
					'1000'  => '39',
					'5000'  => '178',
					'10000' => '346',
					'50000' => '1625',
				),
			),
			array(
				'name'         => 'United Kingdom',
				'alphacode'    => 'gb',
				'countryCode'  => '+44',
				'whatsappcost' => array(
					'100'   => '9',
					'500'   => '40',
					'1000'  => '70',
					'5000'  => '340',
					'10000' => '660',
					'50000' => '3275',
				),
			),
		);

		/**
		 * Function for selected countries.
		 */
		public static function get_only_country_list() {
			$country_list = array();
			foreach ( self::$countries as $country ) {
				if ( $country['name'] ) {
					array_push( $country_list, $country['name'] );
				}
			}
			return $country_list;
		}

		/**
		 * Function to check the whatsapp pricing for the target country.
		 *
		 * @param string $target_country - target country.
		 */
		public static function check_transaction_cost( $target_country ) {
			foreach ( self::$countries as $country ) {
				if ( $country['name'] === $target_country ) {
					return $country['whatsappcost'];
				}
			}
		}
	}
}
