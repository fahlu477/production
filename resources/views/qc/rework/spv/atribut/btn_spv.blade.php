@if($row->spv_app == 0)
<form class="form-horizontal row-fluid" action="{{route('spv.approve')}}" method="post">
        @csrf
        <input type="hidden" id="id" class="span10" name="id" value="{{ $row->id }}">
        <input type="hidden" id="spv_app" class="span10" name="spv_app" value="1">
        <input type="hidden" id="spv_name" class="span10" name="spv_name" value="{{ Auth::user()->name }}">
        <button type="submit"  class="btn btn-primary btn-sm" title="OK?"><i class="far fa-check-square"></i></button>
</form>
@elseif($row->spv_app == 1)
<a href="" class="btn btn-success btn-sm" title="Reviewed"><i class="fas fa-user-check"></i></a>
@endif
