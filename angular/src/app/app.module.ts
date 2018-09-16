import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app.routing.module';
import { MaterializeModule } from 'angular2-materialize';
import { FullCalendarModule } from 'ng-fullcalendar';
import { OwlDateTimeModule, OwlNativeDateTimeModule } from 'ng-pick-datetime';

import { JwtModule } from '@auth0/angular-jwt';
import { ToastrModule } from 'ngx-toastr';
import { NgxMaskModule } from 'ngx-mask';
import { NgxPaginationModule } from 'ngx-pagination';
import { TooltipModule } from 'ngx-tooltip';

import { AppComponent } from './app.component';

/* elementos admin */
import { NavadminComponent } from './components/navadmin/navadmin.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { ContainerAdminComponent } from './components/container-admin/container-admin.component';

/* páginas admin */
import { AdminUsuariosComponent } from './pages/admin/admin-usuarios/admin-usuarios.component';
import { AdminHospedagemComponent } from './pages/admin/admin-hospedagem/admin-hospedagem.component';
import { AdminConfigComponent } from './pages/admin/admin-config/admin-config.component';
import { DashboardComponent } from './pages/admin/dashboard/dashboard.component';

/*usuário */
import { NavusuarioComponent } from './components/navusuario/navusuario.component';
import { SidebarUsuarioComponent } from './components/sidebar-usuario/sidebar-usuario.component';
import { PainelUsuarioComponent} from './pages/user/painel-usuario/painel-usuario.component';

/* visitante */
import { NavbarComponent } from './components/navbar/navbar.component';

/* atividades */
import { AtividadesComponent } from './pages/atividades/atividades.component';
import { DataAtividadePipe } from './pipes/data-atividade.pipe';
import { HoraAtividadePipe } from './pipes/hora-atividade.pipe';

import { NotFoundComponent } from './pages/not-found/not-found.component';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { CadastroComponent } from './pages/cadastro/cadastro.component';
import { environment } from '../environments/environment';

export function tokenGetter() {
  return localStorage.getItem('token');
}

@NgModule({
  declarations: [
    AppComponent, // root
    NavbarComponent, //navbar
    NavadminComponent, // navbar admin
    ContainerAdminComponent , //container principal da área do admin
    SidebarComponent, //sidebar
    HomeComponent, // home
    LoginComponent, // login
    CadastroComponent,
    NotFoundComponent,
    AdminUsuariosComponent,
    AdminConfigComponent,
    AdminHospedagemComponent,
    DashboardComponent, //painel do Admin - mudar nome
    SidebarUsuarioComponent, // sidebar Usuario
    NavusuarioComponent, //Navbar Usuario
    PainelUsuarioComponent, 
    AtividadesComponent, 
    DataAtividadePipe, 
    HoraAtividadePipe
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
    MaterializeModule,
    HttpClientModule, // http
    FormsModule, // forms
    AppRoutingModule, // rotas
    JwtModule.forRoot({
      config: {
        tokenGetter: tokenGetter,
        whitelistedDomains: [ environment.host ],
        blacklistedRoutes: [ environment.api_url + 'auth/' ]
      }
    }),
    ToastrModule.forRoot(), // https://www.npmjs.com/package/ngx-toastr
    BrowserAnimationsModule,
    NgxMaskModule.forRoot(), // https://www.npmjs.com/package/ngx-mask
    NgxPaginationModule, // https://www.npmjs.com/package/ngx-pagination
    TooltipModule, // https://www.npmjs.com/package/ngx-tooltip
    FullCalendarModule, 
    OwlDateTimeModule, 
    OwlNativeDateTimeModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
