<!-- SEO widgets -->
<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">SEO设置</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::text('seo_title', old('seo_title'), ['class' => 'form-control','placeholder' => 'SEO标题']) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::text('seo_keyword', old('seo_keyword'), ['class' => 'form-control','placeholder' => 'SEO关键词']) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              {!! Form::textarea('seo_description', old('seo_description'), ['class' => 'form-control','placeholder' => '| SEO页面描述','rows'=>'6']) !!}
              {!! Form::hidden('seo_type', $type , ['class' => 'form-control']) !!}
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->