<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CYState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 968,
'name' => 'Kyrenia'
],[
'state_id' => 968,
'name' => 'Kyrenia Municipality'
],[
'state_id' => 968,
'name' => 'Lápithos'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
