<?php

namespace Database\Seeders\CountryStateCity;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class HUStateHBCitySeeder extends Seeder
{
	/*** Run the database seeds.*/
	public function run(): void
	{
			$jayParsedAry = [
[
'state_id' => 1664,
'name' => 'Bagamér'
],[
'state_id' => 1664,
'name' => 'Balmazújváros'
],[
'state_id' => 1664,
'name' => 'Balmazújvárosi Járás'
],[
'state_id' => 1664,
'name' => 'Berettyóújfalu'
],[
'state_id' => 1664,
'name' => 'Berettyóújfalui Járás'
],[
'state_id' => 1664,
'name' => 'Biharkeresztes'
],[
'state_id' => 1664,
'name' => 'Biharnagybajom'
],[
'state_id' => 1664,
'name' => 'Báránd'
],[
'state_id' => 1664,
'name' => 'Csökmő'
],[
'state_id' => 1664,
'name' => 'Debrecen'
],[
'state_id' => 1664,
'name' => 'Debreceni Járás'
],[
'state_id' => 1664,
'name' => 'Derecske'
],[
'state_id' => 1664,
'name' => 'Derecskei Járás'
],[
'state_id' => 1664,
'name' => 'Ebes'
],[
'state_id' => 1664,
'name' => 'Egyek'
],[
'state_id' => 1664,
'name' => 'Földes'
],[
'state_id' => 1664,
'name' => 'Görbeháza'
],[
'state_id' => 1664,
'name' => 'Hadjúszoboszlói Járás'
],[
'state_id' => 1664,
'name' => 'Hajdúbagos'
],[
'state_id' => 1664,
'name' => 'Hajdúböszörmény'
],[
'state_id' => 1664,
'name' => 'Hajdúböszörményi Járás'
],[
'state_id' => 1664,
'name' => 'Hajdúdorog'
],[
'state_id' => 1664,
'name' => 'Hajdúhadház'
],[
'state_id' => 1664,
'name' => 'Hajdúhadházi Járás'
],[
'state_id' => 1664,
'name' => 'Hajdúnánás'
],[
'state_id' => 1664,
'name' => 'Hajdúnánási Járás'
],[
'state_id' => 1664,
'name' => 'Hajdúszoboszló'
],[
'state_id' => 1664,
'name' => 'Hajdúszovát'
],[
'state_id' => 1664,
'name' => 'Hajdúsámson'
],[
'state_id' => 1664,
'name' => 'Hortobágy'
],[
'state_id' => 1664,
'name' => 'Hosszúpályi'
],[
'state_id' => 1664,
'name' => 'Kaba'
],[
'state_id' => 1664,
'name' => 'Komádi'
],[
'state_id' => 1664,
'name' => 'Konyár'
],[
'state_id' => 1664,
'name' => 'Létavértes'
],[
'state_id' => 1664,
'name' => 'Mikepércs'
],[
'state_id' => 1664,
'name' => 'Monostorpályi'
],[
'state_id' => 1664,
'name' => 'Nagyrábé'
],[
'state_id' => 1664,
'name' => 'Nyíracsád'
],[
'state_id' => 1664,
'name' => 'Nyíradony'
],[
'state_id' => 1664,
'name' => 'Nyíradonyi Járás'
],[
'state_id' => 1664,
'name' => 'Nyírmártonfalva'
],[
'state_id' => 1664,
'name' => 'Nyírábrány'
],[
'state_id' => 1664,
'name' => 'Nádudvar'
],[
'state_id' => 1664,
'name' => 'Pocsaj'
],[
'state_id' => 1664,
'name' => 'Polgár'
],[
'state_id' => 1664,
'name' => 'Püspökladány'
],[
'state_id' => 1664,
'name' => 'Püspökladányi Járás'
],[
'state_id' => 1664,
'name' => 'Sárrétudvari'
],[
'state_id' => 1664,
'name' => 'Sáránd'
],[
'state_id' => 1664,
'name' => 'Tiszacsege'
],[
'state_id' => 1664,
'name' => 'Téglás'
],[
'state_id' => 1664,
'name' => 'Vámospércs'
],
];
		foreach($jayParsedAry as $data){
		City::create($data);
		}
	}
}
