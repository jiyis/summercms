@extends('layouts.app')

@section('content')
<div class="row user-con">
	<ul class="user-con-tab">
		<li class="li-active">个人设置</li>
		<li>账户设置</li>
	</ul>
	<div class="user-con-body">
		<div class="user-con-box">
			<form class="form-horizontal col-md-8 col-md-offset-2" role='form'>
				<div class="form-group">
					<label class="col-sm-2 control-label">头像:</label>
					<div class="col-sm-10 ibox-content">
						<div id="crop-avatar" class="col-md-6">
							<div class="avatar-view">
								<div class="avatar-mask">头像上传</div>
								<img src="/assets/img/avatar.jpg">
						    </div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">昵称:</label>
					<div class="col-sm-10">
						<input type="text" name="username" class="form-control" placeholder="kapeter">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">性别:</label>
					<div class="col-sm-10">
						<label class="radio-inline">
						  <input type="radio" name="sex" value="保密"> 保密
						</label>
						<label class="radio-inline">
						  <input type="radio" name="sex" value="男"> 男
						</label>
						<label class="radio-inline">
						  <input type="radio" name="sex" value="女"> 女
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">出生日期:</label>
					<div class="col-sm-10">
						<input type="text" name="birth" class="form-control datetimepicker">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">所在城市:</label>
					<div class="col-sm-10 select-city">
						<div class="col-sm-4">
							<select id="province" name="province" class="col-sm-4 form-control"></select>
						</div>
						<div class="col-sm-4">
							<select id="city" name="city" class="col-sm-4 form-control"></select>
						</div>							
						<div class="col-sm-4">
							<select id="county" name="county" class="col-sm-4 form-control"></select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">个性签名:</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="diy-text" rows="4"></textarea>
						<p>还能输入<span id="text-count"></span>个字符</p>
					</div>
				</div>
			  	<div class="form-group">
			    	<div class="col-sm-offset-2 col-sm-10">
			      		<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i>保 存</button>
			   		</div>
			  	</div>
			</form>
		</div>
		<div class="user-con-box"></div>
	</div>
</div>

<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="avatar-form" action="/user/upload" enctype="multipart/form-data" method="post">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title" id="avatar-modal-label">头像上传</h4>
				</div>
				<div class="modal-body">
					<div class="avatar-body">
						<div class="avatar-upload">
							<input class="avatar-src" name="avatar_src" type="hidden">
							<input class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput">图片上传</label>
							<input class="avatar-input" id="avatarInput" name="avatar_file" type="file"></div>
							<div class="row">
								<div class="col-md-9">
									<div class="avatar-wrapper"></div>
								</div>
								<div class="col-md-3">
									<div class="avatar-preview preview-lg"></div>
									<div class="avatar-preview preview-md"></div>
									<div class="avatar-preview preview-sm"></div>
								</div>
							</div>
						<div class="row avatar-btns">
							<div class="col-md-9">
								<div class="btn-group">
									<button class="btn" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees"><i class="fa fa-undo"></i> 向左旋转</button>
								</div>
								<div class="btn-group">
									<button class="btn" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees"><i class="fa fa-repeat"></i> 向右旋转</button>
								</div>
							</div>
							<div class="col-md-3">
								<button class="btn btn-success btn-block avatar-save" type="submit"><i class="fa fa-save"></i> 保存修改</button>
							</div>
						</div>
					</div>
				</div>
  		</form>
  	</div>
  </div>
</div>

@endsection

