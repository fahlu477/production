<style>
	table, td, th {
  border: 1px solid black;
  }
  table {
    border-collapse: collapse;
  }
			#box1{
				width:180px;
				height:180px;
        padding:10px;
        border: 2px solid grey;
				background:white;
			}
      #tabel{
				width:100%;
				height: auto;
        padding:10px;
        border: 2px solid grey;
				background:white;
			}
      #tab{
        width:100%;
				height: auto;
        border: 1px solid grey;
				background:white;
			}
      #tbl{
        width:100%;
				height: 200px;
        border: 1px solid grey;
				background:white;
			}
      h7 {
        text-decoration: overline;
      }
      input[type=text] {
        width: 100%;
      box-sizing: border-box;
      border: none;
      border-bottom: 2px solid black;
}
.dit {
  width: 180px;
  padding: 3px;
  border: 1px solid black;
  margin: 0;
}
</style>
<!-- Table -->
  <table>
            <thead>
                <tr>
                    <th>
                        <center><font style="color:white">a</font>No<font style="color:white">a</font></center>
                    </th>
                    <th>
                    <center><font style="color:white">aaaa</font>Kode<font style="color:white">aaaa</font></center>
                    </th>
                    <th>
                    <center><font style="color:white">a</font>Nama<font style="color:white">a</font></center>
                    </th>
                    <th>
                    <center><font style="color:white">aa</font>Created At<font style="color:white">aa</font></center>
                    </th>
                    <th>
                    <center><font style="color:white">aa</font>Updated At<font style="color:white">aa</font></center>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php $no=1;?>
            @foreach($modul as $p)
            <tr>
                <td><center>{{ $no }}</center></td>
                <td>{{ $p->kode }}</td>
                <td>{{ $p->nama }}</td>
                <td>{{ $p->created_at }}</td>
                <td>{{ $p->updated_at }}</td>
            </tr>
            <?php $no++ ;?>
            @endforeach
            </tfoot>
    </table>
<!--/.end table-->