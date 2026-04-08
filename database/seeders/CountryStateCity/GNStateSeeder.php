<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class GNStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 92,
'name' => 'Beyla Prefecture',
'iso2' => 'BE'
],[
'country_id' => 92,
'name' => 'Mandiana Prefecture',
'iso2' => 'MD'
],[
'country_id' => 92,
'name' => 'Yomou Prefecture',
'iso2' => 'YO'
],[
'country_id' => 92,
'name' => 'Fria Prefecture',
'iso2' => 'FR'
],[
'country_id' => 92,
'name' => 'Boké Region',
'iso2' => 'B'
],[
'country_id' => 92,
'name' => 'Labé Region',
'iso2' => 'L'
],[
'country_id' => 92,
'name' => 'Nzérékoré Prefecture',
'iso2' => 'NZ'
],[
'country_id' => 92,
'name' => 'Dabola Prefecture',
'iso2' => 'DB'
],[
'country_id' => 92,
'name' => 'Labé Prefecture',
'iso2' => 'LA'
],[
'country_id' => 92,
'name' => 'Dubréka Prefecture',
'iso2' => 'DU'
],[
'country_id' => 92,
'name' => 'Faranah Prefecture',
'iso2' => 'FA'
],[
'country_id' => 92,
'name' => 'Forécariah Prefecture',
'iso2' => 'FO'
],[
'country_id' => 92,
'name' => 'Nzérékoré Region',
'iso2' => 'N'
],[
'country_id' => 92,
'name' => 'Gaoual Prefecture',
'iso2' => 'GA'
],[
'country_id' => 92,
'name' => 'Conakry',
'iso2' => 'C'
],[
'country_id' => 92,
'name' => 'Télimélé Prefecture',
'iso2' => 'TE'
],[
'country_id' => 92,
'name' => 'Dinguiraye Prefecture',
'iso2' => 'DI'
],[
'country_id' => 92,
'name' => 'Mamou Prefecture',
'iso2' => 'MM'
],[
'country_id' => 92,
'name' => 'Lélouma Prefecture',
'iso2' => 'LE'
],[
'country_id' => 92,
'name' => 'Kissidougou Prefecture',
'iso2' => 'KS'
],[
'country_id' => 92,
'name' => 'Koubia Prefecture',
'iso2' => 'KB'
],[
'country_id' => 92,
'name' => 'Kindia Prefecture',
'iso2' => 'KD'
],[
'country_id' => 92,
'name' => 'Pita Prefecture',
'iso2' => 'PI'
],[
'country_id' => 92,
'name' => 'Kouroussa Prefecture',
'iso2' => 'KO'
],[
'country_id' => 92,
'name' => 'Tougué Prefecture',
'iso2' => 'TO'
],[
'country_id' => 92,
'name' => 'Kankan Region',
'iso2' => 'K'
],[
'country_id' => 92,
'name' => 'Mamou Region',
'iso2' => 'M'
],[
'country_id' => 92,
'name' => 'Boffa Prefecture',
'iso2' => 'BF'
],[
'country_id' => 92,
'name' => 'Mali Prefecture',
'iso2' => 'ML'
],[
'country_id' => 92,
'name' => 'Kindia Region',
'iso2' => 'D'
],[
'country_id' => 92,
'name' => 'Macenta Prefecture',
'iso2' => 'MC'
],[
'country_id' => 92,
'name' => 'Koundara Prefecture',
'iso2' => 'KN'
],[
'country_id' => 92,
'name' => 'Kankan Prefecture',
'iso2' => 'KA'
],[
'country_id' => 92,
'name' => 'Coyah Prefecture',
'iso2' => 'CO'
],[
'country_id' => 92,
'name' => 'Dalaba Prefecture',
'iso2' => 'DL'
],[
'country_id' => 92,
'name' => 'Siguiri Prefecture',
'iso2' => 'SI'
],[
'country_id' => 92,
'name' => 'Lola Prefecture',
'iso2' => 'LO'
],[
'country_id' => 92,
'name' => 'Boké Prefecture',
'iso2' => 'BK'
],[
'country_id' => 92,
'name' => 'Kérouané Prefecture',
'iso2' => 'KE'
],[
'country_id' => 92,
'name' => 'Guéckédou Prefecture',
'iso2' => 'GU'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
