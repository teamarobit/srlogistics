<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1271,
'name' => 'Anjala'
],[
'state_id' => 1271,
'name' => 'Elimäki'
],[
'state_id' => 1271,
'name' => 'Hamina'
],[
'state_id' => 1271,
'name' => 'Iitti'
],[
'state_id' => 1271,
'name' => 'Jaala'
],[
'state_id' => 1271,
'name' => 'Karhula'
],[
'state_id' => 1271,
'name' => 'Kotka'
],[
'state_id' => 1271,
'name' => 'Kouvola'
],[
'state_id' => 1271,
'name' => 'Miehikkälä'
],[
'state_id' => 1271,
'name' => 'Pyhtää'
],[
'state_id' => 1271,
'name' => 'Virojoki'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
