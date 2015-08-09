<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

		<style>
			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
				border:none;
				height: 400px;
				color:#666;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 32px;
				margin-bottom: 40px;
			}
		</style>
		<div class="container">
			<div class="content">
				<i class="fa fa-frown-o" style=" font-size: 250px;
"></i>
				<div class="title">Either page doesn't exist at this URL or you typed wrong URL</div>
			</div>
		</div>
@include('footer')		
	</body>
</html>
