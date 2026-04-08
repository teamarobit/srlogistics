<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class GRState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1488,
'name' => 'Agnanteró'
],[
'state_id' => 1488,
'name' => 'Agía Triáda'
],[
'state_id' => 1488,
'name' => 'Anthiró'
],[
'state_id' => 1488,
'name' => 'Anávra'
],[
'state_id' => 1488,
'name' => 'Artesianó'
],[
'state_id' => 1488,
'name' => 'Itéa'
],[
'state_id' => 1488,
'name' => 'Kallifóni'
],[
'state_id' => 1488,
'name' => 'Kallíthiro'
],[
'state_id' => 1488,
'name' => 'Karditsomagoúla'
],[
'state_id' => 1488,
'name' => 'Kardítsa'
],[
'state_id' => 1488,
'name' => 'Karpochóri'
],[
'state_id' => 1488,
'name' => 'Magoúla'
],[
'state_id' => 1488,
'name' => 'Makrychóri'
],[
'state_id' => 1488,
'name' => 'Mavrommáti'
],[
'state_id' => 1488,
'name' => 'Mitrópoli'
],[
'state_id' => 1488,
'name' => 'Morfovoúni'
],[
'state_id' => 1488,
'name' => 'Mouzáki'
],[
'state_id' => 1488,
'name' => 'Palamás'
],[
'state_id' => 1488,
'name' => 'Proástio'
],[
'state_id' => 1488,
'name' => 'Sofádes'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
