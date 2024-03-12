<div class="uk-background-primary uk-light uk-visible@s sidebar">
	<h3><a href="" class="uk-navbar-item uk-logo"><img uk-svg="" src="" class="uk-margin-small-right" hidden="true"><svg
				width="28" height="34" viewBox="0 0 28 34" xmlns="http://www.w3.org/2000/svg"
				class="uk-margin-small-right uk-svg" data-svg="">
				<polygon fill="#fff" points="19.1,4.1 13.75,1 8.17,4.45 13.6,7.44 "></polygon>
				<path fill="#fff"
					d="M21.67,5.43l-5.53,3.34l6.26,3.63v9.52l-8.44,4.76L5.6,21.93v-7.38L0,11.7v13.51l13.75,8.08L28,25.21V9.07 L21.67,5.43z">
				</path>
			</svg> UIkit</a></h3>
	<ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
		<li><a href="{{route('AdminIndex')}}"><span class="uk-margin-small-right" uk-icon="icon: home"></span> HOME</a>
		</li>
		<li class="uk-nav-header"><a href="#">快捷菜单</a></li>

		<li><a href="{{route('OrderList')}}"><span class="uk-margin-small-right" uk-icon="icon: list"></span> Ordini
				Attuali</a></li>
		<li><a href="{{route('TableList')}}"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>
				Tavoli</a></li>
		<li class="uk-nav-divider"></li>
		<li class="uk-nav-header">系统功能</li>
		<li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: users"></span> 会员管理</a></li>
		<li class="uk-parent">
			<a href="#"><span class="uk-margin-small-right" uk-icon="icon: database"></span> 菜品管理</a>
			<ul class="uk-nav-sub">
				<li><a href="{{route('DishList')}}">菜品列表</a></li>
				<li><a href="{{route('AddDishForm')}}">添加菜品</a></li>
			</ul>
		</li>
		<li><a href="{{route('OrderListOld')}}"><span class="uk-margin-small-right" uk-icon="icon: table"></span> Ordini
				Conclusi</a></li>
		<li><a href="{{route('CategoryList')}}"><span class="uk-margin-small-right" uk-icon="icon: table"></span>
				Gestione Dei Gruppi</a></li>
		<li><a href="{{route('MenuList')}}"><span class="uk-margin-small-right" uk-icon="icon: settings"></span>
				Gestione Dei Menù</a></li>


		<li><a href="{{route('adminSettings')}}"><span class="uk-margin-small-right" uk-icon="icon: cog"></span>
				设置</a></li>
		{{-- <li><a href="#"><span class="uk-margin-small-right" uk-icon="icon: trash"></span> 回收站</a></li> --}}

	</ul>
	{{-- <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small" onclick="SendOrder()"><i
			uk-icon="print"></i> Send</a> --}}
</div>