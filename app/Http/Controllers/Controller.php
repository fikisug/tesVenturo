<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {

        $tahun = $request["tahun"];
        $makanan = array();
        $minuman = array();
        $TotalMenuPerTahun = array();
        $TotalPerBulan = array();
        $TotalMenuPerBulan = array();
        $subTotal = 0;
        
        $bulan = [
            [
                'bulan' => '01',
                'nama'  => 'Jan'
            ],
            [
                'bulan' => '02',
                'nama'  => 'Feb'
            ],
            [
                'bulan' => '03',
                'nama'  => 'Mar'
            ],
            [
                'bulan' => '04',
                'nama'  => 'Apr'
            ],
            [
                'bulan' => '05',
                'nama'  => 'Mei'
            ],
            [
                'bulan' => '06',
                'nama'  => 'Jun'
            ],
            [
                'bulan' => '07',
                'nama'  => 'Jul'
            ],
            [
                'bulan' => '08',
                'nama'  => 'Ags'
            ],
            [
                'bulan' => '09',
                'nama'  => 'Sep'
            ],
            [
                'bulan' => '10',
                'nama'  => 'Okt'
            ],
            [
                'bulan' => '11',
                'nama'  => 'Nov'
            ],
            [
                'bulan' => '12',
                'nama'  => 'Des'
            ],
        ];

        if($tahun != "") {            
            $menu = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/menu"), true);
            $transaksi = json_decode(file_get_contents("http://tes-web.landa.id/intermediate/transaksi?tahun=".$request["tahun"]), true);    
            
            foreach($menu as $menu) {
                if($menu["kategori"] == 'makanan') {
                    $makanan[]["makanan"] = $menu["menu"];
                }
                
                if($menu["kategori"] == 'minuman') {
                    $minuman[]["minuman"] = $menu["menu"];
                }
                
                
                foreach($bulan as $b) {

                    $totalMenuPerBulan = 0;
                    $totalPerMenu = 0;
                    $totalPerBulan = 0;

                    foreach($transaksi as $t) {
                        $timestamps = strtotime($t['tanggal']);

                        $formatbulan = date("m", $timestamps);
                        
                        if($formatbulan == $b['bulan']) {
                            $totalPerBulan = $totalPerBulan + $t["total"];
                        }

                        if($menu["menu"] == $t["menu"]) {
                            $totalPerMenu = $totalPerMenu + $t["total"];
                        }

                        if($formatbulan == $b['bulan'] && $menu['menu'] == $t["menu"]) {
                            $totalMenuPerBulan = $totalMenuPerBulan + $t["total"];
                        }
                        
                        $TotalPerBulan[$b["bulan"]] = $totalPerBulan;
                    }
                    $TotalMenuPerBulan[$menu["menu"]][]["total"] = $totalMenuPerBulan;
                }                
                $TotalMenuPerTahun[$menu['menu']]["subtotal"] = $totalPerMenu;
            }
            foreach($TotalPerBulan as $totalPerBulan) {
                
                $subTotal += $totalPerBulan;
            }
        }
        // dd($TotalMenuPerBulan);
        return view('welcome', [
            "namaBulan" => $bulan,
            "tahun" => $tahun,
            "makanan" => $makanan,
            "minuman" => $minuman,
            "totalMenuPerBulan" => $TotalMenuPerBulan,
            "totalPerBulan" => $TotalPerBulan,
            "totalMenuPerTahun" => $TotalMenuPerTahun,
            "subTotal" => $subTotal,
        ]);
    }
}
