<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState12CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1768,
'name' => 'Baneh'
],[
'state_id' => 1768,
'name' => 'Bijar'
],[
'state_id' => 1768,
'name' => 'Kamyaran'
],[
'state_id' => 1768,
'name' => 'Marivan'
],[
'state_id' => 1768,
'name' => 'Qorveh'
],[
'state_id' => 1768,
'name' => 'Sanandaj'
],[
'state_id' => 1768,
'name' => 'Saqqez'
],[
'state_id' => 1768,
'name' => 'Dehgolan'
],[
'state_id' => 1768,
'name' => 'Divandarreh'
],[
'state_id' => 1768,
'name' => 'Sarvabad'
],[
'state_id' => 1768,
'name' => 'Armardeh'
],[
'state_id' => 1768,
'name' => 'Boeen-e-Sofla'
],[
'state_id' => 1768,
'name' => 'Kani Sur'
],[
'state_id' => 1768,
'name' => 'Babarashani'
],[
'state_id' => 1768,
'name' => 'Pir Taj'
],[
'state_id' => 1768,
'name' => 'Tup Aghaj'
],[
'state_id' => 1768,
'name' => 'Hasanabad Yasukand'
],[
'state_id' => 1768,
'name' => 'Bolbanabad '
],[
'state_id' => 1768,
'name' => 'Zarrineh '
],[
'state_id' => 1768,
'name' => 'Uraman Takht'
],[
'state_id' => 1768,
'name' => 'Saheb'
],[
'state_id' => 1768,
'name' => 'Shuyesheh'
],[
'state_id' => 1768,
'name' => 'Dezej'
],[
'state_id' => 1768,
'name' => 'Delbaran'
],[
'state_id' => 1768,
'name' => 'Serish Abad'
],[
'state_id' => 1768,
'name' => 'Muchesh'
],[
'state_id' => 1768,
'name' => 'Bardeh Rasheh'
],[
'state_id' => 1768,
'name' => 'Chnare'
],[
'state_id' => 1768,
'name' => 'Kani Dinar'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
