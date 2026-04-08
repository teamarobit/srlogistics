<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class FIState17CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1260,
'name' => 'Eura'
],[
'state_id' => 1260,
'name' => 'Eurajoki'
],[
'state_id' => 1260,
'name' => 'Harjavalta'
],[
'state_id' => 1260,
'name' => 'Huittinen'
],[
'state_id' => 1260,
'name' => 'Jämijärvi'
],[
'state_id' => 1260,
'name' => 'Kankaanpää'
],[
'state_id' => 1260,
'name' => 'Karvia'
],[
'state_id' => 1260,
'name' => 'Kiukainen'
],[
'state_id' => 1260,
'name' => 'Kokemäki'
],[
'state_id' => 1260,
'name' => 'Kullaa'
],[
'state_id' => 1260,
'name' => 'Köyliö'
],[
'state_id' => 1260,
'name' => 'Lappi'
],[
'state_id' => 1260,
'name' => 'Lavia'
],[
'state_id' => 1260,
'name' => 'Luvia'
],[
'state_id' => 1260,
'name' => 'Längelmäki'
],[
'state_id' => 1260,
'name' => 'Merikarvia'
],[
'state_id' => 1260,
'name' => 'Nakkila'
],[
'state_id' => 1260,
'name' => 'Noormarkku'
],[
'state_id' => 1260,
'name' => 'Pomarkku'
],[
'state_id' => 1260,
'name' => 'Pori'
],[
'state_id' => 1260,
'name' => 'Rauma'
],[
'state_id' => 1260,
'name' => 'Siikainen'
],[
'state_id' => 1260,
'name' => 'Säkylä'
],[
'state_id' => 1260,
'name' => 'Ulvila'
],[
'state_id' => 1260,
'name' => 'Vampula'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
