<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 492,
'name' => 'Guayaramerín'
],[
'state_id' => 492,
'name' => 'Provincia Cercado'
],[
'state_id' => 492,
'name' => 'Provincia General José Ballivián'
],[
'state_id' => 492,
'name' => 'Provincia Iténez'
],[
'state_id' => 492,
'name' => 'Provincia Mamoré'
],[
'state_id' => 492,
'name' => 'Provincia Marbán'
],[
'state_id' => 492,
'name' => 'Provincia Moxos'
],[
'state_id' => 492,
'name' => 'Provincia Vaca Diez'
],[
'state_id' => 492,
'name' => 'Provincia Yacuma'
],[
'state_id' => 492,
'name' => 'Reyes'
],[
'state_id' => 492,
'name' => 'Riberalta'
],[
'state_id' => 492,
'name' => 'Rurrenabaque'
],[
'state_id' => 492,
'name' => 'San Borja'
],[
'state_id' => 492,
'name' => 'San Ramón'
],[
'state_id' => 492,
'name' => 'Santa Ana de Yacuma'
],[
'state_id' => 492,
'name' => 'Santa Rosa'
],[
'state_id' => 492,
'name' => 'Trinidad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
