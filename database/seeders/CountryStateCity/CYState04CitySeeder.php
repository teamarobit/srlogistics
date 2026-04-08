<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState04CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 973,
'name' => 'Acherítou'
],[
'state_id' => 973,
'name' => 'Ammochostos Municipality'
],[
'state_id' => 973,
'name' => 'Avgórou'
],[
'state_id' => 973,
'name' => 'Ayia Napa'
],[
'state_id' => 973,
'name' => 'Derýneia'
],[
'state_id' => 973,
'name' => 'Famagusta'
],[
'state_id' => 973,
'name' => 'Frénaros'
],[
'state_id' => 973,
'name' => 'Lefkónoiko'
],[
'state_id' => 973,
'name' => 'Leonárisso'
],[
'state_id' => 973,
'name' => 'Liopétri'
],[
'state_id' => 973,
'name' => 'Paralímni'
],[
'state_id' => 973,
'name' => 'Protaras'
],[
'state_id' => 973,
'name' => 'Rizokárpaso'
],[
'state_id' => 973,
'name' => 'Tríkomo'
],[
'state_id' => 973,
'name' => 'Áchna'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
