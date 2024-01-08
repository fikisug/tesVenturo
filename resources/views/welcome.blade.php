<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        td,
        th {
            font-size: 11px;
        }
    </style>


    <title>TES - Venturo Camp Tahap 2</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card" style="margin: 2rem 0rem;">
            <div class="card-header">
                Venturo - Laporan penjualan tahunan per menu
            </div>
            <div class="card-body">
                <form action="/" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <select id="my-select" class="form-control" name="tahun">
                                    <option value="" selected>Pilih Tahun</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary">
                                Tampilkan
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive" id="tabelku">
                    <table class="table table-hover table-bordered" style="margin: 0;">
                        <thead>
                            <tr class="table-dark">
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width: 250px;">Menu</th>
                                    @if (isset($_GET['tahun']) != "")
                                        <th colspan="12" style="text-align: center;">Periode Pada  {{ ($_GET['tahun']) ? $tahun : '' }}
                                    @else
                                        <th colspan="12" style="text-align: center;">Periode Pada 
                                    @endif
                                </th>
                                <th rowspan="2" style="text-align:center;vertical-align: middle;width:75px">Total</th>
                            </tr>
                            <tr class="table-dark">
                                @foreach ($namaBulan as $val)
                                    <th style="text-align: center;width: 75px;">{{ $val['nama'] }}</th> 
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <!-- jika data ditemukan atau terdapat tahun yang dipilih dan tahun tidak kosong -->
                            @if (isset($_GET['tahun']) != "")
                                <tr>
                                    <td class="table-secondary" colspan="14"><b>Makanan</b></td>
                                </tr>
                                @foreach($makanan as $value)
                                    <tr>
                                        <td>{{ $value["makanan"] }}</td>
                                        @foreach($totalMenuPerBulan[$value["makanan"]] as $menu)
                                            <td style="text-align: right;">
                                                {{ $menu["total"] != 0 ? number_format($menu["total"], 0, ',', ',') : '' }}
                                            </td>
                                        @endforeach
                                        <td style="text-align: right; font-weight: bold;">{{ number_format($totalMenuPerTahun[$value["makanan"]]["subtotal"], 0, ',' , ',') }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="table-secondary" colspan="14"><b>Minuman</b></td>
                                </tr>
                                @foreach($minuman as $value)
                                <tr>
                                    <td>{{ $value["minuman"] }}</td>
                                    @foreach($totalMenuPerBulan[$value["minuman"]] as $menu)
                                        <td style="text-align: right;">
                                            {{ $menu["total"] != 0 ? number_format($menu["total"], 0, ',', ',') : '' }}
                                        </td>
                                    @endforeach
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($totalMenuPerTahun[$value["minuman"]]["subtotal"], 0, ',' , ',') }}</td>
                                </tr>
                                @endforeach
                                <tr class="table-dark">
                                    <td class="text-center">Total</td>
                                    @foreach($totalPerBulan as $total)
                                    <td style="text-align: right;">
                                        {{ number_format($total, 0, ',' , ',') }}
                                    </td>
                                    @endforeach
                                    <td style="text-align: right; font-weight: bold;">{{ number_format($subTotal, 0, ',' , ',') }}</td>
                                </tr>
                            @else
                                <!-- jika tidak memilih tahun -->
                                <tr>
                                    <td colspan="14" class="text-center">Data tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
    // Mengecek apakah ada parameter tahun pada URL
    var tahunParameter = new URLSearchParams(window.location.search).get('tahun');

    // Mengatur nilai awal berdasarkan parameter tahun atau default
    if (tahunParameter === "2021") {
        $('#my-select').val('2021');
    } else if (tahunParameter === "2022") {
        $('#my-select').val('2022');
    } else{
        $('#tabelku').hide();
    }
});
    </script>
</body>

</html>