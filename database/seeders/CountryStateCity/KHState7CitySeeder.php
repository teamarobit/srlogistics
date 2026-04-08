<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState7CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 667,
'name' => 'Angkor Chey'
],[
'state_id' => 667,
'name' => 'Banteay Meas'
],[
'state_id' => 667,
'name' => 'Chhouk District'
],[
'state_id' => 667,
'name' => 'Kampong Bay'
],[
'state_id' => 667,
'name' => 'Kampong Tranch'
],[
'state_id' => 667,
'name' => 'Kampot'
],[
'state_id' => 667,
'name' => 'Srok Tuek Chhou'
],[
'state_id' => 667,
'name' => 'Srŏk Chŭm Kiri'
],[
'state_id' => 667,
'name' => 'Srŏk Dângtóng'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
