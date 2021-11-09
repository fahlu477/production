
<!-- Button trigger modal -->
<button type="button" class="btn btn-info btn-sm mb-3" data-toggle="modal" data-target="#modal-import-karyawan-admin"><i class="fas fa-upload"></i> IMPORT</button>

<div class="modal fade" id="modal-import-karyawan-admin" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">IMPORT DATA KARYAWAN <br>
            <small>Pastikan export/backup dulu data karyawan</small></h5>
           
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <b>Upload file data karyawan : </b> <br>
            
            {!! Form::open(['route'=>'karyawan.import_admin','id'=>'frm_import_karyawan_admin', 'files'=>true]) !!}
            <div class="form-group">
                {!! Form::file('file', ['class'=>'form-control', 'required','placeholder'=>'Upload file']) !!}
            </div>
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-sm" form="frm_import_karyawan_admin">SAVE</button>
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>