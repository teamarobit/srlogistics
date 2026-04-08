<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class BFStateSeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'country_id' => 35,
'name' => 'Kénédougou Province',
'iso2' => 'KEN'
],[
'country_id' => 35,
'name' => 'Namentenga Province',
'iso2' => 'NAM'
],[
'country_id' => 35,
'name' => 'Sahel Region',
'iso2' => '12'
],[
'country_id' => 35,
'name' => 'Centre-Ouest Region',
'iso2' => '06'
],[
'country_id' => 35,
'name' => 'Nahouri Province',
'iso2' => 'NAO'
],[
'country_id' => 35,
'name' => 'Passoré Province',
'iso2' => 'PAS'
],[
'country_id' => 35,
'name' => 'Zoundwéogo Province',
'iso2' => 'ZOU'
],[
'country_id' => 35,
'name' => 'Sissili Province',
'iso2' => 'SIS'
],[
'country_id' => 35,
'name' => 'Banwa Province',
'iso2' => 'BAN'
],[
'country_id' => 35,
'name' => 'Bougouriba Province',
'iso2' => 'BGR'
],[
'country_id' => 35,
'name' => 'Gnagna Province',
'iso2' => 'GNA'
],[
'country_id' => 35,
'name' => 'Mouhoun',
'iso2' => 'MOU'
],[
'country_id' => 35,
'name' => 'Yagha Province',
'iso2' => 'YAG'
],[
'country_id' => 35,
'name' => 'Plateau-Central Region',
'iso2' => '11'
],[
'country_id' => 35,
'name' => 'Sanmatenga Province',
'iso2' => 'SMT'
],[
'country_id' => 35,
'name' => 'Centre-Nord Region',
'iso2' => '05'
],[
'country_id' => 35,
'name' => 'Tapoa Province',
'iso2' => 'TAP'
],[
'country_id' => 35,
'name' => 'Houet Province',
'iso2' => 'HOU'
],[
'country_id' => 35,
'name' => 'Zondoma Province',
'iso2' => 'ZON'
],[
'country_id' => 35,
'name' => 'Boulgou',
'iso2' => 'BLG'
],[
'country_id' => 35,
'name' => 'Komondjari Province',
'iso2' => 'KMD'
],[
'country_id' => 35,
'name' => 'Koulpélogo Province',
'iso2' => 'KOP'
],[
'country_id' => 35,
'name' => 'Tuy Province',
'iso2' => 'TUI'
],[
'country_id' => 35,
'name' => 'Ioba Province',
'iso2' => 'IOB'
],[
'country_id' => 35,
'name' => 'Centre',
'iso2' => '03'
],[
'country_id' => 35,
'name' => 'Sourou Province',
'iso2' => 'SOR'
],[
'country_id' => 35,
'name' => 'Boucle du Mouhoun Region',
'iso2' => '01'
],[
'country_id' => 35,
'name' => 'Séno Province',
'iso2' => 'SEN'
],[
'country_id' => 35,
'name' => 'Sud-Ouest Region',
'iso2' => '13'
],[
'country_id' => 35,
'name' => 'Oubritenga Province',
'iso2' => 'OUB'
],[
'country_id' => 35,
'name' => 'Nayala Province',
'iso2' => 'NAY'
],[
'country_id' => 35,
'name' => 'Gourma Province',
'iso2' => 'GOU'
],[
'country_id' => 35,
'name' => 'Oudalan Province',
'iso2' => 'OUD'
],[
'country_id' => 35,
'name' => 'Ziro Province',
'iso2' => 'ZIR'
],[
'country_id' => 35,
'name' => 'Kossi Province',
'iso2' => 'KOS'
],[
'country_id' => 35,
'name' => 'Kourwéogo Province',
'iso2' => 'KOW'
],[
'country_id' => 35,
'name' => 'Ganzourgou Province',
'iso2' => 'GAN'
],[
'country_id' => 35,
'name' => 'Centre-Sud Region',
'iso2' => '07'
],[
'country_id' => 35,
'name' => 'Yatenga Province',
'iso2' => 'YAT'
],[
'country_id' => 35,
'name' => 'Loroum Province',
'iso2' => 'LOR'
],[
'country_id' => 35,
'name' => 'Bazèga Province',
'iso2' => 'BAZ'
],[
'country_id' => 35,
'name' => 'Cascades Region',
'iso2' => '02'
],[
'country_id' => 35,
'name' => 'Sanguié Province',
'iso2' => 'SNG'
],[
'country_id' => 35,
'name' => 'Bam Province',
'iso2' => 'BAM'
],[
'country_id' => 35,
'name' => 'Noumbiel Province',
'iso2' => 'NOU'
],[
'country_id' => 35,
'name' => 'Kompienga Province',
'iso2' => 'KMP'
],[
'country_id' => 35,
'name' => 'Est Region',
'iso2' => '08'
],[
'country_id' => 35,
'name' => 'Léraba Province',
'iso2' => 'LER'
],[
'country_id' => 35,
'name' => 'Balé Province',
'iso2' => 'BAL'
],[
'country_id' => 35,
'name' => 'Kouritenga Province',
'iso2' => 'KOT'
],[
'country_id' => 35,
'name' => 'Centre-Est Region',
'iso2' => '04'
],[
'country_id' => 35,
'name' => 'Poni Province',
'iso2' => 'PON'
],[
'country_id' => 35,
'name' => 'Nord Region, Burkina Faso',
'iso2' => '10'
],[
'country_id' => 35,
'name' => 'Hauts-Bassins Region',
'iso2' => '09'
],[
'country_id' => 35,
'name' => 'Soum Province',
'iso2' => 'SOM'
],[
'country_id' => 35,
'name' => 'Comoé Province',
'iso2' => 'COM'
],[
'country_id' => 35,
'name' => 'Kadiogo Province',
'iso2' => 'KAD'
],
];
		foreach($jayParsedAry as $data){
			State::create($data);
		}
	}
}
