<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState26CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1774,
'name' => 'Alborz'
],[
'state_id' => 1774,
'name' => 'Alvand'
],[
'state_id' => 1774,
'name' => 'Avaj'
],[
'state_id' => 1774,
'name' => 'Qazvin'
],[
'state_id' => 1774,
'name' => 'Buin Zahra'
],[
'state_id' => 1774,
'name' => 'Takestan'
],[
'state_id' => 1774,
'name' => 'Abyek'
],[
'state_id' => 1774,
'name' => 'Khakali'
],[
'state_id' => 1774,
'name' => 'Abgarm'
],[
'state_id' => 1774,
'name' => 'Bidestan'
],[
'state_id' => 1774,
'name' => 'Sharif Abad'
],[
'state_id' => 1774,
'name' => 'Mohammadiyeh '
],[
'state_id' => 1774,
'name' => 'Ardagh'
],[
'state_id' => 1774,
'name' => 'Danesfahan'
],[
'state_id' => 1774,
'name' => 'Sagz Abad'
],[
'state_id' => 1774,
'name' => 'Shal'
],[
'state_id' => 1774,
'name' => 'Esfarvarin'
],[
'state_id' => 1774,
'name' => 'Khorramdasht'
],[
'state_id' => 1774,
'name' => 'Ziaabad'
],[
'state_id' => 1774,
'name' => 'Narjeh'
],[
'state_id' => 1774,
'name' => 'Eqbaliyeh'
],[
'state_id' => 1774,
'name' => 'Razmian'
],[
'state_id' => 1774,
'name' => 'Sirdan'
],[
'state_id' => 1774,
'name' => 'Kouhin'
],[
'state_id' => 1774,
'name' => 'Mahmood Abad nemooneh'
],[
'state_id' => 1774,
'name' => 'Moallem Kelayeh'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
