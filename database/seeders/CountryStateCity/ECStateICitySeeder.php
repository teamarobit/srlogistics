<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class ECStateICitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1134,
'name' => 'Atuntaqui'
],[
'state_id' => 1134,
'name' => 'Cotacachi'
],[
'state_id' => 1134,
'name' => 'Ibarra'
],[
'state_id' => 1134,
'name' => 'Otavalo'
],[
'state_id' => 1134,
'name' => 'Pimampiro'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
