import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError, map, tap, do } from 'rxjs/operators';
import { Router } from '@angular/router';

import { environment } from '../../environments/environment.prod';
import { Usuario } from '../classes/usuario';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(public http: HttpClient, public router: Router) { }

  login(email: string, password: string):Observable<any> {
    return this.http.post(environment.api_url + 'login', {
      'admin@admin.com': email,
      'admin': password
    }).pipe(tap(res => {
      localStorage.setItem('token', res.data.success.token);
      this.router.navigate(['/painelAdmin']);
    }));
  }

}
