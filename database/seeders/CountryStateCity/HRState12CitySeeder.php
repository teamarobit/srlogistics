<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 944,
'name' => 'Batrina'
],[
'state_id' => 944,
'name' => 'Brodski Varoš'
],[
'state_id' => 944,
'name' => 'Bukovlje'
],[
'state_id' => 944,
'name' => 'Cernik'
],[
'state_id' => 944,
'name' => 'Davor'
],[
'state_id' => 944,
'name' => 'Donji Andrijevci'
],[
'state_id' => 944,
'name' => 'Garčin'
],[
'state_id' => 944,
'name' => 'Gornji Bogićevci'
],[
'state_id' => 944,
'name' => 'Grad Nova Gradiška'
],[
'state_id' => 944,
'name' => 'Grad Slavonski Brod'
],[
'state_id' => 944,
'name' => 'Gundinci'
],[
'state_id' => 944,
'name' => 'Korenica'
],[
'state_id' => 944,
'name' => 'Kruševica'
],[
'state_id' => 944,
'name' => 'Lužani'
],[
'state_id' => 944,
'name' => 'Nova Gradiška'
],[
'state_id' => 944,
'name' => 'Okučani'
],[
'state_id' => 944,
'name' => 'Oprisavci'
],[
'state_id' => 944,
'name' => 'Oriovac'
],[
'state_id' => 944,
'name' => 'Podvinje'
],[
'state_id' => 944,
'name' => 'Rešetari'
],[
'state_id' => 944,
'name' => 'Ruščica'
],[
'state_id' => 944,
'name' => 'Sibinj'
],[
'state_id' => 944,
'name' => 'Sikirevci'
],[
'state_id' => 944,
'name' => 'Slavonski Brod'
],[
'state_id' => 944,
'name' => 'Slobodnica'
],[
'state_id' => 944,
'name' => 'Stari Perkovci'
],[
'state_id' => 944,
'name' => 'Velika Kopanica'
],[
'state_id' => 944,
'name' => 'Vrpolje'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
