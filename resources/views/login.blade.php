<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>GGI_IS</title>
	<link type="text/css" href="{{ asset('/assets2/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('/assets2/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('/assets2/css/theme.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('/assets2/images/icons/css/font-awesome.css') }}" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
					<i class="icon-reorder shaded"></i>
				</a>

			  	<a class="brand" href="{{url('/')}}">
                  <img src="{{ asset('/assets/img/PT.-Gistex-Garmen-Indonesia.png') }}" width="120px">
			  	</a>
			</div>
		</div><!-- /navbar-inner -->
	</div><!-- /navbar -->



	<div class="wrapper">
		<div class="container">
			<div class="row">
				<div class="module module-login span4 offset4">
					<form class="form-vertical" method="POST" action="{{ route('login') }}">
                    @csrf
						<div class="module-head">
							<h3>Sign in Here!</h3>
						</div>
						<div class="module-body">
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="text" placeholder="NIK ID" name="nik" value="{{ old('nik') }}" required autocomplete="nik" autofocus>
                                    @error('nik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
							</div>
							<div class="control-group">
								<div class="controls row-fluid">
									<input class="span12" type="password" placeholder="Password" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
							</div>
						</div>
						<div class="module-foot">
							<div class="control-group">
								<div class="controls clearfix">
									@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
											{{ __('Forgot Your Password?') }}
										</a>
									@endif
									<button type="submit" class="btn btn-warning pull-right">Login</button>
								</div>
							</div>
						</div>
					</form>
					@if(session('errors'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Something it's wrong:
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
				</div>
            </div>
            <br><br><br><br>
		</div>
	</div><!--/.wrapper-->

	<div class="footer">
		<div class="container">
        Gistex Garmen Indonesia Information System <b class="copyright">&copy; 2021 </b>
		</div>
	</div>
	<script src="{{asset('/assets2/scripts/jquery-1.9.1.min.js')}" type="text/javascript"></script>
	<script src="{{asset('/assets2/scripts/jquery-ui-1.10.1.custom.min.js')}" type="text/javascript"></script>
	<script src="{{asset('/assets2/bootstrap/js/bootstrap.min.js')}" type="text/javascript"></script>
</body>