<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState06CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 949,
'name' => 'Drnje'
],[
'state_id' => 949,
'name' => 'Ferdinandovac'
],[
'state_id' => 949,
'name' => 'Gola'
],[
'state_id' => 949,
'name' => 'Gornja Rijeka'
],[
'state_id' => 949,
'name' => 'Grad Koprivnica'
],[
'state_id' => 949,
'name' => 'Grad Križevci'
],[
'state_id' => 949,
'name' => 'Hlebine'
],[
'state_id' => 949,
'name' => 'Kalinovac'
],[
'state_id' => 949,
'name' => 'Koprivnica'
],[
'state_id' => 949,
'name' => 'Koprivnički Ivanec'
],[
'state_id' => 949,
'name' => 'Križevci'
],[
'state_id' => 949,
'name' => 'Legrad'
],[
'state_id' => 949,
'name' => 'Molve'
],[
'state_id' => 949,
'name' => 'Novo Virje'
],[
'state_id' => 949,
'name' => 'Peteranec'
],[
'state_id' => 949,
'name' => 'Rasinja'
],[
'state_id' => 949,
'name' => 'Reka'
],[
'state_id' => 949,
'name' => 'Sigetec'
],[
'state_id' => 949,
'name' => 'Virje'
],[
'state_id' => 949,
'name' => 'Đelekovec'
],[
'state_id' => 949,
'name' => 'Đurđevac'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
