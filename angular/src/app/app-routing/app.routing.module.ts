import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { AppRoutingModule } from './app-routing/app.routing.module';

import { CommonModule } from '@angular/common';

import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { CadastroComponent } from './pages/cadastro/cadastro.component';
import { AdminUsuariosComponent } from './pages/admin/admin-usuarios/admin-usuarios.component';
import { AdminHospedagemComponent } from './pages/admin/admin-hospedagem/admin-hospedagem.component';
import { AppComponent } from './app.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';



const routes: Routes = [

	{
		path: ' ',
		component: HomeComponent
	},
	{
		path: 'login',
		component: LoginComponent
	},
  {
		path: 'cadastro',
		component: CadastroComponent
	},
	{
		path: 'usuarios',
		component: AdminUsuariosComponent
	},
	{
		path: 'hospedagem',
		component: AdminHospedagemComponent
	}
];

@NgModule({
  imports: [
    CommonModule,
    RouterModule.forRoot(routes),
    BrowserModule,
    HttpClientModule,
    AppRoutingModule
  ],
  declarations: [
    HomeComponent,
    LoginComponent,
    CadastroComponent,
    AppComponent,
    NavbarComponent,
    SidebarComponent,
		AdminHospedagemComponent,
		AdminUsuariosComponent

  ],
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
