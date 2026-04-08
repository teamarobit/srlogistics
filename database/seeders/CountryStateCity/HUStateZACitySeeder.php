<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateZACitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1647,
'name' => 'Becsehely'
],[
'state_id' => 1647,
'name' => 'Cserszegtomaj'
],[
'state_id' => 1647,
'name' => 'Gyenesdiás'
],[
'state_id' => 1647,
'name' => 'Hévíz'
],[
'state_id' => 1647,
'name' => 'Keszthely'
],[
'state_id' => 1647,
'name' => 'Keszthelyi Járás'
],[
'state_id' => 1647,
'name' => 'Lenti'
],[
'state_id' => 1647,
'name' => 'Lenti Járás'
],[
'state_id' => 1647,
'name' => 'Letenye'
],[
'state_id' => 1647,
'name' => 'Letenyei Járás'
],[
'state_id' => 1647,
'name' => 'Murakeresztúr'
],[
'state_id' => 1647,
'name' => 'Nagykanizsa'
],[
'state_id' => 1647,
'name' => 'Nagykanizsai Járás'
],[
'state_id' => 1647,
'name' => 'Pacsa'
],[
'state_id' => 1647,
'name' => 'Sármellék'
],[
'state_id' => 1647,
'name' => 'Türje'
],[
'state_id' => 1647,
'name' => 'Vonyarcvashegy'
],[
'state_id' => 1647,
'name' => 'Zalaegerszeg'
],[
'state_id' => 1647,
'name' => 'Zalaegerszegi Járás'
],[
'state_id' => 1647,
'name' => 'Zalakomár'
],[
'state_id' => 1647,
'name' => 'Zalalövő'
],[
'state_id' => 1647,
'name' => 'Zalaszentgrót'
],[
'state_id' => 1647,
'name' => 'Zalaszentgróti Járás'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
