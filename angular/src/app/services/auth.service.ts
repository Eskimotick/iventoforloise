import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';

import { environment } from '../../environments/environment.prod';
import { Usuario } from '../classes/usuario';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(public http: HttpClient, public router: Router) { }

  login(email: string, password: string):Observable<any> {

    return this.http.post<any>(environment.api_url + 'login', {
      'email': email,
      'password': password

    }).pipe(tap(res => {
      localStorage.setItem('token', res.data.success.token);
      this.router.navigate(['/painelAdmin']);
    }));
  }

}
