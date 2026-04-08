<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class AOStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 7,
'name' => 'Bié Province',
'iso2' => 'BIE'
],[
'country_id' => 7,
'name' => 'Huambo Province',
'iso2' => 'HUA'
],[
'country_id' => 7,
'name' => 'Zaire Province',
'iso2' => 'ZAI'
],[
'country_id' => 7,
'name' => 'Cunene Province',
'iso2' => 'CNN'
],[
'country_id' => 7,
'name' => 'Cuanza Sul',
'iso2' => 'CUS'
],[
'country_id' => 7,
'name' => 'Cuanza Norte Province',
'iso2' => 'CNO'
],[
'country_id' => 7,
'name' => 'Benguela Province',
'iso2' => 'BGU'
],[
'country_id' => 7,
'name' => 'Moxico Province',
'iso2' => 'MOX'
],[
'country_id' => 7,
'name' => 'Lunda Sul Province',
'iso2' => 'LSU'
],[
'country_id' => 7,
'name' => 'Bengo Province',
'iso2' => 'BGO'
],[
'country_id' => 7,
'name' => 'Luanda Province',
'iso2' => 'LUA'
],[
'country_id' => 7,
'name' => 'Lunda Norte Province',
'iso2' => 'LNO'
],[
'country_id' => 7,
'name' => 'Uíge Province',
'iso2' => 'UIG'
],[
'country_id' => 7,
'name' => 'Huíla Province',
'iso2' => 'HUI'
],[
'country_id' => 7,
'name' => 'Cuando Cubango Province',
'iso2' => 'CCU'
],[
'country_id' => 7,
'name' => 'Malanje Province',
'iso2' => 'MAL'
],[
'country_id' => 7,
'name' => 'Cabinda Province',
'iso2' => 'CAB'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
