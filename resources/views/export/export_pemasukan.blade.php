<table>
    <tr>
        <td>Nama pengusul :</td>
        <td>{{ $catatan->nama_user }}</td>
    </tr>
    <tr>
        <td>Unit :</td>
        <td>{{ $catatan->unit }}</td>
    </tr>
        <tr>
        <td>Tanggal :</td>
        <td>{{ $catatan->tanggal_catatan }}</td>
    </tr>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Aset</th>
            <th>Nama Aset</th>
            <th>Tanggal Peroleh</th>
            <th>Nup</th>
            <th>Merk/type</th>
            <th>Jml</th>
            <th>Nilai Barang</th>
            <th>Kondisi</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
    @foreach($barang as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$data->kode_barang}}</td>
            <td class="text-uppercase" >{{$data->nama_barang}}</td>
            <td>{{$data->tanggal_peroleh}}</td>
            <td>{{$data->nup}}</td>
            <td>{{$data->merk_type}}</td>
            <td>{{$data->jumlah}}</td>
            <td>Rp. {{number_format($data->nilai_barang*$data->jumlah,0,",",".") }}</td>
            <td>{{$data->kondisi}}</td>
            <td>{{$data->keterangan}}</td>
        </tr>
    @endforeach
    </tbody>
</table>