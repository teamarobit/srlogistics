<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GMStateWCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1405,
'name' => 'Abuko'
],[
'state_id' => 1405,
'name' => 'Brikama'
],[
'state_id' => 1405,
'name' => 'Foni Bondali'
],[
'state_id' => 1405,
'name' => 'Foni Brefet'
],[
'state_id' => 1405,
'name' => 'Foni Jarrol'
],[
'state_id' => 1405,
'name' => 'Foni Kansala'
],[
'state_id' => 1405,
'name' => 'Gunjur'
],[
'state_id' => 1405,
'name' => 'Kombo Central District'
],[
'state_id' => 1405,
'name' => 'Kombo East District'
],[
'state_id' => 1405,
'name' => 'Kombo North District'
],[
'state_id' => 1405,
'name' => 'Kombo South District'
],[
'state_id' => 1405,
'name' => 'Somita'
],[
'state_id' => 1405,
'name' => 'Sukuta'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
