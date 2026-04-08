<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class HNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 97,
'name' => 'Choluteca Department',
'iso2' => 'CH'
],[
'country_id' => 97,
'name' => 'Comayagua Department',
'iso2' => 'CM'
],[
'country_id' => 97,
'name' => 'El Paraíso Department',
'iso2' => 'EP'
],[
'country_id' => 97,
'name' => 'Intibucá Department',
'iso2' => 'IN'
],[
'country_id' => 97,
'name' => 'Bay Islands Department',
'iso2' => 'IB'
],[
'country_id' => 97,
'name' => 'Cortés Department',
'iso2' => 'CR'
],[
'country_id' => 97,
'name' => 'Atlántida Department',
'iso2' => 'AT'
],[
'country_id' => 97,
'name' => 'Gracias a Dios Department',
'iso2' => 'GD'
],[
'country_id' => 97,
'name' => 'Copán Department',
'iso2' => 'CP'
],[
'country_id' => 97,
'name' => 'Olancho Department',
'iso2' => 'OL'
],[
'country_id' => 97,
'name' => 'Colón Department',
'iso2' => 'CL'
],[
'country_id' => 97,
'name' => 'Francisco Morazán Department',
'iso2' => 'FM'
],[
'country_id' => 97,
'name' => 'Santa Bárbara Department',
'iso2' => 'SB'
],[
'country_id' => 97,
'name' => 'Lempira Department',
'iso2' => 'LE'
],[
'country_id' => 97,
'name' => 'Valle Department',
'iso2' => 'VA'
],[
'country_id' => 97,
'name' => 'Ocotepeque Department',
'iso2' => 'OC'
],[
'country_id' => 97,
'name' => 'Yoro Department',
'iso2' => 'YO'
],[
'country_id' => 97,
'name' => 'La Paz Department',
'iso2' => 'LP'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
