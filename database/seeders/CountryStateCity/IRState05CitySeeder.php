<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState05CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1752,
'name' => 'Harsin'
],[
'state_id' => 1752,
'name' => 'Javanrud'
],[
'state_id' => 1752,
'name' => 'Kahriz'
],[
'state_id' => 1752,
'name' => 'Kangavar'
],[
'state_id' => 1752,
'name' => 'Kermanshah'
],[
'state_id' => 1752,
'name' => 'Paveh'
],[
'state_id' => 1752,
'name' => 'Dalahu'
],[
'state_id' => 1752,
'name' => 'Eslamabad-e-Gharb'
],[
'state_id' => 1752,
'name' => 'Gilan Gharb'
],[
'state_id' => 1752,
'name' => 'Qasr-e Shirin'
],[
'state_id' => 1752,
'name' => 'Ravansar'
],[
'state_id' => 1752,
'name' => 'Sarpol Zahab'
],[
'state_id' => 1752,
'name' => 'Salas-e Baba Jani'
],[
'state_id' => 1752,
'name' => 'Sahneh'
],[
'state_id' => 1752,
'name' => 'Sonqor'
],[
'state_id' => 1752,
'name' => 'Hamil'
],[
'state_id' => 1752,
'name' => 'Banevreh'
],[
'state_id' => 1752,
'name' => 'Bayangan'
],[
'state_id' => 1752,
'name' => 'Nowdeshah'
],[
'state_id' => 1752,
'name' => 'Nowsud'
],[
'state_id' => 1752,
'name' => 'Ezgeleh'
],[
'state_id' => 1752,
'name' => 'azeh Abad'
],[
'state_id' => 1752,
'name' => 'Rijab'
],[
'state_id' => 1752,
'name' => 'Kerend-e Gharb'
],[
'state_id' => 1752,
'name' => 'Gahvareh'
],[
'state_id' => 1752,
'name' => 'Mansur-e Aqai'
],[
'state_id' => 1752,
'name' => 'Satar'
],[
'state_id' => 1752,
'name' => 'Miyan Rahan'
],[
'state_id' => 1752,
'name' => 'Soomar'
],[
'state_id' => 1752,
'name' => 'Robat'
],[
'state_id' => 1752,
'name' => 'Kuzaran'
],[
'state_id' => 1752,
'name' => 'Halashi'
],[
'state_id' => 1752,
'name' => 'Gowdin'
],[
'state_id' => 1752,
'name' => 'Srmast'
],[
'state_id' => 1752,
'name' => 'Bisotun'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
