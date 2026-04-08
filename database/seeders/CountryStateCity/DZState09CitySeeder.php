<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState09CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 94,
'name' => 'Beni Mered'
],[
'state_id' => 94,
'name' => 'Blida'
],[
'state_id' => 94,
'name' => 'Boufarik'
],[
'state_id' => 94,
'name' => 'Bougara'
],[
'state_id' => 94,
'name' => 'Bouinan'
],[
'state_id' => 94,
'name' => 'Boû Arfa'
],[
'state_id' => 94,
'name' => 'Chebli'
],[
'state_id' => 94,
'name' => 'Chiffa'
],[
'state_id' => 94,
'name' => 'Larbaâ'
],[
'state_id' => 94,
'name' => 'Meftah'
],[
'state_id' => 94,
'name' => 'Sidi Moussa'
],[
'state_id' => 94,
'name' => 'Souma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
