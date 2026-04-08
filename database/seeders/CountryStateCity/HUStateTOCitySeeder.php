<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateTOCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1639,
'name' => 'Bogyiszló'
],[
'state_id' => 1639,
'name' => 'Bonyhád'
],[
'state_id' => 1639,
'name' => 'Bonyhádi Járás'
],[
'state_id' => 1639,
'name' => 'Báta'
],[
'state_id' => 1639,
'name' => 'Bátaszék'
],[
'state_id' => 1639,
'name' => 'Bölcske'
],[
'state_id' => 1639,
'name' => 'Decs'
],[
'state_id' => 1639,
'name' => 'Dombóvár'
],[
'state_id' => 1639,
'name' => 'Dombóvári Járás'
],[
'state_id' => 1639,
'name' => 'Dunaföldvár'
],[
'state_id' => 1639,
'name' => 'Dunaszentgyörgy'
],[
'state_id' => 1639,
'name' => 'Döbrököz'
],[
'state_id' => 1639,
'name' => 'Fadd'
],[
'state_id' => 1639,
'name' => 'Gyönk'
],[
'state_id' => 1639,
'name' => 'Hőgyész'
],[
'state_id' => 1639,
'name' => 'Iregszemcse'
],[
'state_id' => 1639,
'name' => 'Madocsa'
],[
'state_id' => 1639,
'name' => 'Nagydorog'
],[
'state_id' => 1639,
'name' => 'Nagymányok'
],[
'state_id' => 1639,
'name' => 'Németkér'
],[
'state_id' => 1639,
'name' => 'Ozora'
],[
'state_id' => 1639,
'name' => 'Paks'
],[
'state_id' => 1639,
'name' => 'Paksi Járás'
],[
'state_id' => 1639,
'name' => 'Pincehely'
],[
'state_id' => 1639,
'name' => 'Simontornya'
],[
'state_id' => 1639,
'name' => 'Szedres'
],[
'state_id' => 1639,
'name' => 'Szekszárd'
],[
'state_id' => 1639,
'name' => 'Szekszárdi Járás'
],[
'state_id' => 1639,
'name' => 'Szentgálpuszta'
],[
'state_id' => 1639,
'name' => 'Tamási'
],[
'state_id' => 1639,
'name' => 'Tamási Járás'
],[
'state_id' => 1639,
'name' => 'Tengelic'
],[
'state_id' => 1639,
'name' => 'Tolna'
],[
'state_id' => 1639,
'name' => 'Tolnai Járás'
],[
'state_id' => 1639,
'name' => 'Zomba'
],[
'state_id' => 1639,
'name' => 'Őcsény'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
