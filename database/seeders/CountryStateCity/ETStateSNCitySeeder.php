<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ETStateSNCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1223,
'name' => 'Alaba Special Wereda'
],[
'state_id' => 1223,
'name' => 'Arba Minch'
],[
'state_id' => 1223,
'name' => 'Bako'
],[
'state_id' => 1223,
'name' => 'Bench Maji Zone'
],[
'state_id' => 1223,
'name' => 'Bodītī'
],[
'state_id' => 1223,
'name' => 'Bonga'
],[
'state_id' => 1223,
'name' => 'Butajīra'
],[
'state_id' => 1223,
'name' => 'Dīla'
],[
'state_id' => 1223,
'name' => 'Felege Neway'
],[
'state_id' => 1223,
'name' => 'Gedeo Zone'
],[
'state_id' => 1223,
'name' => 'Guraghe Zone'
],[
'state_id' => 1223,
'name' => 'Gīdolē'
],[
'state_id' => 1223,
'name' => 'Hadiya Zone'
],[
'state_id' => 1223,
'name' => 'Hawassa'
],[
'state_id' => 1223,
'name' => 'Hosa’ina'
],[
'state_id' => 1223,
'name' => 'Hāgere Selam'
],[
'state_id' => 1223,
'name' => 'Jinka'
],[
'state_id' => 1223,
'name' => 'Kembata Alaba Tembaro Zone'
],[
'state_id' => 1223,
'name' => 'Konso'
],[
'state_id' => 1223,
'name' => 'K’olīto'
],[
'state_id' => 1223,
'name' => 'Leku'
],[
'state_id' => 1223,
'name' => 'Lobuni'
],[
'state_id' => 1223,
'name' => 'Mīzan Teferī'
],[
'state_id' => 1223,
'name' => 'Sheka Zone'
],[
'state_id' => 1223,
'name' => 'Sidama Zone'
],[
'state_id' => 1223,
'name' => 'Sodo'
],[
'state_id' => 1223,
'name' => 'Tippi'
],[
'state_id' => 1223,
'name' => 'Turmi'
],[
'state_id' => 1223,
'name' => 'Wendo'
],[
'state_id' => 1223,
'name' => 'Wolayita Zone'
],[
'state_id' => 1223,
'name' => 'Yem'
],[
'state_id' => 1223,
'name' => 'Yirga ‘Alem'
],[
'state_id' => 1223,
'name' => 'Āreka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
