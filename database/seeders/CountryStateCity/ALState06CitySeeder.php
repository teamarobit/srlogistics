<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ALState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 71,
'name' => 'Bashkia Devoll'
],[
'state_id' => 71,
'name' => 'Bashkia Kolonjë'
],[
'state_id' => 71,
'name' => 'Bashkia Maliq'
],[
'state_id' => 71,
'name' => 'Bashkia Pustec'
],[
'state_id' => 71,
'name' => 'Bilisht'
],[
'state_id' => 71,
'name' => 'Ersekë'
],[
'state_id' => 71,
'name' => 'Korçë'
],[
'state_id' => 71,
'name' => 'Leskovik'
],[
'state_id' => 71,
'name' => 'Libonik'
],[
'state_id' => 71,
'name' => 'Maliq'
],[
'state_id' => 71,
'name' => 'Mborje'
],[
'state_id' => 71,
'name' => 'Pogradec'
],[
'state_id' => 71,
'name' => 'Rrethi i Devollit'
],[
'state_id' => 71,
'name' => 'Rrethi i Kolonjës'
],[
'state_id' => 71,
'name' => 'Velçan'
],[
'state_id' => 71,
'name' => 'Voskopojë'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
