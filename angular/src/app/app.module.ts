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
import { NotFoundComponent } from './components/not-found/not-found.component';
import { HomeComponent } from './components/home/home.component';
import { LoginComponent } from './components/login/login.component';
import { CadastroComponent } from './components/cadastro/cadastro.component';
import { environment } from '../environments/environment';

export function tokenGetter() {
  return localStorage.getItem('token');
}

@NgModule({
  declarations: [
    AppComponent, // root
    HomeComponent, // home
    LoginComponent, // login
    CadastroComponent, // cadastro
    NotFoundComponent, // notfound page
  ],
  imports: [
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
