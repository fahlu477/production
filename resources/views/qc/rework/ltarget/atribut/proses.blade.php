@if($row['proses'] == 0)
<a href="" class="btn btn-secondary btn-sm" title="Belum Dikerjakan"><i class="fas fa-spinner"></i></a>
@elseif($row['proses'] == 1)
<a href="" class="btn btn-info btn-sm" title="Sedang Dikerjakan"><i class="fas fa-chalkboard-teacher"></i></a>
@elseif($row['proses'] == 2)
<a href="" class="btn btn-success btn-sm" title="Selesai"><i class="far fa-check-circle"></i></a>
@endif