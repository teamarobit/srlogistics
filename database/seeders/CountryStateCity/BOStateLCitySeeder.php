<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class BOStateLCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 497,
'name' => 'Achacachi'
],[
'state_id' => 497,
'name' => 'Amarete'
],[
'state_id' => 497,
'name' => 'Batallas'
],[
'state_id' => 497,
'name' => 'Caranavi'
],[
'state_id' => 497,
'name' => 'Chulumani'
],[
'state_id' => 497,
'name' => 'Colquiri'
],[
'state_id' => 497,
'name' => 'Coripata'
],[
'state_id' => 497,
'name' => 'Coroico'
],[
'state_id' => 497,
'name' => 'Curahuara de Carangas'
],[
'state_id' => 497,
'name' => 'Eucaliptus'
],[
'state_id' => 497,
'name' => 'Guanay'
],[
'state_id' => 497,
'name' => 'Huarina'
],[
'state_id' => 497,
'name' => 'Huatajata'
],[
'state_id' => 497,
'name' => 'José Manuel Pando'
],[
'state_id' => 497,
'name' => 'La Paz'
],[
'state_id' => 497,
'name' => 'Lahuachaca'
],[
'state_id' => 497,
'name' => 'Mapiri'
],[
'state_id' => 497,
'name' => 'Patacamaya'
],[
'state_id' => 497,
'name' => 'Provincia Aroma'
],[
'state_id' => 497,
'name' => 'Provincia Bautista Saavedra'
],[
'state_id' => 497,
'name' => 'Provincia Camacho'
],[
'state_id' => 497,
'name' => 'Provincia Franz Tamayo'
],[
'state_id' => 497,
'name' => 'Provincia Gualberto Villarroel'
],[
'state_id' => 497,
'name' => 'Provincia Ingavi'
],[
'state_id' => 497,
'name' => 'Provincia Inquisivi'
],[
'state_id' => 497,
'name' => 'Provincia Iturralde'
],[
'state_id' => 497,
'name' => 'Provincia Larecaja'
],[
'state_id' => 497,
'name' => 'Provincia Loayza'
],[
'state_id' => 497,
'name' => 'Provincia Los Andes'
],[
'state_id' => 497,
'name' => 'Provincia Manco Kapac'
],[
'state_id' => 497,
'name' => 'Provincia Murillo'
],[
'state_id' => 497,
'name' => 'Provincia Muñecas'
],[
'state_id' => 497,
'name' => 'Provincia Nor Yungas'
],[
'state_id' => 497,
'name' => 'Provincia Omasuyos'
],[
'state_id' => 497,
'name' => 'Provincia Pacajes'
],[
'state_id' => 497,
'name' => 'Provincia Sud Yungas'
],[
'state_id' => 497,
'name' => 'Quime'
],[
'state_id' => 497,
'name' => 'San Pablo'
],[
'state_id' => 497,
'name' => 'San Pedro'
],[
'state_id' => 497,
'name' => 'Sorata'
],[
'state_id' => 497,
'name' => 'Tiahuanaco'
],[
'state_id' => 497,
'name' => 'Viloco'
],[
'state_id' => 497,
'name' => 'Yumani'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
