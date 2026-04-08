<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 586,
'name' => 'Goulouré'
],[
'state_id' => 586,
'name' => 'Kokologo'
],[
'state_id' => 586,
'name' => 'Koudougou'
],[
'state_id' => 586,
'name' => 'Léo'
],[
'state_id' => 586,
'name' => 'Pitmoaga'
],[
'state_id' => 586,
'name' => 'Province de la Sissili'
],[
'state_id' => 586,
'name' => 'Province du Boulkiemdé'
],[
'state_id' => 586,
'name' => 'Province du Sanguié'
],[
'state_id' => 586,
'name' => 'Province du Ziro'
],[
'state_id' => 586,
'name' => 'Réo'
],[
'state_id' => 586,
'name' => 'Sapouy'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
