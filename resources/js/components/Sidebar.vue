<template>
	<ul id="accordionSidebar" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" :class="{ 'toggled': isToggled }">

		<router-link :to="{name: 'Home'}" class="sidebar-brand d-flex align-items-center justify-content-center">
			<div class="sidebar-brand-icon rotate-n-15">
				<i class="fas fa-dharmachakra"></i>
			</div>
			<div class="sidebar-brand-text mx-3">WBSKLAD.RU</div>
		</router-link>

		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			Продажи
		</div>

		<li class="nav-item">
			<router-link :to="{name: 'Catalog'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Товары WB</span>
			</router-link>
		</li>

		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			Номенклатура
		</div>

		<li class="nav-item">
			<router-link :to="{name: 'Nomenclatures'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Номенклатура</span>
			</router-link>
		</li>
		<li class="nav-item">
			<router-link :to="{name: 'StockBalances'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Поступления</span>
			</router-link>
		</li>
		<li class="nav-item">
			<router-link :to="{name: 'Services'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Услуги</span>
			</router-link>
		</li>
		<li class="nav-item">
			<router-link :to="{name: 'Contractors'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Контрагенты</span>
			</router-link>
		</li>

		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			Настройки
		</div>

		<li class="nav-item">
			<router-link :to="{name: 'Settings'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Настройки</span>
			</router-link>
		</li>

		<hr class="sidebar-divider">

		<div class="sidebar-heading">
			Отчеты
		</div>

		<li class="nav-item">
			<router-link :to="{name: 'RealizationReports'}" class="nav-link">
				<i class="fas fa-fw fa-tachometer-alt"></i>
				<span>Еженедельные</span>
			</router-link>
		</li>

		<!-- <hr class="sidebar-divider">

		<div class="sidebar-heading">
			Addons
		</div>

		<li class="nav-item">
			<a class="nav-link" href="charts.html">
				<i class="fas fa-fw fa-chart-area"></i>
				<span>Charts</span></a>
		</li>

		<li class="nav-item active">
			<a class="nav-link" href="tables.html">
				<i class="fas fa-fw fa-table"></i>
				<span>Tables</span></a>
		</li> -->

		<hr class="sidebar-divider d-none d-md-block">

		<button @click="toggle()" class="rounded-circle border-0" id="sidebarToggle"></button>

	</ul>
</template>

<script>
export default {
	data() {
		return {
			isToggled: false,
		}
	},
	methods: {
		toggle() {
			if(this.isToggled == true) {
				this.isToggled = false
				document.body.classList.remove('sidebar-toggled')
				return 
			}
			if(this.isToggled == false) {
				this.isToggled = true
				document.body.classList.add('sidebar-toggled')
				return
			}
		}
	}
}
</script>
