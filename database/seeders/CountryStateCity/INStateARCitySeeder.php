<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class INStateARCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1697,
'name' => 'Along'
],[
'state_id' => 1697,
'name' => 'Anjaw'
],[
'state_id' => 1697,
'name' => 'Bomdila'
],[
'state_id' => 1697,
'name' => 'Basar'
],[
'state_id' => 1697,
'name' => 'Changlang'
],[
'state_id' => 1697,
'name' => 'Dibang Valley'
],[
'state_id' => 1697,
'name' => 'East Kameng'
],[
'state_id' => 1697,
'name' => 'East Siang'
],[
'state_id' => 1697,
'name' => 'Hayuliang'
],[
'state_id' => 1697,
'name' => 'Itanagar'
],[
'state_id' => 1697,
'name' => 'Khonsa'
],[
'state_id' => 1697,
'name' => 'Kurung Kumey'
],[
'state_id' => 1697,
'name' => 'Lohit District'
],[
'state_id' => 1697,
'name' => 'Lower Dibang Valley'
],[
'state_id' => 1697,
'name' => 'Lower Subansiri'
],[
'state_id' => 1697,
'name' => 'Margherita'
],[
'state_id' => 1697,
'name' => 'Naharlagun'
],[
'state_id' => 1697,
'name' => 'Pasighat'
],[
'state_id' => 1697,
'name' => 'Tawang'
],[
'state_id' => 1697,
'name' => 'Tezu'
],[
'state_id' => 1697,
'name' => 'Tirap'
],[
'state_id' => 1697,
'name' => 'Upper Siang'
],[
'state_id' => 1697,
'name' => 'Upper Subansiri'
],[
'state_id' => 1697,
'name' => 'West Kameng'
],[
'state_id' => 1697,
'name' => 'West Siang'
],[
'state_id' => 1697,
'name' => 'Ziro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
