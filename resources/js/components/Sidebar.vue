<template>
    <nav class="left-menu">
		<div class="logo">
			<a href="/"><img src="img/logo.png"></a>
		</div>
		<ul>
			<li>
				<router-link :to="{name: 'Catalog'}">
					<span>•</span>
					Товары WB
					<i class="fa fa-angle-right"></i>
				</router-link>
			</li>
			<li>
				<router-link :to="{name: 'Nomenclatures'}">
					<span>•</span>
					Номенклатура
					<i class="fa fa-angle-right"></i>
				</router-link>
			</li>
			<li>
				<router-link :to="{name: 'Contractors'}">
					<span>•</span>
					Контрагенты
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