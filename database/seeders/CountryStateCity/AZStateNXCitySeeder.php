<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class AZStateNXCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 267,
'name' => 'Cahri'
],[
'state_id' => 267,
'name' => 'Culfa'
],[
'state_id' => 267,
'name' => 'Deste'
],[
'state_id' => 267,
'name' => 'Heydarabad'
],[
'state_id' => 267,
'name' => 'Julfa Rayon'
],[
'state_id' => 267,
'name' => 'Nakhchivan'
],[
'state_id' => 267,
'name' => 'Ordubad'
],[
'state_id' => 267,
'name' => 'Ordubad Rayon'
],[
'state_id' => 267,
'name' => 'Oğlanqala'
],[
'state_id' => 267,
'name' => 'Qıvraq'
],[
'state_id' => 267,
'name' => 'Sedarak'
],[
'state_id' => 267,
'name' => 'Shahbuz Rayon'
],[
'state_id' => 267,
'name' => 'Sharur City'
],[
'state_id' => 267,
'name' => 'Sumbatan-diza'
],[
'state_id' => 267,
'name' => 'Tazakend'
],[
'state_id' => 267,
'name' => 'Yaycı'
],[
'state_id' => 267,
'name' => 'Çalxanqala'
],[
'state_id' => 267,
'name' => 'Şahbuz'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
