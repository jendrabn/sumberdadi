<footer class="section-footer border-top">
	<div class="container">
		<section class="footer-top padding-y">
			<div class="row">
				<aside class="col-md col-6">
					<h6 class="title">{{config('app.name')}}</h6>
					<ul class="list-unstyled">
						<li><a href="{{route('about_us')}}">Tentang Kami</a></li>
                        <li><a href="{{route('user.community.propose')}}">Ajukan Komunitas Baru</a></li>
					</ul>
				</aside>
				<aside class="col-md col-6">
					<h6 class="title">Account</h6>
					<ul class="list-unstyled">
                        <li><a href="{{route('user.overview')}}"> Akun Saya </a></li>
                        <li><a href="{{route('user.orders')}}"> Pesanan Saya </a></li>
                        <li><a href="{{route('login')}}"> Login </a></li>
                        <li><a href="{{route('register')}}"> Register </a></li>
					</ul>
				</aside>
				<aside class="col-md">
					<h6 class="title">Social</h6>
					<ul class="list-unstyled">
						<li><a href="#"> <i class="fab fa-facebook"></i> Facebook </a></li>
						<li><a href="#"> <i class="fab fa-instagram"></i> Instagram </a></li>
						<li><a href="#"> <i class="fab fa-youtube"></i> Youtube </a></li>
					</ul>
				</aside>
			</div> <!-- row.// -->
		</section>	<!-- footer-top.// -->

		<section class="footer-bottom border-top row">
			<div class="col-md-12">
				<p class="text-muted"> &copy {{ date('Y') }} {{ config('app.name') }} </p>
			</div>
		</section>
	</div><!-- //container -->
</footer>
