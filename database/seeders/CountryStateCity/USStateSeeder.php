<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class USStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 233,
'name' => 'Howland Island',
'iso2' => 'UM-84'
],[
'country_id' => 233,
'name' => 'Delaware',
'iso2' => 'DE'
],[
'country_id' => 233,
'name' => 'Alaska',
'iso2' => 'AK'
],[
'country_id' => 233,
'name' => 'Maryland',
'iso2' => 'MD'
],[
'country_id' => 233,
'name' => 'Baker Island',
'iso2' => 'UM-81'
],[
'country_id' => 233,
'name' => 'Kingman Reef',
'iso2' => 'UM-89'
],[
'country_id' => 233,
'name' => 'New Hampshire',
'iso2' => 'NH'
],[
'country_id' => 233,
'name' => 'Wake Island',
'iso2' => 'UM-79'
],[
'country_id' => 233,
'name' => 'Kansas',
'iso2' => 'KS'
],[
'country_id' => 233,
'name' => 'Texas',
'iso2' => 'TX'
],[
'country_id' => 233,
'name' => 'Nebraska',
'iso2' => 'NE'
],[
'country_id' => 233,
'name' => 'Vermont',
'iso2' => 'VT'
],[
'country_id' => 233,
'name' => 'Jarvis Island',
'iso2' => 'UM-86'
],[
'country_id' => 233,
'name' => 'Hawaii',
'iso2' => 'HI'
],[
'country_id' => 233,
'name' => 'Guam',
'iso2' => 'GU'
],[
'country_id' => 233,
'name' => 'United States Virgin Islands',
'iso2' => 'VI'
],[
'country_id' => 233,
'name' => 'Utah',
'iso2' => 'UT'
],[
'country_id' => 233,
'name' => 'Oregon',
'iso2' => 'OR'
],[
'country_id' => 233,
'name' => 'California',
'iso2' => 'CA'
],[
'country_id' => 233,
'name' => 'New Jersey',
'iso2' => 'NJ'
],[
'country_id' => 233,
'name' => 'North Dakota',
'iso2' => 'ND'
],[
'country_id' => 233,
'name' => 'Kentucky',
'iso2' => 'KY'
],[
'country_id' => 233,
'name' => 'Minnesota',
'iso2' => 'MN'
],[
'country_id' => 233,
'name' => 'Oklahoma',
'iso2' => 'OK'
],[
'country_id' => 233,
'name' => 'Pennsylvania',
'iso2' => 'PA'
],[
'country_id' => 233,
'name' => 'New Mexico',
'iso2' => 'NM'
],[
'country_id' => 233,
'name' => 'American Samoa',
'iso2' => 'AS'
],[
'country_id' => 233,
'name' => 'Illinois',
'iso2' => 'IL'
],[
'country_id' => 233,
'name' => 'Michigan',
'iso2' => 'MI'
],[
'country_id' => 233,
'name' => 'Virginia',
'iso2' => 'VA'
],[
'country_id' => 233,
'name' => 'Johnston Atoll',
'iso2' => 'UM-67'
],[
'country_id' => 233,
'name' => 'West Virginia',
'iso2' => 'WV'
],[
'country_id' => 233,
'name' => 'Mississippi',
'iso2' => 'MS'
],[
'country_id' => 233,
'name' => 'Northern Mariana Islands',
'iso2' => 'MP'
],[
'country_id' => 233,
'name' => 'United States Minor Outlying Islands',
'iso2' => 'UM'
],[
'country_id' => 233,
'name' => 'Massachusetts',
'iso2' => 'MA'
],[
'country_id' => 233,
'name' => 'Arizona',
'iso2' => 'AZ'
],[
'country_id' => 233,
'name' => 'Connecticut',
'iso2' => 'CT'
],[
'country_id' => 233,
'name' => 'Florida',
'iso2' => 'FL'
],[
'country_id' => 233,
'name' => 'District of Columbia',
'iso2' => 'DC'
],[
'country_id' => 233,
'name' => 'Midway Atoll',
'iso2' => 'UM-71'
],[
'country_id' => 233,
'name' => 'Navassa Island',
'iso2' => 'UM-76'
],[
'country_id' => 233,
'name' => 'Indiana',
'iso2' => 'IN'
],[
'country_id' => 233,
'name' => 'Wisconsin',
'iso2' => 'WI'
],[
'country_id' => 233,
'name' => 'Wyoming',
'iso2' => 'WY'
],[
'country_id' => 233,
'name' => 'South Carolina',
'iso2' => 'SC'
],[
'country_id' => 233,
'name' => 'Arkansas',
'iso2' => 'AR'
],[
'country_id' => 233,
'name' => 'South Dakota',
'iso2' => 'SD'
],[
'country_id' => 233,
'name' => 'Montana',
'iso2' => 'MT'
],[
'country_id' => 233,
'name' => 'North Carolina',
'iso2' => 'NC'
],[
'country_id' => 233,
'name' => 'Palmyra Atoll',
'iso2' => 'UM-95'
],[
'country_id' => 233,
'name' => 'Puerto Rico',
'iso2' => 'PR'
],[
'country_id' => 233,
'name' => 'Colorado',
'iso2' => 'CO'
],[
'country_id' => 233,
'name' => 'Missouri',
'iso2' => 'MO'
],[
'country_id' => 233,
'name' => 'New York',
'iso2' => 'NY'
],[
'country_id' => 233,
'name' => 'Maine',
'iso2' => 'ME'
],[
'country_id' => 233,
'name' => 'Tennessee',
'iso2' => 'TN'
],[
'country_id' => 233,
'name' => 'Georgia',
'iso2' => 'GA'
],[
'country_id' => 233,
'name' => 'Alabama',
'iso2' => 'AL'
],[
'country_id' => 233,
'name' => 'Louisiana',
'iso2' => 'LA'
],[
'country_id' => 233,
'name' => 'Nevada',
'iso2' => 'NV'
],[
'country_id' => 233,
'name' => 'Iowa',
'iso2' => 'IA'
],[
'country_id' => 233,
'name' => 'Idaho',
'iso2' => 'ID'
],[
'country_id' => 233,
'name' => 'Rhode Island',
'iso2' => 'RI'
],[
'country_id' => 233,
'name' => 'Washington',
'iso2' => 'WA'
],[
'country_id' => 233,
'name' => 'Ohio',
'iso2' => 'OH'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
