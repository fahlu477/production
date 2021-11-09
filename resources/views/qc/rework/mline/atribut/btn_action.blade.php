<a href="{{route('mline.edit', $row->id)}}" class="btn btn-warning btn-sm" title="Edit Line"><i class="fas fa-edit"></i></a>
<a href="{{ route('luser.create', $row->id)}}" class="btn btn-primary btn-sm" title="Add User Into Line"><i class="fas fa-user-cog"></i></a>
<a href="{{ route('ltarget.see', $row->id)}}" class="btn btn-info btn-sm" title="Add Line to Targer"><i class="fas fa-tasks"></i></a>
