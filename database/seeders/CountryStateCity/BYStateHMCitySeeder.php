<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BYStateHMCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 430,
'name' => 'Frunzyenski Rayon'
],[
'state_id' => 430,
'name' => 'Kastrychnitski Rayon'
],[
'state_id' => 430,
'name' => 'Lyeninski Rayon'
],[
'state_id' => 430,
'name' => 'Maskowski Rayon'
],[
'state_id' => 430,
'name' => 'Minsk'
],[
'state_id' => 430,
'name' => 'Partyzanski Rayon'
],[
'state_id' => 430,
'name' => 'Savyetski Rayon'
],[
'state_id' => 430,
'name' => 'Tsentral’ny Rayon'
],[
'state_id' => 430,
'name' => 'Zavodski Rayon'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
