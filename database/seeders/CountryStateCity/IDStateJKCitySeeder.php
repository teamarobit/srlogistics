<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IDStateJKCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1726,
'name' => 'Jakarta'
],[
'state_id' => 1726,
'name' => 'Kota Administrasi Jakarta Barat'
],[
'state_id' => 1726,
'name' => 'Kota Administrasi Jakarta Pusat'
],[
'state_id' => 1726,
'name' => 'Kota Administrasi Jakarta Selatan'
],[
'state_id' => 1726,
'name' => 'Kota Administrasi Jakarta Timur'
],[
'state_id' => 1726,
'name' => 'Kota Administrasi Jakarta Utara'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
