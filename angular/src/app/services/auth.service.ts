import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, BehaviorSubject } from 'rxjs';

import { environment } from '../../environments/environment.prod';
import { Usuario } from '../classes/usuario';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  usuario = new BehaviorSubject<Usuario>(null);
  private userSend(user: Usuario) {
    return this.usuario.next(user);
  }

  constructor(public http: HttpClient) { }

  onRegistro(form_data) {
    this.http.post(environment.api_url + 'auth/register', { dados: form_data });
  }

  onLogin(form_data) {
    this.http.post(environment.api_url + 'auth/login', { dados: form_data });
  }

  onLogout(form_data) {
    this.http.post(environment.api_url + 'auth/logout', { dados: form_data });
  }

}
