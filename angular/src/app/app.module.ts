import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { AppRoutingModule } from './app-routing.module';

import { JwtModule } from '@auth0/angular-jwt';
import { ToastrModule } from 'ngx-toastr';
import { NgxMaskModule } from 'ngx-mask';
import { NgxPaginationModule } from 'ngx-pagination';
import { TooltipModule } from 'ngx-tooltip';

import { AppComponent } from './app.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { NotFoundComponent } from './pages/not-found/not-found.component';
import { HomeComponent } from './pages/home/home.component';
import { LoginComponent } from './pages/login/login.component';
import { CadastroComponent } from './pages/cadastro/cadastro.component';
import { environment } from '../environments/environment';
import { AdminUsuariosComponent } from './pages/admin/admin-usuarios/admin-usuarios.component';
import { AdminHospedagemComponent } from './pages/admin/admin-hospedagem/admin-hospedagem.component';

export function tokenGetter() {
  return localStorage.getItem('token');
}

@NgModule({
  declarations: [
    AppComponent, // root
    NavbarComponent, //navbar
    SidebarComponent, //sidebar
    HomeComponent, // home
    LoginComponent, // login
    CadastroComponent,
    NotFoundComponent,
    AdminUsuariosComponent,
    AdminHospedagemComponent,
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
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
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
