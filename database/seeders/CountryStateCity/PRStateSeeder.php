<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PRStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 178,
'name' => 'San Juan',
'iso2' => 'SJ'
],[
'country_id' => 178,
'name' => 'Bayamon',
'iso2' => 'BY'
],[
'country_id' => 178,
'name' => 'Carolina',
'iso2' => 'CL'
],[
'country_id' => 178,
'name' => 'Ponce',
'iso2' => 'PO'
],[
'country_id' => 178,
'name' => 'Caguas',
'iso2' => 'CG'
],[
'country_id' => 178,
'name' => 'Guaynabo',
'iso2' => 'GN'
],[
'country_id' => 178,
'name' => 'Arecibo',
'iso2' => 'AR'
],[
'country_id' => 178,
'name' => 'Toa Baja',
'iso2' => 'TB'
],[
'country_id' => 178,
'name' => 'Mayagüez',
'iso2' => 'MG'
],[
'country_id' => 178,
'name' => 'Trujillo Alto',
'iso2' => 'TA'
],[
'country_id' => 178,
'name' => 'Adjuntas',
'iso2' => '001'
],[
'country_id' => 178,
'name' => 'Aguada',
'iso2' => '003'
],[
'country_id' => 178,
'name' => 'Aguadilla',
'iso2' => '005'
],[
'country_id' => 178,
'name' => 'Aguas Buenas',
'iso2' => '007'
],[
'country_id' => 178,
'name' => 'Aibonito',
'iso2' => '009'
],[
'country_id' => 178,
'name' => 'Añasco',
'iso2' => '011'
],[
'country_id' => 178,
'name' => 'Arecibo',
'iso2' => '013'
],[
'country_id' => 178,
'name' => 'Arroyo',
'iso2' => '015'
],[
'country_id' => 178,
'name' => 'Barceloneta',
'iso2' => '017'
],[
'country_id' => 178,
'name' => 'Barranquitas',
'iso2' => '019'
],[
'country_id' => 178,
'name' => 'Bayamón',
'iso2' => '021'
],[
'country_id' => 178,
'name' => 'Cabo Rojo',
'iso2' => '023'
],[
'country_id' => 178,
'name' => 'Caguas',
'iso2' => '025'
],[
'country_id' => 178,
'name' => 'Camuy',
'iso2' => '027'
],[
'country_id' => 178,
'name' => 'Canóvanas',
'iso2' => '029'
],[
'country_id' => 178,
'name' => 'Carolina',
'iso2' => '031'
],[
'country_id' => 178,
'name' => 'Cataño',
'iso2' => '033'
],[
'country_id' => 178,
'name' => 'Cayey',
'iso2' => '035'
],[
'country_id' => 178,
'name' => 'Ceiba',
'iso2' => '037'
],[
'country_id' => 178,
'name' => 'Ciales',
'iso2' => '039'
],[
'country_id' => 178,
'name' => 'Cidra',
'iso2' => '041'
],[
'country_id' => 178,
'name' => 'Coamo',
'iso2' => '043'
],[
'country_id' => 178,
'name' => 'Comerío',
'iso2' => '045'
],[
'country_id' => 178,
'name' => 'Corozal',
'iso2' => '047'
],[
'country_id' => 178,
'name' => 'Culebra',
'iso2' => '049'
],[
'country_id' => 178,
'name' => 'Dorado',
'iso2' => '051'
],[
'country_id' => 178,
'name' => 'Fajardo',
'iso2' => '053'
],[
'country_id' => 178,
'name' => 'Florida',
'iso2' => '054'
],[
'country_id' => 178,
'name' => 'Guánica',
'iso2' => '055'
],[
'country_id' => 178,
'name' => 'Guayama',
'iso2' => '057'
],[
'country_id' => 178,
'name' => 'Guayanilla',
'iso2' => '059'
],[
'country_id' => 178,
'name' => 'Guaynabo',
'iso2' => '061'
],[
'country_id' => 178,
'name' => 'Gurabo',
'iso2' => '063'
],[
'country_id' => 178,
'name' => 'Hatillo',
'iso2' => '065'
],[
'country_id' => 178,
'name' => 'Hormigueros',
'iso2' => '067'
],[
'country_id' => 178,
'name' => 'Humacao',
'iso2' => '069'
],[
'country_id' => 178,
'name' => 'Isabela',
'iso2' => '071'
],[
'country_id' => 178,
'name' => 'Jayuya',
'iso2' => '073'
],[
'country_id' => 178,
'name' => 'Juana Díaz',
'iso2' => '075'
],[
'country_id' => 178,
'name' => 'Juncos',
'iso2' => '077'
],[
'country_id' => 178,
'name' => 'Lajas',
'iso2' => '079'
],[
'country_id' => 178,
'name' => 'Lares',
'iso2' => '081'
],[
'country_id' => 178,
'name' => 'Las Marías',
'iso2' => '083'
],[
'country_id' => 178,
'name' => 'Las Piedras',
'iso2' => '085'
],[
'country_id' => 178,
'name' => 'Loíza',
'iso2' => '087'
],[
'country_id' => 178,
'name' => 'Luquillo',
'iso2' => '089'
],[
'country_id' => 178,
'name' => 'Manatí',
'iso2' => '091'
],[
'country_id' => 178,
'name' => 'Maricao',
'iso2' => '093'
],[
'country_id' => 178,
'name' => 'Maunabo',
'iso2' => '095'
],[
'country_id' => 178,
'name' => 'Mayagüez',
'iso2' => '097'
],[
'country_id' => 178,
'name' => 'Moca',
'iso2' => '099'
],[
'country_id' => 178,
'name' => 'Morovis',
'iso2' => '101'
],[
'country_id' => 178,
'name' => 'Naguabo',
'iso2' => '103'
],[
'country_id' => 178,
'name' => 'Naranjito',
'iso2' => '105'
],[
'country_id' => 178,
'name' => 'Orocovis',
'iso2' => '107'
],[
'country_id' => 178,
'name' => 'Patillas',
'iso2' => '109'
],[
'country_id' => 178,
'name' => 'Peñuelas',
'iso2' => '111'
],[
'country_id' => 178,
'name' => 'Ponce',
'iso2' => '113'
],[
'country_id' => 178,
'name' => 'Quebradillas',
'iso2' => '115'
],[
'country_id' => 178,
'name' => 'Rincón',
'iso2' => '117'
],[
'country_id' => 178,
'name' => 'Río Grande',
'iso2' => '119'
],[
'country_id' => 178,
'name' => 'Sabana Grande',
'iso2' => '121'
],[
'country_id' => 178,
'name' => 'Salinas',
'iso2' => '123'
],[
'country_id' => 178,
'name' => 'San Germán',
'iso2' => '125'
],[
'country_id' => 178,
'name' => 'San Juan',
'iso2' => '127'
],[
'country_id' => 178,
'name' => 'San Lorenzo',
'iso2' => '129'
],[
'country_id' => 178,
'name' => 'San Sebastián',
'iso2' => '131'
],[
'country_id' => 178,
'name' => 'Santa Isabel',
'iso2' => '133'
],[
'country_id' => 178,
'name' => 'Toa Alta',
'iso2' => '135'
],[
'country_id' => 178,
'name' => 'Toa Baja',
'iso2' => '137'
],[
'country_id' => 178,
'name' => 'Trujillo Alto',
'iso2' => '139'
],[
'country_id' => 178,
'name' => 'Utuado',
'iso2' => '141'
],[
'country_id' => 178,
'name' => 'Vega Alta',
'iso2' => '143'
],[
'country_id' => 178,
'name' => 'Vega Baja',
'iso2' => '145'
],[
'country_id' => 178,
'name' => 'Vieques',
'iso2' => '147'
],[
'country_id' => 178,
'name' => 'Villalba',
'iso2' => '149'
],[
'country_id' => 178,
'name' => 'Yabucoa',
'iso2' => '151'
],[
'country_id' => 178,
'name' => 'Yauco',
'iso2' => '153'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
