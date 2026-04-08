<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CRStateGCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 893,
'name' => 'Abangares'
],[
'state_id' => 893,
'name' => 'Bagaces'
],[
'state_id' => 893,
'name' => 'Belén'
],[
'state_id' => 893,
'name' => 'Carrillo'
],[
'state_id' => 893,
'name' => 'Cañas'
],[
'state_id' => 893,
'name' => 'Fortuna'
],[
'state_id' => 893,
'name' => 'Hojancha'
],[
'state_id' => 893,
'name' => 'Juntas'
],[
'state_id' => 893,
'name' => 'La Cruz'
],[
'state_id' => 893,
'name' => 'Liberia'
],[
'state_id' => 893,
'name' => 'Nandayure'
],[
'state_id' => 893,
'name' => 'Nicoya'
],[
'state_id' => 893,
'name' => 'Santa Cruz'
],[
'state_id' => 893,
'name' => 'Sardinal'
],[
'state_id' => 893,
'name' => 'Sámara'
],[
'state_id' => 893,
'name' => 'Tilarán'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
