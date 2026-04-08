<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class KHState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 676,
'name' => 'Banlung'
],[
'state_id' => 676,
'name' => 'Lumphat'
],[
'state_id' => 676,
'name' => 'Srŏk Ban Lŭng'
],[
'state_id' => 676,
'name' => 'Srŏk Bâ Kêv'
],[
'state_id' => 676,
'name' => 'Srŏk Koun Mom'
],[
'state_id' => 676,
'name' => 'Srŏk Ou Chum'
],[
'state_id' => 676,
'name' => 'Srŏk Ou Ya Dav'
],[
'state_id' => 676,
'name' => 'Srŏk Ta Vêng'
],[
'state_id' => 676,
'name' => 'Srŏk Ândong Méas'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
