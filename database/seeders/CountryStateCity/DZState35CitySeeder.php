<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState35CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 108,
'name' => 'Arbatache'
],[
'state_id' => 108,
'name' => 'Beni Amrane'
],[
'state_id' => 108,
'name' => 'Boudouaou'
],[
'state_id' => 108,
'name' => 'Boumerdas'
],[
'state_id' => 108,
'name' => 'Chabet el Ameur'
],[
'state_id' => 108,
'name' => 'Dellys'
],[
'state_id' => 108,
'name' => 'Khemis el Khechna'
],[
'state_id' => 108,
'name' => 'Makouda'
],[
'state_id' => 108,
'name' => 'Naciria'
],[
'state_id' => 108,
'name' => 'Ouled Moussa'
],[
'state_id' => 108,
'name' => 'Reghaïa'
],[
'state_id' => 108,
'name' => 'Tadmaït'
],[
'state_id' => 108,
'name' => 'Thenia'
],[
'state_id' => 108,
'name' => 'Tizi Gheniff'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
