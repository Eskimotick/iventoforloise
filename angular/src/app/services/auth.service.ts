import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';

import { environment } from '../../environments/environment.prod';
import { Usuario } from '../classes/usuario';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(public http: HttpClient) { }

  login(email: string, password: string):Observable<any> {
    return this.http.post(environment.api_url + 'login', {
      'email': email,
      'password': password
    }).pipe(tap(res => res));
  }

}
