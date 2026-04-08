<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DOState11CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1108,
'name' => 'Boca de Yuma'
],[
'state_id' => 1108,
'name' => 'Higüey'
],[
'state_id' => 1108,
'name' => 'Otra Banda'
],[
'state_id' => 1108,
'name' => 'Punta Cana'
],[
'state_id' => 1108,
'name' => 'Salvaleón de Higüey'
],[
'state_id' => 1108,
'name' => 'San Rafael del Yuma'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
