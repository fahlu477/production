@if($row['spv_app'] == 0)
<a href="" class="btn btn-secondary btn-sm" title="Waiting"><i class="fas fa-spinner"></i></a>
@elseif($row['spv_app'] == 1)
<a href="" class="btn btn-success btn-sm" title="Reviewed"><i class="fas fa-user-check"></i></a>
@endif