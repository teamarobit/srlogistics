<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState23CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1778,
'name' => 'Eqbaliyeh'
],[
'state_id' => 1778,
'name' => 'Eslamshahr'
],[
'state_id' => 1778,
'name' => 'Malard'
],[
'state_id' => 1778,
'name' => 'Pardis'
],[
'state_id' => 1778,
'name' => 'Pishva'
],[
'state_id' => 1778,
'name' => 'Qarchak'
],[
'state_id' => 1778,
'name' => 'Qods'
],[
'state_id' => 1778,
'name' => 'Rey'
],[
'state_id' => 1778,
'name' => 'Robat Karim'
],[
'state_id' => 1778,
'name' => 'Shahrak-e Emam Hasan'
],[
'state_id' => 1778,
'name' => 'Andisheh'
],[
'state_id' => 1778,
'name' => 'Baharestan'
],[
'state_id' => 1778,
'name' => 'Damavand'
],[
'state_id' => 1778,
'name' => 'Firuzkuh'
],[
'state_id' => 1778,
'name' => 'Pakdasht'
],[
'state_id' => 1778,
'name' => 'Shahriar'
],[
'state_id' => 1778,
'name' => 'Shemiranat'
],[
'state_id' => 1778,
'name' => 'Sharifabad'
],[
'state_id' => 1778,
'name' => 'Soleh Bon'
],[
'state_id' => 1778,
'name' => 'Tehran'
],[
'state_id' => 1778,
'name' => 'Varamin'
],[
'state_id' => 1778,
'name' => 'Taleb abad'
],[
'state_id' => 1778,
'name' => 'Ahmadabad-E Mostowfi'
],[
'state_id' => 1778,
'name' => 'Chahar Dangeh'
],[
'state_id' => 1778,
'name' => 'salehie'
],[
'state_id' => 1778,
'name' => 'Golestan'
],[
'state_id' => 1778,
'name' => 'Nasimshahr'
],[
'state_id' => 1778,
'name' => 'Ferunabad'
],[
'state_id' => 1778,
'name' => 'Bumehen'
],[
'state_id' => 1778,
'name' => 'Absard'
],[
'state_id' => 1778,
'name' => 'Abali'
],[
'state_id' => 1778,
'name' => 'Rudehen'
],[
'state_id' => 1778,
'name' => 'Kilan'
],[
'state_id' => 1778,
'name' => 'Parand'
],[
'state_id' => 1778,
'name' => 'Nasirshahr'
],[
'state_id' => 1778,
'name' => 'Baghershahr'
],[
'state_id' => 1778,
'name' => 'Hasanabad'
],[
'state_id' => 1778,
'name' => 'Shahr-e-Rey'
],[
'state_id' => 1778,
'name' => 'Kahrizak'
],[
'state_id' => 1778,
'name' => 'Tajrish'
],[
'state_id' => 1778,
'name' => 'Shemshak'
],[
'state_id' => 1778,
'name' => 'Fasham'
],[
'state_id' => 1778,
'name' => 'Lavasan'
],[
'state_id' => 1778,
'name' => 'Baghestan'
],[
'state_id' => 1778,
'name' => 'Shahedshahr'
],[
'state_id' => 1778,
'name' => 'Sabashahr'
],[
'state_id' => 1778,
'name' => 'Ferdosiye'
],[
'state_id' => 1778,
'name' => 'Vahidieh'
],[
'state_id' => 1778,
'name' => 'Arjmand'
],[
'state_id' => 1778,
'name' => 'Safadasht'
],[
'state_id' => 1778,
'name' => 'Javadabad'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
