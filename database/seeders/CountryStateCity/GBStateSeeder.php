<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GBStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 232,
'name' => 'Isle of Wight',
'iso2' => 'IOW'
],[
'country_id' => 232,
'name' => 'St Helens',
'iso2' => 'SHN'
],[
'country_id' => 232,
'name' => 'London Borough of Brent',
'iso2' => 'BEN'
],[
'country_id' => 232,
'name' => 'Walsall',
'iso2' => 'WLL'
],[
'country_id' => 232,
'name' => 'Trafford',
'iso2' => 'TRF'
],[
'country_id' => 232,
'name' => 'City of Southampton',
'iso2' => 'STH'
],[
'country_id' => 232,
'name' => 'Sheffield',
'iso2' => 'SHF'
],[
'country_id' => 232,
'name' => 'West Sussex',
'iso2' => 'WSX'
],[
'country_id' => 232,
'name' => 'City of Peterborough',
'iso2' => 'PTE'
],[
'country_id' => 232,
'name' => 'Caerphilly County Borough',
'iso2' => 'CAY'
],[
'country_id' => 232,
'name' => 'Vale of Glamorgan',
'iso2' => 'VGL'
],[
'country_id' => 232,
'name' => 'Shetland Islands',
'iso2' => 'ZET'
],[
'country_id' => 232,
'name' => 'Rhondda Cynon Taf',
'iso2' => 'RCT'
],[
'country_id' => 232,
'name' => 'Poole',
'iso2' => 'POL'
],[
'country_id' => 232,
'name' => 'Central Bedfordshire',
'iso2' => 'CBF'
],[
'country_id' => 232,
'name' => 'Down District Council',
'iso2' => 'DOW'
],[
'country_id' => 232,
'name' => 'City of Portsmouth',
'iso2' => 'POR'
],[
'country_id' => 232,
'name' => 'London Borough of Haringey',
'iso2' => 'HRY'
],[
'country_id' => 232,
'name' => 'London Borough of Bexley',
'iso2' => 'BEX'
],[
'country_id' => 232,
'name' => 'Rotherham',
'iso2' => 'ROT'
],[
'country_id' => 232,
'name' => 'Hartlepool',
'iso2' => 'HPL'
],[
'country_id' => 232,
'name' => 'Telford and Wrekin',
'iso2' => 'TFW'
],[
'country_id' => 232,
'name' => 'Belfast district',
'iso2' => 'BFS'
],[
'country_id' => 232,
'name' => 'Cornwall',
'iso2' => 'CON'
],[
'country_id' => 232,
'name' => 'London Borough of Sutton',
'iso2' => 'STN'
],[
'country_id' => 232,
'name' => 'Omagh District Council',
'iso2' => 'OMH'
],[
'country_id' => 232,
'name' => 'Banbridge',
'iso2' => 'BNB'
],[
'country_id' => 232,
'name' => 'Causeway Coast and Glens',
'iso2' => 'CCG'
],[
'country_id' => 232,
'name' => 'Newtownabbey Borough Council',
'iso2' => 'NTA'
],[
'country_id' => 232,
'name' => 'City of Leicester',
'iso2' => 'LCE'
],[
'country_id' => 232,
'name' => 'London Borough of Islington',
'iso2' => 'ISL'
],[
'country_id' => 232,
'name' => 'Metropolitan Borough of Wigan',
'iso2' => 'WGN'
],[
'country_id' => 232,
'name' => 'Oxfordshire',
'iso2' => 'OXF'
],[
'country_id' => 232,
'name' => 'Magherafelt District Council',
'iso2' => 'MFT'
],[
'country_id' => 232,
'name' => 'Southend-on-Sea',
'iso2' => 'SOS'
],[
'country_id' => 232,
'name' => 'Armagh, Banbridge and Craigavon',
'iso2' => 'ABC'
],[
'country_id' => 232,
'name' => 'Perth and Kinross',
'iso2' => 'PKN'
],[
'country_id' => 232,
'name' => 'London Borough of Waltham Forest',
'iso2' => 'WFT'
],[
'country_id' => 232,
'name' => 'Rochdale',
'iso2' => 'RCH'
],[
'country_id' => 232,
'name' => 'Merthyr Tydfil County Borough',
'iso2' => 'MTY'
],[
'country_id' => 232,
'name' => 'Blackburn with Darwen',
'iso2' => 'BBD'
],[
'country_id' => 232,
'name' => 'Knowsley',
'iso2' => 'KWL'
],[
'country_id' => 232,
'name' => 'Armagh City and District Council',
'iso2' => 'ARM'
],[
'country_id' => 232,
'name' => 'Middlesbrough',
'iso2' => 'MDB'
],[
'country_id' => 232,
'name' => 'East Renfrewshire',
'iso2' => 'ERW'
],[
'country_id' => 232,
'name' => 'Cumbria',
'iso2' => 'CMA'
],[
'country_id' => 232,
'name' => 'Scotland',
'iso2' => 'SCT'
],[
'country_id' => 232,
'name' => 'England',
'iso2' => 'ENG'
],[
'country_id' => 232,
'name' => 'Northern Ireland',
'iso2' => 'NIR'
],[
'country_id' => 232,
'name' => 'Wales',
'iso2' => 'WLS'
],[
'country_id' => 232,
'name' => 'Bath and North East Somerset',
'iso2' => 'BAS'
],[
'country_id' => 232,
'name' => 'Liverpool',
'iso2' => 'LIV'
],[
'country_id' => 232,
'name' => 'Sandwell',
'iso2' => 'SAW'
],[
'country_id' => 232,
'name' => 'Bournemouth',
'iso2' => 'BMH'
],[
'country_id' => 232,
'name' => 'Isles of Scilly',
'iso2' => 'IOS'
],[
'country_id' => 232,
'name' => 'Falkirk',
'iso2' => 'FAL'
],[
'country_id' => 232,
'name' => 'Dorset',
'iso2' => 'DOR'
],[
'country_id' => 232,
'name' => 'Scottish Borders',
'iso2' => 'SCB'
],[
'country_id' => 232,
'name' => 'London Borough of Havering',
'iso2' => 'HAV'
],[
'country_id' => 232,
'name' => 'Moyle District Council',
'iso2' => 'MYL'
],[
'country_id' => 232,
'name' => 'London Borough of Camden',
'iso2' => 'CMD'
],[
'country_id' => 232,
'name' => 'Newry and Mourne District Council',
'iso2' => 'NYM'
],[
'country_id' => 232,
'name' => 'Neath Port Talbot County Borough',
'iso2' => 'NTL'
],[
'country_id' => 232,
'name' => 'Conwy County Borough',
'iso2' => 'CWY'
],[
'country_id' => 232,
'name' => 'Outer Hebrides',
'iso2' => 'ELS'
],[
'country_id' => 232,
'name' => 'West Lothian',
'iso2' => 'WLN'
],[
'country_id' => 232,
'name' => 'Lincolnshire',
'iso2' => 'LIN'
],[
'country_id' => 232,
'name' => 'London Borough of Barking and Dagenham',
'iso2' => 'BDG'
],[
'country_id' => 232,
'name' => 'City of Westminster',
'iso2' => 'WSM'
],[
'country_id' => 232,
'name' => 'London Borough of Lewisham',
'iso2' => 'LEW'
],[
'country_id' => 232,
'name' => 'City of Nottingham',
'iso2' => 'NGM'
],[
'country_id' => 232,
'name' => 'Moray',
'iso2' => 'MRY'
],[
'country_id' => 232,
'name' => 'Ballymoney',
'iso2' => 'BLY'
],[
'country_id' => 232,
'name' => 'South Lanarkshire',
'iso2' => 'SLK'
],[
'country_id' => 232,
'name' => 'Ballymena Borough',
'iso2' => 'BLA'
],[
'country_id' => 232,
'name' => 'Doncaster',
'iso2' => 'DNC'
],[
'country_id' => 232,
'name' => 'Northumberland',
'iso2' => 'NBL'
],[
'country_id' => 232,
'name' => 'Fermanagh and Omagh',
'iso2' => 'FMO'
],[
'country_id' => 232,
'name' => 'Tameside',
'iso2' => 'TAM'
],[
'country_id' => 232,
'name' => 'Royal Borough of Kensington and Chelsea',
'iso2' => 'KEC'
],[
'country_id' => 232,
'name' => 'Hertfordshire',
'iso2' => 'HRT'
],[
'country_id' => 232,
'name' => 'East Riding of Yorkshire',
'iso2' => 'ERY'
],[
'country_id' => 232,
'name' => 'Kirklees',
'iso2' => 'KIR'
],[
'country_id' => 232,
'name' => 'City of Sunderland',
'iso2' => 'SND'
],[
'country_id' => 232,
'name' => 'Gloucestershire',
'iso2' => 'GLS'
],[
'country_id' => 232,
'name' => 'East Ayrshire',
'iso2' => 'EAY'
],[
'country_id' => 232,
'name' => 'United Kingdom',
'iso2' => 'UKM'
],[
'country_id' => 232,
'name' => 'London Borough of Hillingdon',
'iso2' => 'HIL'
],[
'country_id' => 232,
'name' => 'South Ayrshire',
'iso2' => 'SAY'
],[
'country_id' => 232,
'name' => 'Ascension Island',
'iso2' => 'SH-AC'
],[
'country_id' => 232,
'name' => 'Gwynedd',
'iso2' => 'GWN'
],[
'country_id' => 232,
'name' => 'London Borough of Hounslow',
'iso2' => 'HNS'
],[
'country_id' => 232,
'name' => 'Medway',
'iso2' => 'MDW'
],[
'country_id' => 232,
'name' => 'Limavady Borough Council',
'iso2' => 'LMV'
],[
'country_id' => 232,
'name' => 'Highland',
'iso2' => 'HLD'
],[
'country_id' => 232,
'name' => 'North East Lincolnshire',
'iso2' => 'NEL'
],[
'country_id' => 232,
'name' => 'London Borough of Harrow',
'iso2' => 'HRW'
],[
'country_id' => 232,
'name' => 'Somerset',
'iso2' => 'SOM'
],[
'country_id' => 232,
'name' => 'Angus',
'iso2' => 'ANS'
],[
'country_id' => 232,
'name' => 'Inverclyde',
'iso2' => 'IVC'
],[
'country_id' => 232,
'name' => 'Darlington',
'iso2' => 'DAL'
],[
'country_id' => 232,
'name' => 'London Borough of Tower Hamlets',
'iso2' => 'TWH'
],[
'country_id' => 232,
'name' => 'Wiltshire',
'iso2' => 'WIL'
],[
'country_id' => 232,
'name' => 'Argyll and Bute',
'iso2' => 'AGB'
],[
'country_id' => 232,
'name' => 'Strabane District Council',
'iso2' => 'STB'
],[
'country_id' => 232,
'name' => 'Stockport',
'iso2' => 'SKP'
],[
'country_id' => 232,
'name' => 'Brighton and Hove',
'iso2' => 'BNH'
],[
'country_id' => 232,
'name' => 'London Borough of Lambeth',
'iso2' => 'LBH'
],[
'country_id' => 232,
'name' => 'London Borough of Redbridge',
'iso2' => 'RDB'
],[
'country_id' => 232,
'name' => 'Manchester',
'iso2' => 'MAN'
],[
'country_id' => 232,
'name' => 'Mid Ulster',
'iso2' => 'MUL'
],[
'country_id' => 232,
'name' => 'South Gloucestershire',
'iso2' => 'SGC'
],[
'country_id' => 232,
'name' => 'Aberdeenshire',
'iso2' => 'ABD'
],[
'country_id' => 232,
'name' => 'Monmouthshire',
'iso2' => 'MON'
],[
'country_id' => 232,
'name' => 'Derbyshire',
'iso2' => 'DBY'
],[
'country_id' => 232,
'name' => 'Glasgow',
'iso2' => 'GLG'
],[
'country_id' => 232,
'name' => 'Buckinghamshire',
'iso2' => 'BKM'
],[
'country_id' => 232,
'name' => 'County Durham',
'iso2' => 'DUR'
],[
'country_id' => 232,
'name' => 'Shropshire',
'iso2' => 'SHR'
],[
'country_id' => 232,
'name' => 'Wirral',
'iso2' => 'WRL'
],[
'country_id' => 232,
'name' => 'South Tyneside',
'iso2' => 'STY'
],[
'country_id' => 232,
'name' => 'Essex',
'iso2' => 'ESS'
],[
'country_id' => 232,
'name' => 'London Borough of Hackney',
'iso2' => 'HCK'
],[
'country_id' => 232,
'name' => 'Antrim and Newtownabbey',
'iso2' => 'ANN'
],[
'country_id' => 232,
'name' => 'City of Bristol',
'iso2' => 'BST'
],[
'country_id' => 232,
'name' => 'East Sussex',
'iso2' => 'ESX'
],[
'country_id' => 232,
'name' => 'Dumfries and Galloway',
'iso2' => 'DGY'
],[
'country_id' => 232,
'name' => 'Milton Keynes',
'iso2' => 'MIK'
],[
'country_id' => 232,
'name' => 'Derry City Council',
'iso2' => 'DRY'
],[
'country_id' => 232,
'name' => 'London Borough of Newham',
'iso2' => 'NWM'
],[
'country_id' => 232,
'name' => 'Wokingham',
'iso2' => 'WOK'
],[
'country_id' => 232,
'name' => 'Warrington',
'iso2' => 'WRT'
],[
'country_id' => 232,
'name' => 'Stockton-on-Tees',
'iso2' => 'STT'
],[
'country_id' => 232,
'name' => 'Swindon',
'iso2' => 'SWD'
],[
'country_id' => 232,
'name' => 'Cambridgeshire',
'iso2' => 'CAM'
],[
'country_id' => 232,
'name' => 'City of London',
'iso2' => 'LND'
],[
'country_id' => 232,
'name' => 'Birmingham',
'iso2' => 'BIR'
],[
'country_id' => 232,
'name' => 'City of York',
'iso2' => 'YOR'
],[
'country_id' => 232,
'name' => 'Slough',
'iso2' => 'SLG'
],[
'country_id' => 232,
'name' => 'Edinburgh',
'iso2' => 'EDH'
],[
'country_id' => 232,
'name' => 'Mid and East Antrim',
'iso2' => 'MEA'
],[
'country_id' => 232,
'name' => 'North Somerset',
'iso2' => 'NSM'
],[
'country_id' => 232,
'name' => 'Gateshead',
'iso2' => 'GAT'
],[
'country_id' => 232,
'name' => 'London Borough of Southwark',
'iso2' => 'SWK'
],[
'country_id' => 232,
'name' => 'City and County of Swansea',
'iso2' => 'SWA'
],[
'country_id' => 232,
'name' => 'London Borough of Wandsworth',
'iso2' => 'WND'
],[
'country_id' => 232,
'name' => 'Hampshire',
'iso2' => 'HAM'
],[
'country_id' => 232,
'name' => 'Wrexham County Borough',
'iso2' => 'WRX'
],[
'country_id' => 232,
'name' => 'Flintshire',
'iso2' => 'FLN'
],[
'country_id' => 232,
'name' => 'Coventry',
'iso2' => 'COV'
],[
'country_id' => 232,
'name' => 'Carrickfergus Borough Council',
'iso2' => 'CKF'
],[
'country_id' => 232,
'name' => 'West Dunbartonshire',
'iso2' => 'WDU'
],[
'country_id' => 232,
'name' => 'Powys',
'iso2' => 'POW'
],[
'country_id' => 232,
'name' => 'Cheshire West and Chester',
'iso2' => 'CHW'
],[
'country_id' => 232,
'name' => 'Renfrewshire',
'iso2' => 'RFW'
],[
'country_id' => 232,
'name' => 'Cheshire East',
'iso2' => 'CHE'
],[
'country_id' => 232,
'name' => 'Cookstown District Council',
'iso2' => 'CKT'
],[
'country_id' => 232,
'name' => 'Derry City and Strabane',
'iso2' => 'DRS'
],[
'country_id' => 232,
'name' => 'Staffordshire',
'iso2' => 'STS'
],[
'country_id' => 232,
'name' => 'London Borough of Hammersmith and Fulham',
'iso2' => 'HMF'
],[
'country_id' => 232,
'name' => 'Craigavon Borough Council',
'iso2' => 'CGV'
],[
'country_id' => 232,
'name' => 'Clackmannanshire',
'iso2' => 'CLK'
],[
'country_id' => 232,
'name' => 'Blackpool',
'iso2' => 'BPL'
],[
'country_id' => 232,
'name' => 'Bridgend County Borough',
'iso2' => 'BGE'
],[
'country_id' => 232,
'name' => 'North Lincolnshire',
'iso2' => 'NLN'
],[
'country_id' => 232,
'name' => 'East Dunbartonshire',
'iso2' => 'EDU'
],[
'country_id' => 232,
'name' => 'Reading',
'iso2' => 'RDG'
],[
'country_id' => 232,
'name' => 'Nottinghamshire',
'iso2' => 'NTT'
],[
'country_id' => 232,
'name' => 'Dudley',
'iso2' => 'DUD'
],[
'country_id' => 232,
'name' => 'Newcastle upon Tyne',
'iso2' => 'NET'
],[
'country_id' => 232,
'name' => 'Bury',
'iso2' => 'BUR'
],[
'country_id' => 232,
'name' => 'Lisburn and Castlereagh',
'iso2' => 'LBC'
],[
'country_id' => 232,
'name' => 'Coleraine Borough Council',
'iso2' => 'CLR'
],[
'country_id' => 232,
'name' => 'East Lothian',
'iso2' => 'ELN'
],[
'country_id' => 232,
'name' => 'Aberdeen',
'iso2' => 'ABE'
],[
'country_id' => 232,
'name' => 'Kent',
'iso2' => 'KEN'
],[
'country_id' => 232,
'name' => 'Wakefield',
'iso2' => 'WKF'
],[
'country_id' => 232,
'name' => 'Halton',
'iso2' => 'HAL'
],[
'country_id' => 232,
'name' => 'Suffolk',
'iso2' => 'SFK'
],[
'country_id' => 232,
'name' => 'Thurrock',
'iso2' => 'THR'
],[
'country_id' => 232,
'name' => 'Solihull',
'iso2' => 'SOL'
],[
'country_id' => 232,
'name' => 'Bracknell Forest',
'iso2' => 'BRC'
],[
'country_id' => 232,
'name' => 'West Berkshire',
'iso2' => 'WBK'
],[
'country_id' => 232,
'name' => 'Rutland',
'iso2' => 'RUT'
],[
'country_id' => 232,
'name' => 'Norfolk',
'iso2' => 'NFK'
],[
'country_id' => 232,
'name' => 'Orkney Islands',
'iso2' => 'ORK'
],[
'country_id' => 232,
'name' => 'City of Kingston upon Hull',
'iso2' => 'KHL'
],[
'country_id' => 232,
'name' => 'London Borough of Enfield',
'iso2' => 'ENF'
],[
'country_id' => 232,
'name' => 'Oldham',
'iso2' => 'OLD'
],[
'country_id' => 232,
'name' => 'Torbay',
'iso2' => 'TOB'
],[
'country_id' => 232,
'name' => 'Fife',
'iso2' => 'FIF'
],[
'country_id' => 232,
'name' => 'Northamptonshire',
'iso2' => 'NTH'
],[
'country_id' => 232,
'name' => 'Royal Borough of Kingston upon Thames',
'iso2' => 'KTT'
],[
'country_id' => 232,
'name' => 'Windsor and Maidenhead',
'iso2' => 'WNM'
],[
'country_id' => 232,
'name' => 'London Borough of Merton',
'iso2' => 'MRT'
],[
'country_id' => 232,
'name' => 'Carmarthenshire',
'iso2' => 'CMN'
],[
'country_id' => 232,
'name' => 'City of Derby',
'iso2' => 'DER'
],[
'country_id' => 232,
'name' => 'Pembrokeshire',
'iso2' => 'PEM'
],[
'country_id' => 232,
'name' => 'North Lanarkshire',
'iso2' => 'NLK'
],[
'country_id' => 232,
'name' => 'Stirling',
'iso2' => 'STG'
],[
'country_id' => 232,
'name' => 'City of Wolverhampton',
'iso2' => 'WLV'
],[
'country_id' => 232,
'name' => 'London Borough of Bromley',
'iso2' => 'BRY'
],[
'country_id' => 232,
'name' => 'Devon',
'iso2' => 'DEV'
],[
'country_id' => 232,
'name' => 'Royal Borough of Greenwich',
'iso2' => 'GRE'
],[
'country_id' => 232,
'name' => 'Salford',
'iso2' => 'SLF'
],[
'country_id' => 232,
'name' => 'Lisburn City Council',
'iso2' => 'LSB'
],[
'country_id' => 232,
'name' => 'Lancashire',
'iso2' => 'LAN'
],[
'country_id' => 232,
'name' => 'Torfaen',
'iso2' => 'TOF'
],[
'country_id' => 232,
'name' => 'Denbighshire',
'iso2' => 'DEN'
],[
'country_id' => 232,
'name' => 'Ards',
'iso2' => 'ARD'
],[
'country_id' => 232,
'name' => 'Barnsley',
'iso2' => 'BNS'
],[
'country_id' => 232,
'name' => 'Herefordshire',
'iso2' => 'HEF'
],[
'country_id' => 232,
'name' => 'London Borough of Richmond upon Thames',
'iso2' => 'RIC'
],[
'country_id' => 232,
'name' => 'Saint Helena',
'iso2' => 'SH-HL'
],[
'country_id' => 232,
'name' => 'Leeds',
'iso2' => 'LDS'
],[
'country_id' => 232,
'name' => 'Bolton',
'iso2' => 'BOL'
],[
'country_id' => 232,
'name' => 'Warwickshire',
'iso2' => 'WAR'
],[
'country_id' => 232,
'name' => 'City of Stoke-on-Trent',
'iso2' => 'STE'
],[
'country_id' => 232,
'name' => 'Bedford',
'iso2' => 'BDF'
],[
'country_id' => 232,
'name' => 'Dungannon and South Tyrone Borough Council',
'iso2' => 'DGN'
],[
'country_id' => 232,
'name' => 'Ceredigion',
'iso2' => 'CGN'
],[
'country_id' => 232,
'name' => 'Worcestershire',
'iso2' => 'WOR'
],[
'country_id' => 232,
'name' => 'Dundee',
'iso2' => 'DND'
],[
'country_id' => 232,
'name' => 'London Borough of Croydon',
'iso2' => 'CRY'
],[
'country_id' => 232,
'name' => 'North Down Borough Council',
'iso2' => 'NDN'
],[
'country_id' => 232,
'name' => 'City of Plymouth',
'iso2' => 'PLY'
],[
'country_id' => 232,
'name' => 'Larne Borough Council',
'iso2' => 'LRN'
],[
'country_id' => 232,
'name' => 'Leicestershire',
'iso2' => 'LEC'
],[
'country_id' => 232,
'name' => 'Calderdale',
'iso2' => 'CLD'
],[
'country_id' => 232,
'name' => 'Sefton',
'iso2' => 'SFT'
],[
'country_id' => 232,
'name' => 'Midlothian',
'iso2' => 'MLN'
],[
'country_id' => 232,
'name' => 'London Borough of Barnet',
'iso2' => 'BNE'
],[
'country_id' => 232,
'name' => 'North Tyneside',
'iso2' => 'NTY'
],[
'country_id' => 232,
'name' => 'North Yorkshire',
'iso2' => 'NYK'
],[
'country_id' => 232,
'name' => 'Ards and North Down',
'iso2' => 'AND'
],[
'country_id' => 232,
'name' => 'Newport',
'iso2' => 'NWP'
],[
'country_id' => 232,
'name' => 'Castlereagh',
'iso2' => 'CSR'
],[
'country_id' => 232,
'name' => 'Surrey',
'iso2' => 'SRY'
],[
'country_id' => 232,
'name' => 'Redcar and Cleveland',
'iso2' => 'RCC'
],[
'country_id' => 232,
'name' => 'City and County of Cardiff',
'iso2' => 'CRF'
],[
'country_id' => 232,
'name' => 'Bradford',
'iso2' => 'BRD'
],[
'country_id' => 232,
'name' => 'Blaenau Gwent County Borough',
'iso2' => 'BGW'
],[
'country_id' => 232,
'name' => 'Fermanagh District Council',
'iso2' => 'FER'
],[
'country_id' => 232,
'name' => 'London Borough of Ealing',
'iso2' => 'EAL'
],[
'country_id' => 232,
'name' => 'Antrim',
'iso2' => 'ANT'
],[
'country_id' => 232,
'name' => 'Newry, Mourne and Down',
'iso2' => 'NMD'
],[
'country_id' => 232,
'name' => 'North Ayrshire',
'iso2' => 'NAY'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
