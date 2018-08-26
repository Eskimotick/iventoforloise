import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { AppComponent } from './app.component';
import { NotFoundComponent } from './pages/not-found/not-found.component';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { CadastroComponent } from './pages/cadastro/cadastro.component';
import { AdminUsuariosComponent } from './pages/admin/admin-usuarios/admin-usuarios.component';
import { AdminHospedagemComponent } from './pages/admin/admin-hospedagem/admin-hospedagem.component';
import { AdminConfigComponent } from './pages/admin/admin-config/admin-config.component';
import { DashboardComponent } from './pages/admin/dashboard/dashboard.component';
import { PainelUsuarioComponent } from './pages/user/painel-usuario/painel-usuario.component';
import { AuthGuard } from './guards/auth.guards';


const routes: Routes = [
  { path: '', component: AppComponent },
  { path: 'home', component: HomeComponent },
  { path: 'login', component: LoginComponent },
  { path: 'cadastro', component: CadastroComponent },
  { path: 'usuarios', component: AdminUsuariosComponent },
  { path: 'hospedagem', component: AdminHospedagemComponent },
  { path: 'configuracoes', component: AdminConfigComponent },
  { path: 'painelAdmin', component: DashboardComponent },
  { path: 'painelUsuario', component: PainelUsuarioComponent },
  { path: '**', component: NotFoundComponent }
];

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule {}
