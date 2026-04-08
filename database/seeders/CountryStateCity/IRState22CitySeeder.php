<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class IRState22CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1770,
'name' => 'Bandar Abbas'
],[
'state_id' => 1770,
'name' => 'Bandar Lengeh'
],[
'state_id' => 1770,
'name' => 'Bastak'
],[
'state_id' => 1770,
'name' => 'Kish'
],[
'state_id' => 1770,
'name' => 'Minab'
],[
'state_id' => 1770,
'name' => 'Qeshm'
],[
'state_id' => 1770,
'name' => 'Abu Musa'
],[
'state_id' => 1770,
'name' => 'Bashagard'
],[
'state_id' => 1770,
'name' => 'Jask'
],[
'state_id' => 1770,
'name' => 'Khamir'
],[
'state_id' => 1770,
'name' => 'Parsian'
],[
'state_id' => 1770,
'name' => 'Rudan'
],[
'state_id' => 1770,
'name' => 'Sirik'
],[
'state_id' => 1770,
'name' => 'Hajjiabad'
],[
'state_id' => 1770,
'name' => 'Abumusa '
],[
'state_id' => 1770,
'name' => 'Janah'
],[
'state_id' => 1770,
'name' => 'Sardasht Bashagard'
],[
'state_id' => 1770,
'name' => 'Gouharan'
],[
'state_id' => 1770,
'name' => 'Tazian'
],[
'state_id' => 1770,
'name' => 'Takht'
],[
'state_id' => 1770,
'name' => 'Fin'
],[
'state_id' => 1770,
'name' => 'Qaleh Qazi'
],[
'state_id' => 1770,
'name' => 'Bandar Charak'
],[
'state_id' => 1770,
'name' => 'Bandar Kong'
],[
'state_id' => 1770,
'name' => 'Lemazan'
],[
'state_id' => 1770,
'name' => 'Dashti'
],[
'state_id' => 1770,
'name' => 'Koshkonar'
],[
'state_id' => 1770,
'name' => 'Bandar-e-Jask'
],[
'state_id' => 1770,
'name' => 'Haji Abad'
],[
'state_id' => 1770,
'name' => 'Sargaz'
],[
'state_id' => 1770,
'name' => 'Fareghan'
],[
'state_id' => 1770,
'name' => 'Bandar Khamir'
],[
'state_id' => 1770,
'name' => 'Ruydar'
],[
'state_id' => 1770,
'name' => 'Bikah'
],[
'state_id' => 1770,
'name' => 'Dehbārez'
],[
'state_id' => 1770,
'name' => 'Ziyārat Ali'
],[
'state_id' => 1770,
'name' => 'Kouhestak'
],[
'state_id' => 1770,
'name' => 'Gerouk'
],[
'state_id' => 1770,
'name' => 'Dargahan'
],[
'state_id' => 1770,
'name' => 'Suzā'
],[
'state_id' => 1770,
'name' => 'Hormuz'
],[
'state_id' => 1770,
'name' => 'Tirour'
],[
'state_id' => 1770,
'name' => 'Senderk'
],[
'state_id' => 1770,
'name' => 'Hasht Bandi'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
