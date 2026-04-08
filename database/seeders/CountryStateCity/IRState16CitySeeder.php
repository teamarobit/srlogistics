<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState16CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1751,
'name' => 'Badreh'
],[
'state_id' => 1751,
'name' => 'Chardavol County'
],[
'state_id' => 1751,
'name' => 'Darreh Shahr'
],[
'state_id' => 1751,
'name' => 'Dehloran'
],[
'state_id' => 1751,
'name' => 'Mehran'
],[
'state_id' => 1751,
'name' => 'Eyvan'
],[
'state_id' => 1751,
'name' => 'Malekshahi'
],[
'state_id' => 1751,
'name' => 'Sirvan'
],[
'state_id' => 1751,
'name' => 'abdanan'
],[
'state_id' => 1751,
'name' => 'Ilam'
],[
'state_id' => 1751,
'name' => 'Sarabbagh'
],[
'state_id' => 1751,
'name' => 'Murmuri '
],[
'state_id' => 1751,
'name' => 'Chovar'
],[
'state_id' => 1751,
'name' => 'Zarneh'
],[
'state_id' => 1751,
'name' => 'Bedreh'
],[
'state_id' => 1751,
'name' => 'Aseman Abad'
],[
'state_id' => 1751,
'name' => 'Balavah Tareh'
],[
'state_id' => 1751,
'name' => 'Tohid'
],[
'state_id' => 1751,
'name' => 'Sarableh'
],[
'state_id' => 1751,
'name' => 'Shabab'
],[
'state_id' => 1751,
'name' => 'Mazhin'
],[
'state_id' => 1751,
'name' => 'Pahleh'
],[
'state_id' => 1751,
'name' => 'Mousiyan'
],[
'state_id' => 1751,
'name' => 'Maymeh'
],[
'state_id' => 1751,
'name' => 'Loumar'
],[
'state_id' => 1751,
'name' => 'Arkavaz'
],[
'state_id' => 1751,
'name' => 'Delgosha'
],[
'state_id' => 1751,
'name' => 'Mehr'
],[
'state_id' => 1751,
'name' => 'Saleh Abad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
