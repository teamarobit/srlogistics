<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class ZWStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 247,
'name' => 'Mashonaland East Province',
'iso2' => 'ME'
],[
'country_id' => 247,
'name' => 'Matabeleland South Province',
'iso2' => 'MS'
],[
'country_id' => 247,
'name' => 'Mashonaland West Province',
'iso2' => 'MW'
],[
'country_id' => 247,
'name' => 'Matabeleland North Province',
'iso2' => 'MN'
],[
'country_id' => 247,
'name' => 'Mashonaland Central Province',
'iso2' => 'MC'
],[
'country_id' => 247,
'name' => 'Bulawayo Province',
'iso2' => 'BU'
],[
'country_id' => 247,
'name' => 'Midlands Province',
'iso2' => 'MI'
],[
'country_id' => 247,
'name' => 'Harare Province',
'iso2' => 'HA'
],[
'country_id' => 247,
'name' => 'Manicaland',
'iso2' => 'MA'
],[
'country_id' => 247,
'name' => 'Masvingo Province',
'iso2' => 'MV'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
