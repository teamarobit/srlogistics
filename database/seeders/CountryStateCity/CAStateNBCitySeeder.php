<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CAStateNBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 695,
'name' => 'Baie Ste. Anne'
],[
'state_id' => 695,
'name' => 'Bathurst'
],[
'state_id' => 695,
'name' => 'Bouctouche'
],[
'state_id' => 695,
'name' => 'Campbellton'
],[
'state_id' => 695,
'name' => 'Dieppe'
],[
'state_id' => 695,
'name' => 'Edmundston'
],[
'state_id' => 695,
'name' => 'Florenceville-Bristol'
],[
'state_id' => 695,
'name' => 'Fredericton'
],[
'state_id' => 695,
'name' => 'Fundy Bay'
],[
'state_id' => 695,
'name' => 'Grande-Digue'
],[
'state_id' => 695,
'name' => 'Greater Lakeburn'
],[
'state_id' => 695,
'name' => 'Hampton'
],[
'state_id' => 695,
'name' => 'Harrison Brook'
],[
'state_id' => 695,
'name' => 'Keswick Ridge'
],[
'state_id' => 695,
'name' => 'Lincoln'
],[
'state_id' => 695,
'name' => 'Lutes Mountain'
],[
'state_id' => 695,
'name' => 'McEwen'
],[
'state_id' => 695,
'name' => 'Miramichi'
],[
'state_id' => 695,
'name' => 'Moncton'
],[
'state_id' => 695,
'name' => 'Nackawic'
],[
'state_id' => 695,
'name' => 'New Maryland'
],[
'state_id' => 695,
'name' => 'Noonan'
],[
'state_id' => 695,
'name' => 'Oromocto'
],[
'state_id' => 695,
'name' => 'Richibucto'
],[
'state_id' => 695,
'name' => 'Sackville'
],[
'state_id' => 695,
'name' => 'Saint Andrews'
],[
'state_id' => 695,
'name' => 'Saint John'
],[
'state_id' => 695,
'name' => 'Saint-Antoine'
],[
'state_id' => 695,
'name' => 'Saint-Léonard'
],[
'state_id' => 695,
'name' => 'Salisbury'
],[
'state_id' => 695,
'name' => 'Shediac'
],[
'state_id' => 695,
'name' => 'Shediac Bridge-Shediac River'
],[
'state_id' => 695,
'name' => 'Shippagan'
],[
'state_id' => 695,
'name' => 'Starlight Village'
],[
'state_id' => 695,
'name' => 'Sussex'
],[
'state_id' => 695,
'name' => 'Tracadie-Sheila'
],[
'state_id' => 695,
'name' => 'Wells'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
