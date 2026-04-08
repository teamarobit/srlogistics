<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CIState07CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 915,
'name' => 'Arrah'
],[
'state_id' => 915,
'name' => 'Bocanda'
],[
'state_id' => 915,
'name' => 'Bongouanou'
],[
'state_id' => 915,
'name' => 'Bélier'
],[
'state_id' => 915,
'name' => 'Daoukro'
],[
'state_id' => 915,
'name' => 'Dimbokro'
],[
'state_id' => 915,
'name' => 'Iffou'
],[
'state_id' => 915,
'name' => 'Moronou'
],[
'state_id' => 915,
'name' => 'N\'Zi'
],[
'state_id' => 915,
'name' => 'Toumodi'
],[
'state_id' => 915,
'name' => 'Yamoussoukro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
