<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class SVStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 66,
'name' => 'San Vicente Department',
'iso2' => 'SV'
],[
'country_id' => 66,
'name' => 'Santa Ana Department',
'iso2' => 'SA'
],[
'country_id' => 66,
'name' => 'Usulután Department',
'iso2' => 'US'
],[
'country_id' => 66,
'name' => 'Morazán Department',
'iso2' => 'MO'
],[
'country_id' => 66,
'name' => 'Chalatenango Department',
'iso2' => 'CH'
],[
'country_id' => 66,
'name' => 'Cabañas Department',
'iso2' => 'CA'
],[
'country_id' => 66,
'name' => 'San Salvador Department',
'iso2' => 'SS'
],[
'country_id' => 66,
'name' => 'La Libertad Department',
'iso2' => 'LI'
],[
'country_id' => 66,
'name' => 'San Miguel Department',
'iso2' => 'SM'
],[
'country_id' => 66,
'name' => 'La Paz Department',
'iso2' => 'PA'
],[
'country_id' => 66,
'name' => 'Cuscatlán Department',
'iso2' => 'CU'
],[
'country_id' => 66,
'name' => 'La Unión Department',
'iso2' => 'UN'
],[
'country_id' => 66,
'name' => 'Ahuachapán Department',
'iso2' => 'AH'
],[
'country_id' => 66,
'name' => 'Sonsonate Department',
'iso2' => 'SO'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
