@if($row->proses == 0)
<a href="" class="btn btn-secondary btn-sm" title="Belum Dikerjakan"><i class="fas fa-spinner"></i></a>
@elseif($row->proses == 1)
<a href="" class="btn btn-info btn-sm" title="Sedang Dikerjakan"><i class="fas fa-chalkboard-teacher"></i></a>
@elseif($row->proses == 2)
<a href="{{ route('ltarget.show', $row->id)}}" class="btn btn-info btn-sm" title="Show Report"><i class="far fa-eye"></i></a>
@endif