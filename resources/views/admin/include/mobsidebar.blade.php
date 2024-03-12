<!-- m-nav -->
<div id="m-nav" uk-offcanvas="overlay: true">
	<div class="uk-offcanvas-bar">
		<button class="uk-offcanvas-close" type="button" uk-close></button>
		<ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
			<li class="uk-active"><a href="{{route('AdminIndex')}}"><span class="uk-margin-small-right"
						uk-icon="icon: home"></span>
					首页</a></li>
			<li><a href="{{route('OrderList')}}"><span class="uk-margin-small-right" uk-icon="icon: list"></span> Ordini
					Attuali</a></li>
			<li><a href="{{route('TableList')}}"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>
					Tavoli</a></li>
			<li class="uk-parent">
				<a href="#"><span class="uk-margin-small-right" uk-icon="icon: database"></span> 餐点管理</a>
				<ul class="uk-nav-sub">
					<li><a href="{{route('DishList')}}">餐点列表</a></li>
					<li><a href="{{route('AddDishForm')}}">添加餐点</a></li>
				</ul>

			</li>

		</ul>
	</div>
</div>