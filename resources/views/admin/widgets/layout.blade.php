<!-- layouts widgets -->
<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">布局设置</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
          <div class="form-group">
              <div class="col-sm-12">
                  {!! Form::select('layout', $layouts,old('layout'),['class' => 'form-control select2']) !!}
              </div>
          </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->