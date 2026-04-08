<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState5CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 674,
'name' => 'Kampong Speu'
],[
'state_id' => 674,
'name' => 'Krŏng Chbar Mon'
],[
'state_id' => 674,
'name' => 'Srŏk Basedth'
],[
'state_id' => 674,
'name' => 'Srŏk Kông Pĭsei'
],[
'state_id' => 674,
'name' => 'Srŏk Ŏdŏngk'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
