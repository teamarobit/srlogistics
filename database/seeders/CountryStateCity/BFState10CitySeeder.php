<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BFState10CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 635,
'name' => 'Gourcy'
],[
'state_id' => 635,
'name' => 'Ouahigouya'
],[
'state_id' => 635,
'name' => 'Province du Loroum'
],[
'state_id' => 635,
'name' => 'Province du Passoré'
],[
'state_id' => 635,
'name' => 'Province du Yatenga'
],[
'state_id' => 635,
'name' => 'Province du Zondoma'
],[
'state_id' => 635,
'name' => 'Titao'
],[
'state_id' => 635,
'name' => 'Yako'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
