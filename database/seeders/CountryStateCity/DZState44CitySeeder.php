<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class DZState44CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 102,
'name' => 'Aïn Defla'
],[
'state_id' => 102,
'name' => 'El Abadia'
],[
'state_id' => 102,
'name' => 'El Attaf'
],[
'state_id' => 102,
'name' => 'Khemis Miliana'
],[
'state_id' => 102,
'name' => 'Theniet el Had'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
