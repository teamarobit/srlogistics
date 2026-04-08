<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class YEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 245,
'name' => 'Ta\'izz',
'iso2' => 'TA'
],[
'country_id' => 245,
'name' => 'Amanat Al Asimah',
'iso2' => 'SA'
],[
'country_id' => 245,
'name' => 'Ibb',
'iso2' => 'IB'
],[
'country_id' => 245,
'name' => 'Ma\'rib',
'iso2' => 'MA'
],[
'country_id' => 245,
'name' => 'Al Mahwit',
'iso2' => 'MW'
],[
'country_id' => 245,
'name' => 'Sana\'a',
'iso2' => 'SN'
],[
'country_id' => 245,
'name' => 'Abyan',
'iso2' => 'AB'
],[
'country_id' => 245,
'name' => 'Hadhramaut',
'iso2' => 'HD'
],[
'country_id' => 245,
'name' => 'Socotra',
'iso2' => 'SU'
],[
'country_id' => 245,
'name' => 'Al Bayda',
'iso2' => 'BA'
],[
'country_id' => 245,
'name' => 'Al Hudaydah',
'iso2' => 'HU'
],[
'country_id' => 245,
'name' => 'Adan',
'iso2' => 'AD'
],[
'country_id' => 245,
'name' => 'Al Jawf',
'iso2' => 'JA'
],[
'country_id' => 245,
'name' => 'Hajjah',
'iso2' => 'HJ'
],[
'country_id' => 245,
'name' => 'Lahij',
'iso2' => 'LA'
],[
'country_id' => 245,
'name' => 'Dhamar',
'iso2' => 'DH'
],[
'country_id' => 245,
'name' => 'Shabwah',
'iso2' => 'SH'
],[
'country_id' => 245,
'name' => 'Raymah',
'iso2' => 'RA'
],[
'country_id' => 245,
'name' => 'Saada',
'iso2' => 'SD'
],[
'country_id' => 245,
'name' => 'Amran',
'iso2' => 'AM'
],[
'country_id' => 245,
'name' => 'Al Mahrah',
'iso2' => 'MR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
