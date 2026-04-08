<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class PEStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 173,
'name' => 'Madre de Dios',
'iso2' => 'MDD'
],[
'country_id' => 173,
'name' => 'Huancavelica',
'iso2' => 'HUV'
],[
'country_id' => 173,
'name' => 'Áncash',
'iso2' => 'ANC'
],[
'country_id' => 173,
'name' => 'Arequipa',
'iso2' => 'ARE'
],[
'country_id' => 173,
'name' => 'Puno',
'iso2' => 'PUN'
],[
'country_id' => 173,
'name' => 'La Libertad',
'iso2' => 'LAL'
],[
'country_id' => 173,
'name' => 'Ucayali',
'iso2' => 'UCA'
],[
'country_id' => 173,
'name' => 'Amazonas',
'iso2' => 'AMA'
],[
'country_id' => 173,
'name' => 'Pasco',
'iso2' => 'PAS'
],[
'country_id' => 173,
'name' => 'Huanuco',
'iso2' => 'HUC'
],[
'country_id' => 173,
'name' => 'Cajamarca',
'iso2' => 'CAJ'
],[
'country_id' => 173,
'name' => 'Tumbes',
'iso2' => 'TUM'
],[
'country_id' => 173,
'name' => 'Cusco',
'iso2' => 'CUS'
],[
'country_id' => 173,
'name' => 'Ayacucho',
'iso2' => 'AYA'
],[
'country_id' => 173,
'name' => 'Junín',
'iso2' => 'JUN'
],[
'country_id' => 173,
'name' => 'San Martín',
'iso2' => 'SAM'
],[
'country_id' => 173,
'name' => 'Lima',
'iso2' => 'LIM'
],[
'country_id' => 173,
'name' => 'Tacna',
'iso2' => 'TAC'
],[
'country_id' => 173,
'name' => 'Piura',
'iso2' => 'PIU'
],[
'country_id' => 173,
'name' => 'Moquegua',
'iso2' => 'MOQ'
],[
'country_id' => 173,
'name' => 'Apurímac',
'iso2' => 'APU'
],[
'country_id' => 173,
'name' => 'Ica',
'iso2' => 'ICA'
],[
'country_id' => 173,
'name' => 'Callao',
'iso2' => 'CAL'
],[
'country_id' => 173,
'name' => 'Lambayeque',
'iso2' => 'LAM'
],[
'country_id' => 173,
'name' => 'Loreto',
'iso2' => 'LOR'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
