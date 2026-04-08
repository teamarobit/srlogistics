<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState01CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 609,
'name' => 'Barani'
],[
'state_id' => 609,
'name' => 'Boromo'
],[
'state_id' => 609,
'name' => 'Dédougou'
],[
'state_id' => 609,
'name' => 'Nouna'
],[
'state_id' => 609,
'name' => 'Province de la Kossi'
],[
'state_id' => 609,
'name' => 'Province des Balé'
],[
'state_id' => 609,
'name' => 'Province des Banwa'
],[
'state_id' => 609,
'name' => 'Province du Mouhoun'
],[
'state_id' => 609,
'name' => 'Province du Nayala'
],[
'state_id' => 609,
'name' => 'Province du Sourou'
],[
'state_id' => 609,
'name' => 'Salanso'
],[
'state_id' => 609,
'name' => 'Toma'
],[
'state_id' => 609,
'name' => 'Tougan'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
