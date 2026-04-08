<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BTStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 26,
'name' => 'Gasa District',
'iso2' => 'GA'
],[
'country_id' => 26,
'name' => 'Tsirang District',
'iso2' => '21'
],[
'country_id' => 26,
'name' => 'Wangdue Phodrang District',
'iso2' => '24'
],[
'country_id' => 26,
'name' => 'Haa District',
'iso2' => '13'
],[
'country_id' => 26,
'name' => 'Zhemgang District',
'iso2' => '34'
],[
'country_id' => 26,
'name' => 'Lhuntse District',
'iso2' => '44'
],[
'country_id' => 26,
'name' => 'Punakha District',
'iso2' => '23'
],[
'country_id' => 26,
'name' => 'Trashigang District',
'iso2' => '41'
],[
'country_id' => 26,
'name' => 'Paro District',
'iso2' => '11'
],[
'country_id' => 26,
'name' => 'Dagana District',
'iso2' => '22'
],[
'country_id' => 26,
'name' => 'Chukha District',
'iso2' => '12'
],[
'country_id' => 26,
'name' => 'Bumthang District',
'iso2' => '33'
],[
'country_id' => 26,
'name' => 'Thimphu District',
'iso2' => '15'
],[
'country_id' => 26,
'name' => 'Mongar District',
'iso2' => '42'
],[
'country_id' => 26,
'name' => 'Samdrup Jongkhar District',
'iso2' => '45'
],[
'country_id' => 26,
'name' => 'Pemagatshel District',
'iso2' => '43'
],[
'country_id' => 26,
'name' => 'Trongsa District',
'iso2' => '32'
],[
'country_id' => 26,
'name' => 'Samtse District',
'iso2' => '14'
],[
'country_id' => 26,
'name' => 'Sarpang District',
'iso2' => '31'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
