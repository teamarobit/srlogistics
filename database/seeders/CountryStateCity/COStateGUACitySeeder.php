<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class COStateGUACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 827,
'name' => 'Barranco Minas'
],[
'state_id' => 827,
'name' => 'Cacahual'
],[
'state_id' => 827,
'name' => 'Inírida'
],[
'state_id' => 827,
'name' => 'La Guadalupe'
],[
'state_id' => 827,
'name' => 'Mapiripana'
],[
'state_id' => 827,
'name' => 'Morichal'
],[
'state_id' => 827,
'name' => 'Pana Pana'
],[
'state_id' => 827,
'name' => 'Puerto Colombia'
],[
'state_id' => 827,
'name' => 'San Felipe'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
