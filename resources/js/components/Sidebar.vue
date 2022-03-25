<template>
    <nav class="left-menu">
		<div class="logo">
			<a href="/"><img src="img/logo.png"></a>
		</div>
		<ul>
			<li>
				<router-link :to="{name: 'Warehouse'}">
					<span>•</span>
					Товары
					<i class="fa fa-angle-right"></i>
				</router-link>
			</li>
			<li>
				<router-link :to="{name: 'Settings'}">
					<span>•</span>
					Настройки
					<i class="fa fa-angle-right"></i>
				</router-link>
			</li>
		</ul>
	</nav>
</template>