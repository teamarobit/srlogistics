<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class EEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 69,
'name' => 'Hiiu County',
'iso2' => '39'
],[
'country_id' => 69,
'name' => 'Viljandi County',
'iso2' => '84'
],[
'country_id' => 69,
'name' => 'Tartu County',
'iso2' => '78'
],[
'country_id' => 69,
'name' => 'Valga County',
'iso2' => '82'
],[
'country_id' => 69,
'name' => 'Rapla County',
'iso2' => '70'
],[
'country_id' => 69,
'name' => 'Võru County',
'iso2' => '86'
],[
'country_id' => 69,
'name' => 'Saare County',
'iso2' => '74'
],[
'country_id' => 69,
'name' => 'Pärnu County',
'iso2' => '67'
],[
'country_id' => 69,
'name' => 'Põlva County',
'iso2' => '65'
],[
'country_id' => 69,
'name' => 'Lääne-Viru County',
'iso2' => '59'
],[
'country_id' => 69,
'name' => 'Jõgeva County',
'iso2' => '49'
],[
'country_id' => 69,
'name' => 'Järva County',
'iso2' => '51'
],[
'country_id' => 69,
'name' => 'Harju County',
'iso2' => '37'
],[
'country_id' => 69,
'name' => 'Lääne County',
'iso2' => '57'
],[
'country_id' => 69,
'name' => 'Ida-Viru County',
'iso2' => '44'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
