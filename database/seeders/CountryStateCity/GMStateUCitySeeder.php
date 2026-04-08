<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateUCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1406,
'name' => 'Bakadagy'
],[
'state_id' => 1406,
'name' => 'Basse Santa Su'
],[
'state_id' => 1406,
'name' => 'Brifu'
],[
'state_id' => 1406,
'name' => 'Daba Kunda'
],[
'state_id' => 1406,
'name' => 'Demba Kunda'
],[
'state_id' => 1406,
'name' => 'Diabugu'
],[
'state_id' => 1406,
'name' => 'Diabugu Basilla'
],[
'state_id' => 1406,
'name' => 'Fulladu East'
],[
'state_id' => 1406,
'name' => 'Gunjur Kuta'
],[
'state_id' => 1406,
'name' => 'Kantora'
],[
'state_id' => 1406,
'name' => 'Koina'
],[
'state_id' => 1406,
'name' => 'Kumbija'
],[
'state_id' => 1406,
'name' => 'Nyamanari'
],[
'state_id' => 1406,
'name' => 'Perai'
],[
'state_id' => 1406,
'name' => 'Sabi'
],[
'state_id' => 1406,
'name' => 'Sandu'
],[
'state_id' => 1406,
'name' => 'Sudowol'
],[
'state_id' => 1406,
'name' => 'Sun Kunda'
],[
'state_id' => 1406,
'name' => 'Sutukoba'
],[
'state_id' => 1406,
'name' => 'Wuli'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
