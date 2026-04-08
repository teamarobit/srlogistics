<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HRState19CitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 935,
'name' => 'Cavtat'
],[
'state_id' => 935,
'name' => 'Dubrovačko primorje'
],[
'state_id' => 935,
'name' => 'Grad Dubrovnik'
],[
'state_id' => 935,
'name' => 'Grad Korčula'
],[
'state_id' => 935,
'name' => 'Grad Ploče'
],[
'state_id' => 935,
'name' => 'Komin'
],[
'state_id' => 935,
'name' => 'Konavle'
],[
'state_id' => 935,
'name' => 'Korčula'
],[
'state_id' => 935,
'name' => 'Lastovo'
],[
'state_id' => 935,
'name' => 'Lumbarda'
],[
'state_id' => 935,
'name' => 'Metković'
],[
'state_id' => 935,
'name' => 'Mljet'
],[
'state_id' => 935,
'name' => 'Mokošica'
],[
'state_id' => 935,
'name' => 'Opuzen'
],[
'state_id' => 935,
'name' => 'Općina Lastovo'
],[
'state_id' => 935,
'name' => 'Orebić'
],[
'state_id' => 935,
'name' => 'Podgora'
],[
'state_id' => 935,
'name' => 'Pojezerje'
],[
'state_id' => 935,
'name' => 'Slivno'
],[
'state_id' => 935,
'name' => 'Smokvica'
],[
'state_id' => 935,
'name' => 'Ston'
],[
'state_id' => 935,
'name' => 'Vela Luka'
],[
'state_id' => 935,
'name' => 'Zažablje'
],[
'state_id' => 935,
'name' => 'Čibača'
],[
'state_id' => 935,
'name' => 'Žrnovo'
],[
'state_id' => 935,
'name' => 'Župa dubrovačka'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
