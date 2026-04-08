<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HTStateGACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1585,
'name' => 'Anse-à-Veau'
],[
'state_id' => 1585,
'name' => 'Chambellan'
],[
'state_id' => 1585,
'name' => 'Corail'
],[
'state_id' => 1585,
'name' => 'Dame-Marie'
],[
'state_id' => 1585,
'name' => 'Jeremi'
],[
'state_id' => 1585,
'name' => 'Jérémie'
],[
'state_id' => 1585,
'name' => 'Les Abricots'
],[
'state_id' => 1585,
'name' => 'Les Irois'
],[
'state_id' => 1585,
'name' => 'Moron'
],[
'state_id' => 1585,
'name' => 'Petite Rivière de Nippes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
